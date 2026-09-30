<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\FaceProfile;
use App\Models\WorkLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN ABSENSI
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user()->load('faceProfile');

        $workLocation = WorkLocation::where('active', true)
            ->first();

        $today = Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        return view(
            'user.attendance.index',
            compact(
                'user',
                'workLocation',
                'today'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER WAJAH
    |--------------------------------------------------------------------------
    |
    | Sekarang menggunakan 3 arah:
    | front, left, right
    |
    */

    public function registerFace(Request $request)
    {
        $validated = $request->validate([
            'face_data' => [
                'required',
                'string',
            ],

            'photo' => [
                'nullable',
                'string',
            ],
        ]);


        $faceData =
            json_decode(
                $validated['face_data'],
                true
            );


        if (!is_array($faceData)) {

            return response()->json([
                'success' => false,
                'message' => 'Data wajah tidak valid.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | 3 SUDUT WAJAH
        |--------------------------------------------------------------------------
        */

        $requiredAngles = [
            'front',
            'left',
            'right',
        ];


        foreach ($requiredAngles as $angle) {

            if (
                !isset($faceData[$angle]) ||
                !is_array($faceData[$angle]) ||
                count($faceData[$angle]) < 10
            ) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        "Data wajah untuk sudut {$angle} belum lengkap.",
                ], 422);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN FOTO WAJAH
        |--------------------------------------------------------------------------
        */

        $photoPath = null;

if ($request->filled('photo')) {

    $photo = $request->input('photo');

    if (str_contains($photo, ',')) {
        $photo = explode(',', $photo, 2)[1];
    }

    $photoData = base64_decode($photo);

    if ($photoData === false) {
        return response()->json([
            'success' => false,
            'message' => 'Foto absensi tidak valid.',
        ], 422);
    }

    $fileName = 'attendance_' .
        auth()->id() . '_' .
        now()->format('Ymd_His') .
        '.jpg';

    $photoPath = 'attendance/' . $fileName;

    Storage::disk('public')->put(
        $photoPath,
        $photoData
    );
}

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA WAJAH
        |--------------------------------------------------------------------------
        */

        FaceProfile::updateOrCreate(

            [
                'user_id' =>
                    auth()->id(),
            ],

            [
                'face_data' =>
                    json_encode($faceData),

                'foto' =>
                    $photoPath,

                'registered_at' =>
                    now(),
            ]

        );


        return response()->json([
            'success' => true,
            'message' =>
                'Pendaftaran wajah 3 sudut berhasil.',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK IN
    |--------------------------------------------------------------------------
    */

    public function checkIn(Request $request)
    {
        $validated = $request->validate([

            'latitude' => [
                'required',
                'numeric',
            ],

            'longitude' => [
                'required',
                'numeric',
            ],

            'accuracy' => [
                'nullable',
                'numeric',
            ],

            'face_data' => [
                'required',
                'string',
            ],

            'photo' => [
                'required',
                'string',
            ],

        ]);


        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | CEK WAJAH TERDAFTAR
        |--------------------------------------------------------------------------
        */

        $faceProfile =
            FaceProfile::where(
                'user_id',
                $user->id
            )->first();


        if (!$faceProfile) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah belum didaftarkan.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI WAJAH
        |--------------------------------------------------------------------------
        */

        if (
            !$this->verifyFace(
                $faceProfile->face_data,
                $validated['face_data']
            )
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah tidak cocok dengan data wajah yang terdaftar.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK ABSEN HARI INI
        |--------------------------------------------------------------------------
        */

        $attendance =
            Attendance::where(
                'user_id',
                $user->id
            )
                ->whereDate(
                    'tanggal',
                    today()
                )
                ->first();


        if (
            $attendance &&
            $attendance->jam_masuk
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Anda sudah melakukan absen masuk hari ini.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | LOKASI KERJA
        |--------------------------------------------------------------------------
        */

        $workLocation =
            WorkLocation::where(
                'active',
                true
            )->first();


        if (!$workLocation) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Lokasi kerja belum dikonfigurasi.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG JARAK
        |--------------------------------------------------------------------------
        */

        $distance =
            $this->calculateDistance(

                (float) $validated['latitude'],

                (float) $validated['longitude'],

                (float) $workLocation->latitude,

                (float) $workLocation->longitude

            );


        if (
            $distance >
            $workLocation->radius_meter
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Anda berada di luar area absensi. Jarak Anda sekitar '
                    . round($distance, 2)
                    . ' meter dari lokasi kerja.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK AKURASI GPS
        |--------------------------------------------------------------------------
        */

        if (
            isset($validated['accuracy']) &&
            $validated['accuracy'] !== null &&
            $validated['accuracy'] > 100
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Akurasi lokasi terlalu rendah.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now();


        $batasMasuk =
            Carbon::today()
                ->setTime(7, 0, 0);


        $status =
            $now->gt($batasMasuk)
                ? 'terlambat'
                : 'hadir';


        $terlambatDetik =
            $now->gt($batasMasuk)
                ? $batasMasuk->diffInSeconds($now)
                : 0;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN FOTO
        |--------------------------------------------------------------------------
        */

        $photoPath =
            $this->saveBase64Photo(
                $validated['photo'],
                'attendance'
            );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN ABSENSI
        |--------------------------------------------------------------------------
        */

        $attendance =
            Attendance::updateOrCreate(

                [
                    'user_id' =>
                        $user->id,

                    'tanggal' =>
                        today(),
                ],

                [

                    'jam_masuk' =>
                        $now->format('H:i:s'),

                    'status' =>
                        $status,

                    'terlambat_detik' =>
                        $terlambatDetik,

                    'latitude' =>
                        $validated['latitude'],

                    'longitude' =>
                        $validated['longitude'],

                    'accuracy' =>
                        $validated['accuracy'] ?? null,

                    'jarak_meter' =>
                        $distance,

                    'foto' =>
                        $photoPath,

                ]

            );


        return response()->json([

            'success' => true,

            'message' =>
                'Absen masuk berhasil.',

            'attendance' =>
                $attendance,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK OUT
    |--------------------------------------------------------------------------
    */

    public function checkOut(Request $request)
    {
        $validated = $request->validate([

            'latitude' => [
                'required',
                'numeric',
            ],

            'longitude' => [
                'required',
                'numeric',
            ],

            'accuracy' => [
                'nullable',
                'numeric',
            ],

            'face_data' => [
                'required',
                'string',
            ],

            'photo' => [
                'required',
                'string',
            ],

        ]);


        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | CEK WAJAH
        |--------------------------------------------------------------------------
        */

        $faceProfile =
            FaceProfile::where(
                'user_id',
                $user->id
            )->first();


        if (!$faceProfile) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah belum didaftarkan.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI WAJAH
        |--------------------------------------------------------------------------
        */

        if (
            !$this->verifyFace(
                $faceProfile->face_data,
                $validated['face_data']
            )
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Wajah tidak cocok dengan data wajah yang terdaftar.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | ABSENSI HARI INI
        |--------------------------------------------------------------------------
        */

        $attendance =
            Attendance::where(
                'user_id',
                $user->id
            )
                ->whereDate(
                    'tanggal',
                    today()
                )
                ->first();


        if (!$attendance) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Data absen masuk hari ini belum ditemukan.',
            ], 422);

        }


        if ($attendance->jam_keluar) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Anda sudah melakukan absen keluar hari ini.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | LOKASI KERJA
        |--------------------------------------------------------------------------
        */

        $workLocation =
            WorkLocation::where(
                'active',
                true
            )->first();


        if (!$workLocation) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Lokasi kerja belum dikonfigurasi.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG JARAK
        |--------------------------------------------------------------------------
        */

        $distance =
            $this->calculateDistance(

                (float) $validated['latitude'],

                (float) $validated['longitude'],

                (float) $workLocation->latitude,

                (float) $workLocation->longitude

            );


        if (
            $distance >
            $workLocation->radius_meter
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Anda berada di luar area absensi.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | CEK AKURASI
        |--------------------------------------------------------------------------
        */

        if (
            isset($validated['accuracy']) &&
            $validated['accuracy'] !== null &&
            $validated['accuracy'] > 100
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Akurasi lokasi terlalu rendah.',
            ], 422);

        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU KELUAR
        |--------------------------------------------------------------------------
        */

        $now =
            Carbon::now();


        $batasKeluar =
            Carbon::today()
                ->setTime(15, 0, 0);


        /*
        |--------------------------------------------------------------------------
        | FOTO KELUAR
        |--------------------------------------------------------------------------
        |
        | Untuk sementara foto absensi TIDAK ditimpa.
        | Jadi foto pada riwayat tetap foto saat absen masuk.
        |
        */

        $attendance->update([

            'jam_keluar' =>
                $now->format('H:i:s'),

            'latitude' =>
                $validated['latitude'],

            'longitude' =>
                $validated['longitude'],

            'accuracy' =>
                $validated['accuracy'] ?? null,

            'jarak_meter' =>
                $distance,

        ]);


        return response()->json([

            'success' => true,

            'message' =>
                $now->lt($batasKeluar)

                    ? 'Absen keluar berhasil. Anda melakukan absen sebelum pukul 15:00.'

                    : 'Absen keluar berhasil.',

            'attendance' =>
                $attendance,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI WAJAH
    |--------------------------------------------------------------------------
    */

    private function verifyFace(
        string $storedFaceData,
        string $currentFaceData
    ): bool {

        $stored =
            json_decode(
                $storedFaceData,
                true
            );


        $current =
            json_decode(
                $currentFaceData,
                true
            );


        if (
            !is_array($stored) ||
            !is_array($current)
        ) {

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | DATA WAJAH TERDAFTAR
        |--------------------------------------------------------------------------
        */

        $storedDescriptors = [];


        foreach (
            [
                'front',
                'left',
                'right',
            ] as $angle
        ) {

            if (
                isset($stored[$angle]) &&
                is_array($stored[$angle])
            ) {

                $storedDescriptors[] =
                    $stored[$angle];

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KOMPATIBILITAS DATA LAMA
        |--------------------------------------------------------------------------
        */

        if (
            empty($storedDescriptors)
        ) {

            $storedDescriptors[] =
                $stored;

        }


        /*
        |--------------------------------------------------------------------------
        | DATA WAJAH SAAT ABSEN
        |--------------------------------------------------------------------------
        */

        if (
            isset($current[0]) &&
            is_numeric($current[0])
        ) {

            $currentDescriptor =
                $current;

        } else {

            return false;

        }


        /*
        |--------------------------------------------------------------------------
        | CARI JARAK TERDEKAT
        |--------------------------------------------------------------------------
        */

        $bestDistance =
            PHP_FLOAT_MAX;


        foreach (
            $storedDescriptors
            as $descriptor
        ) {

            if (
                count($descriptor) !==
                count($currentDescriptor)
            ) {

                continue;

            }


            $sum = 0;


            for (
                $i = 0;
                $i < count($descriptor);
                $i++
            ) {

                $difference =
                    (float) $descriptor[$i]
                    -
                    (float) $currentDescriptor[$i];


                $sum +=
                    $difference *
                    $difference;

            }


            $distance =
                sqrt($sum);


            if (
                $distance <
                $bestDistance
            ) {

                $bestDistance =
                    $distance;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | THRESHOLD
        |--------------------------------------------------------------------------
        */

        return $bestDistance <= 0.5;
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN FOTO BASE64
    |--------------------------------------------------------------------------
    */

    private function saveBase64Photo(
        string $base64,
        string $folder
    ): ?string {

        if (
            !str_contains(
                $base64,
                ','
            )
        ) {

            return null;

        }


        [
            $meta,
            $data
        ] =
            explode(
                ',',
                $base64,
                2
            );


        $extension =
            'jpg';


        if (
            str_contains(
                $meta,
                'image/png'
            )
        ) {

            $extension =
                'png';

        }


        $filename =
            $folder
            . '/'
            . auth()->id()
            . '_'
            . now()->format('Ymd_His')
            . '_'
            . uniqid()
            . '.'
            . $extension;


        Storage::disk('public')->put(

            $filename,

            base64_decode($data)

        );


        return $filename;
    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG JARAK GPS
    |--------------------------------------------------------------------------
    */

    private function calculateDistance(
        float $latitudeFrom,
        float $longitudeFrom,
        float $latitudeTo,
        float $longitudeTo
    ): float {

        $earthRadius =
            6371000;


        $latFrom =
            deg2rad(
                $latitudeFrom
            );


        $latTo =
            deg2rad(
                $latitudeTo
            );


        $latDelta =
            deg2rad(
                $latitudeTo -
                $latitudeFrom
            );


        $lonDelta =
            deg2rad(
                $longitudeTo -
                $longitudeFrom
            );


        $a =
            sin($latDelta / 2) ** 2
            +
            cos($latFrom)
            *
            cos($latTo)
            *
            sin($lonDelta / 2) ** 2;


        $c =
            2 *
            atan2(
                sqrt($a),
                sqrt(1 - $a)
            );


        return
            $earthRadius *
            $c;
    }


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT ABSENSI
    |--------------------------------------------------------------------------
    */

    public function history()
    {
        $attendances =
            Attendance::where(
                'user_id',
                auth()->id()
            )
                ->latest('tanggal')
                ->latest('jam_masuk')
                ->get();


        return view(
            'user.attendance.history',
            compact('attendances')
        );
    }
}