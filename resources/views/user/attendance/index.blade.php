@extends('layouts.dashboard')

@section('title', 'Absensi')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Absensi
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Lakukan verifikasi wajah untuk melakukan absensi.
        </p>
    </div>


    {{-- INFORMASI HARI INI --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Tanggal</p>

            <p class="mt-2 text-lg font-bold text-gray-800">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Jam Masuk</p>

            <p class="mt-2 text-lg font-bold text-gray-800">
                {{ $today?->jam_masuk ?? '-' }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Jam Keluar</p>

            <p class="mt-2 text-lg font-bold text-gray-800">
                {{ $today?->jam_keluar ?? '-' }}
            </p>
        </div>

    </div>


    {{-- BIOMETRIC CARD --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">

        {{-- HEADER --}}
        <div class="border-b border-gray-200 px-5 py-4">

            <h2 class="text-lg font-bold text-gray-800">
                Verifikasi Biometrik Wajah
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Ikuti petunjuk arah wajah yang tampil pada layar.
            </p>

        </div>


        <div class="p-5">

            {{-- STEP --}}
            <div class="mb-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            Langkah Verifikasi
                        </p>

                        <p id="stepText" class="mt-1 text-sm text-gray-500">
                            Langkah 1 dari 3
                        </p>
                    </div>

                    <div
                        id="angleText"
                        class="rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700"
                    >
                        👤 Lihat Lurus
                    </div>

                </div>


                {{-- PROGRESS --}}
                <div class="mt-4 flex gap-2">

                    <div
                        id="progress1"
                        class="h-2 flex-1 rounded-full bg-blue-600"
                    ></div>

                    <div
                        id="progress2"
                        class="h-2 flex-1 rounded-full bg-gray-200"
                    ></div>

                    <div
                        id="progress3"
                        class="h-2 flex-1 rounded-full bg-gray-200"
                    ></div>

                </div>

            </div>


            {{-- CAMERA --}}
            <div class="mx-auto max-w-2xl">

                <div class="relative overflow-hidden rounded-2xl bg-black">

                    <video
                        id="video"
                        autoplay
                        muted
                        playsinline
                        class="aspect-video w-full object-cover"
                    ></video>


                    {{-- FACE GUIDE --}}
                    <div class="pointer-events-none absolute inset-0 flex items-center justify-center">

                        <div
                            id="faceGuide"
                            class="h-72 w-52 rounded-[50%] border-4 border-white/80"
                        ></div>

                    </div>


                    {{-- COUNTDOWN --}}
                    <div
                        id="countdown"
                        class="absolute inset-0 hidden items-center justify-center bg-black/40"
                    >
                        <span
                            id="countdownText"
                            class="text-7xl font-bold text-white"
                        >
                            3
                        </span>
                    </div>


                    {{-- STATUS --}}
                    <div
                        id="cameraStatus"
                        class="absolute bottom-4 left-1/2 w-[90%] -translate-x-1/2 rounded-xl bg-black/60 px-4 py-3 text-center text-sm font-medium text-white"
                    >
                        Memulai kamera...
                    </div>

                </div>


                {{-- CAMERA SELECT --}}
                <div class="mt-4">

                    <label
                        for="cameraSelect"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Pilih Kamera
                    </label>

                    <select
                        id="cameraSelect"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="">
                            Memuat kamera...
                        </option>
                    </select>

                </div>


                {{-- INSTRUCTION --}}
                <div class="mt-5 rounded-xl bg-blue-50 p-4">

                    <p class="font-semibold text-blue-800">
                        Petunjuk
                    </p>

                    <ul class="mt-2 space-y-2 text-sm text-blue-700">

                        <li>
                            👤 Langkah 1: Lihat lurus ke kamera.
                        </li>

                        <li>
                            👈 Langkah 2: Putar wajah ke kiri.
                        </li>

                        <li>
                            👉 Langkah 3: Putar wajah ke kanan.
                        </li>

                    </ul>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="mt-6 flex flex-wrap justify-center gap-3">

                @if(!$user->faceProfile)

                    <button
                        type="button"
                        id="registerFaceButton"
                        class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                        disabled
                    >
                        Daftarkan Wajah
                    </button>

                @else

                    <button
                        type="button"
                        id="checkInButton"
                        class="rounded-xl bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-50"
                        disabled
                    >
                        Absen Masuk
                    </button>

                    <button
                        type="button"
                        id="checkOutButton"
                        class="rounded-xl bg-orange-600 px-6 py-3 font-semibold text-white transition hover:bg-orange-700 disabled:cursor-not-allowed disabled:opacity-50"
                        disabled
                    >
                        Absen Keluar
                    </button>

                @endif

            </div>


            {{-- RESULT --}}
            <div
                id="result"
                class="mt-5 hidden rounded-xl p-4 text-sm"
            ></div>

        </div>

    </div>

</div>


{{-- FACE API --}}
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', async function () {

    const video = document.getElementById('video');
    const cameraSelect = document.getElementById('cameraSelect');

    const cameraStatus = document.getElementById('cameraStatus');
    const angleText = document.getElementById('angleText');
    const stepText = document.getElementById('stepText');

    const countdown = document.getElementById('countdown');
    const countdownText = document.getElementById('countdownText');

    const result = document.getElementById('result');

    const registerFaceButton =
        document.getElementById('registerFaceButton');

    const checkInButton =
        document.getElementById('checkInButton');

    const checkOutButton =
        document.getElementById('checkOutButton');


    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI
    |--------------------------------------------------------------------------
    */

    const MODEL_URL =
        'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights';


    const angles = [
        {
            key: 'front',
            title: '👤 Lihat Lurus'
        },
        {
            key: 'left',
            title: '👈 Lihat ke Kiri'
        },
        {
            key: 'right',
            title: '👉 Lihat ke Kanan'
        }
    ];


    let currentStep = 0;

    let stream = null;

    let modelsLoaded = false;

    let stableFrames = 0;

    let currentDescriptor = null;

    let currentPhoto = null;

    let registrationData = {};

    let cameraReady = false;


    /*
    |--------------------------------------------------------------------------
    | LOKASI KERJA
    |--------------------------------------------------------------------------
    */

    const workLatitude =
        @json($workLocation?->latitude);

    const workLongitude =
        @json($workLocation?->longitude);

    const workRadius =
        @json($workLocation?->radius_meter ?? 100);


    let currentLocation = null;


    /*
    |--------------------------------------------------------------------------
    | LOAD MODEL
    |--------------------------------------------------------------------------
    */

    async function loadModels() {

        cameraStatus.textContent =
            'Memuat sistem pengenalan wajah...';

        try {

            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);

            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);

            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);

            modelsLoaded = true;

            cameraStatus.textContent =
                'Model wajah berhasil dimuat.';

        } catch (error) {

            console.error(error);

            cameraStatus.textContent =
                'Gagal memuat sistem pengenalan wajah.';

            showResult(
                'Gagal memuat model pengenalan wajah. Periksa koneksi internet.',
                'error'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CAMERA
    |--------------------------------------------------------------------------
    */

    async function getCameras() {

        try {

            const devices =
                await navigator.mediaDevices.enumerateDevices();

            const cameras =
                devices.filter(
                    device => device.kind === 'videoinput'
                );

            cameraSelect.innerHTML = '';

            if (cameras.length === 0) {

                cameraSelect.innerHTML =
                    '<option value="">Kamera tidak ditemukan</option>';

                return;

            }


            cameras.forEach((camera, index) => {

                const option =
                    document.createElement('option');

                option.value = camera.deviceId;

                option.textContent =
                    camera.label ||
                    `Kamera ${index + 1}`;

                cameraSelect.appendChild(option);

            });

        } catch (error) {

            console.error(error);

        }

    }


    async function startCamera(deviceId = null) {

        try {

            if (stream) {

                stream.getTracks().forEach(
                    track => track.stop()
                );

            }


            const constraints = {

                video: deviceId
                    ? {
                        deviceId: {
                            exact: deviceId
                        },
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        },
                        facingMode: 'user'
                    }
                    : {
                        facingMode: 'user',
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    },

                audio: false

            };


            stream =
                await navigator.mediaDevices.getUserMedia(
                    constraints
                );


            video.srcObject = stream;

            await video.play();

            cameraReady = true;

            cameraStatus.textContent =
                'Kamera aktif. Posisikan wajah di dalam lingkaran.';


            await getCameras();

        } catch (error) {

            console.error(error);

            cameraReady = false;

            cameraStatus.textContent =
                'Kamera tidak dapat digunakan.';

            showResult(
                'Kamera tidak dapat diakses. Pastikan izin kamera sudah diberikan.',
                'error'
            );

        }

    }


    cameraSelect.addEventListener(
        'change',
        async function () {

            if (this.value) {

                await startCamera(this.value);

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DETEKSI POSISI WAJAH
    |--------------------------------------------------------------------------
    */

    function getFacePosition(landmarks) {

        const nose =
            landmarks.getNose();

        const jaw =
            landmarks.getJawOutline();


        const nosePoint =
            nose[3];


        const leftSide =
            jaw[0];

        const rightSide =
            jaw[16];


        const centerX =
            (leftSide.x + rightSide.x) / 2;


        const faceWidth =
            Math.abs(rightSide.x - leftSide.x);


        if (!faceWidth) {

            return {
                yaw: 0
            };

        }


        const yaw =
            (nosePoint.x - centerX) / faceWidth;


        return {
            yaw
        };

    }


    function isCorrectAngle(angleKey, position) {

        const yaw =
            position.yaw;


        /*
        |--------------------------------------------------------------------------
        | LURUS
        |--------------------------------------------------------------------------
        */

        if (angleKey === 'front') {

            return Math.abs(yaw) < 0.08;

        }


        /*
        |--------------------------------------------------------------------------
        | KIRI
        |--------------------------------------------------------------------------
        */

        if (angleKey === 'left') {

            return yaw < -0.08;

        }


        /*
        |--------------------------------------------------------------------------
        | KANAN
        |--------------------------------------------------------------------------
        */

        if (angleKey === 'right') {

            return yaw > 0.08;

        }


        return false;

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROGRESS
    |--------------------------------------------------------------------------
    */

    function updateProgress() {

        for (let i = 1; i <= 3; i++) {

            const progress =
                document.getElementById(
                    `progress${i}`
                );

            if (!progress) continue;


            if (i <= currentStep) {

                progress.classList.remove(
                    'bg-gray-200'
                );

                progress.classList.add(
                    'bg-green-500'
                );

            } else if (i === currentStep + 1) {

                progress.classList.remove(
                    'bg-gray-200'
                );

                progress.classList.remove(
                    'bg-green-500'
                );

                progress.classList.add(
                    'bg-blue-600'
                );

            } else {

                progress.classList.remove(
                    'bg-blue-600'
                );

                progress.classList.remove(
                    'bg-green-500'
                );

                progress.classList.add(
                    'bg-gray-200'
                );

            }

        }


        if (currentStep < 3) {

            stepText.textContent =
                `Langkah ${currentStep + 1} dari 3`;

            angleText.textContent =
                angles[currentStep].title;

        } else {

            stepText.textContent =
                'Verifikasi selesai';

            angleText.textContent =
                '✅ Wajah berhasil diverifikasi';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | COUNTDOWN
    |--------------------------------------------------------------------------
    */

    async function runCountdown() {

        countdown.classList.remove('hidden');

        countdown.classList.add('flex');


        for (let i = 3; i >= 1; i--) {

            countdownText.textContent = i;

            await new Promise(
                resolve => setTimeout(resolve, 700)
            );

        }


        countdown.classList.remove('flex');

        countdown.classList.add('hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | CAPTURE FOTO
    |--------------------------------------------------------------------------
    */

    function capturePhoto() {

        const canvas =
            document.createElement('canvas');

        canvas.width =
            video.videoWidth;

        canvas.height =
            video.videoHeight;


        const context =
            canvas.getContext('2d');


        context.drawImage(
            video,
            0,
            0,
            canvas.width,
            canvas.height
        );


        return canvas.toDataURL(
            'image/jpeg',
            0.85
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SCAN WAJAH
    |--------------------------------------------------------------------------
    */

    async function scanFace() {

        if (
            !modelsLoaded ||
            !cameraReady ||
            currentStep >= 3
        ) {

            return;

        }


        try {

            const detection =
                await faceapi
                    .detectSingleFace(
                        video,
                        new faceapi.TinyFaceDetectorOptions({
                            inputSize: 320,
                            scoreThreshold: 0.5
                        })
                    )
                    .withFaceLandmarks()
                    .withFaceDescriptor();


            if (!detection) {

                stableFrames = 0;

                cameraStatus.textContent =
                    'Wajah tidak terdeteksi. Posisikan wajah di dalam lingkaran.';

                return;

            }


            const position =
                getFacePosition(
                    detection.landmarks
                );


            const currentAngle =
                angles[currentStep];


            const correct =
                isCorrectAngle(
                    currentAngle.key,
                    position
                );


            if (!correct) {

                stableFrames = 0;

                if (
                    currentAngle.key === 'front'
                ) {

                    cameraStatus.textContent =
                        'Silakan lihat lurus ke kamera.';

                } else if (
                    currentAngle.key === 'left'
                ) {

                    cameraStatus.textContent =
                        'Silakan putar wajah ke kiri.';

                } else {

                    cameraStatus.textContent =
                        'Silakan putar wajah ke kanan.';

                }

                return;

            }


            stableFrames++;


            cameraStatus.textContent =
                `Posisi benar. Tahan... ${Math.min(
                    stableFrames,
                    5
                )}/5`;


            if (stableFrames >= 5) {

                stableFrames = 0;

                await runCountdown();


                const descriptor =
                    Array.from(
                        detection.descriptor
                    );


                const photo =
                    capturePhoto();


                registrationData[
                    currentAngle.key
                ] = descriptor;


                currentDescriptor =
                    descriptor;


                currentPhoto =
                    photo;


                currentStep++;


                updateProgress();


                if (currentStep >= 3) {

                    cameraStatus.textContent =
                        'Verifikasi wajah selesai.';

                    await finishFaceVerification();

                } else {

                    cameraStatus.textContent =
                        `Lanjutkan ke langkah berikutnya: ${angles[currentStep].title}`;

                }

            }

        } catch (error) {

            console.error(
                'Face detection error:',
                error
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | LOOP DETEKSI
    |--------------------------------------------------------------------------
    */

    setInterval(
        scanFace,
        500
    );


    /*
    |--------------------------------------------------------------------------
    | FINISH FACE VERIFICATION
    |--------------------------------------------------------------------------
    */

    async function finishFaceVerification() {

        registerFaceButton &&
            (registerFaceButton.disabled = false);


        checkInButton &&
            (checkInButton.disabled = false);


        checkOutButton &&
            (checkOutButton.disabled = false);


        showResult(
            'Verifikasi wajah berhasil. Silakan lanjutkan proses absensi.',
            'success'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | GPS
    |--------------------------------------------------------------------------
    */

    function getLocation() {

        return new Promise(
            (resolve, reject) => {

                if (!navigator.geolocation) {

                    reject(
                        new Error(
                            'Browser tidak mendukung GPS.'
                        )
                    );

                    return;

                }


                navigator.geolocation.getCurrentPosition(

                    position => {

                        currentLocation = {

                            latitude:
                                position.coords.latitude,

                            longitude:
                                position.coords.longitude,

                            accuracy:
                                position.coords.accuracy

                        };


                        resolve(
                            currentLocation
                        );

                    },

                    error => {

                        reject(error);

                    },

                    {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }

                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG JARAK
    |--------------------------------------------------------------------------
    */

    function calculateDistance(
        lat1,
        lon1,
        lat2,
        lon2
    ) {

        const earthRadius =
            6371000;


        const dLat =
            (lat2 - lat1) *
            Math.PI / 180;


        const dLon =
            (lon2 - lon1) *
            Math.PI / 180;


        const a =
            Math.sin(dLat / 2) ** 2
            +
            Math.cos(
                lat1 * Math.PI / 180
            )
            *
            Math.cos(
                lat2 * Math.PI / 180
            )
            *
            Math.sin(dLon / 2) ** 2;


        const c =
            2 *
            Math.atan2(
                Math.sqrt(a),
                Math.sqrt(1 - a)
            );


        return earthRadius * c;

    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER FACE
    |--------------------------------------------------------------------------
    */

    async function registerFace() {

        if (currentStep < 3) {

            showResult(
                'Silakan selesaikan seluruh proses verifikasi wajah terlebih dahulu.',
                'error'
            );

            return;

        }


        registerFaceButton.disabled = true;

        registerFaceButton.textContent =
            'Menyimpan...';


        try {

            const response =
                await fetch(
                    "{{ route('user.attendance.register-face') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                "{{ csrf_token() }}",

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            face_data:
                                JSON.stringify(
                                    registrationData
                                ),

                            photo:
                                currentPhoto

                        })

                    }
                );


            const data =
                await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'Gagal mendaftarkan wajah.'
                );

            }


            showResult(
                data.message,
                'success'
            );


            setTimeout(
                () => location.reload(),
                1500
            );


        } catch (error) {

            console.error(error);

            showResult(
                error.message,
                'error'
            );


            registerFaceButton.disabled =
                false;

            registerFaceButton.textContent =
                'Daftarkan Wajah';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CHECK IN
    |--------------------------------------------------------------------------
    */

    async function checkIn() {

        if (currentStep < 3 || !currentDescriptor) {

            showResult(
                'Silakan lakukan verifikasi wajah terlebih dahulu.',
                'error'
            );

            return;

        }


        checkInButton.disabled = true;

        checkInButton.textContent =
            'Memproses...';


        try {

            const location =
                await getLocation();


            if (
                workLatitude === null ||
                workLongitude === null
            ) {

                throw new Error(
                    'Lokasi kerja belum dikonfigurasi.'
                );

            }


            const distance =
                calculateDistance(
                    location.latitude,
                    location.longitude,
                    Number(workLatitude),
                    Number(workLongitude)
                );


            if (distance > Number(workRadius)) {

                throw new Error(
                    `Anda berada di luar area absensi. Jarak Anda sekitar ${Math.round(distance)} meter.`
                );

            }


            const photo =
                capturePhoto();


            const response =
                await fetch(
                    "{{ route('user.attendance.check-in') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                "{{ csrf_token() }}",

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            latitude:
                                location.latitude,

                            longitude:
                                location.longitude,

                            accuracy:
                                location.accuracy,

                            face_data:
                                JSON.stringify(
                                    currentDescriptor
                                ),

                            photo:
                                photo

                        })

                    }
                );


            const data =
                await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'Gagal melakukan absen masuk.'
                );

            }


            showResult(
                data.message,
                'success'
            );


            setTimeout(
                () => location.reload(),
                1500
            );


        } catch (error) {

            console.error(error);

            showResult(
                error.message,
                'error'
            );


            checkInButton.disabled =
                false;

            checkInButton.textContent =
                'Absen Masuk';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CHECK OUT
    |--------------------------------------------------------------------------
    */

    async function checkOut() {

        if (currentStep < 3 || !currentDescriptor) {

            showResult(
                'Silakan lakukan verifikasi wajah terlebih dahulu.',
                'error'
            );

            return;

        }


        checkOutButton.disabled = true;

        checkOutButton.textContent =
            'Memproses...';


        try {

            const location =
                await getLocation();


            if (
                workLatitude === null ||
                workLongitude === null
            ) {

                throw new Error(
                    'Lokasi kerja belum dikonfigurasi.'
                );

            }


            const distance =
                calculateDistance(
                    location.latitude,
                    location.longitude,
                    Number(workLatitude),
                    Number(workLongitude)
                );


            if (distance > Number(workRadius)) {

                throw new Error(
                    `Anda berada di luar area absensi. Jarak Anda sekitar ${Math.round(distance)} meter.`
                );

            }


            const photo =
                capturePhoto();


            const response =
                await fetch(
                    "{{ route('user.attendance.check-out') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                "{{ csrf_token() }}",

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            latitude:
                                location.latitude,

                            longitude:
                                location.longitude,

                            accuracy:
                                location.accuracy,

                            face_data:
                                JSON.stringify(
                                    currentDescriptor
                                ),

                            photo:
                                photo

                        })

                    }
                );


            const data =
                await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message ||
                    'Gagal melakukan absen keluar.'
                );

            }


            showResult(
                data.message,
                'success'
            );


            setTimeout(
                () => location.reload(),
                1500
            );


        } catch (error) {

            console.error(error);

            showResult(
                error.message,
                'error'
            );


            checkOutButton.disabled =
                false;

            checkOutButton.textContent =
                'Absen Keluar';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | RESULT
    |--------------------------------------------------------------------------
    */

    function showResult(
        message,
        type = 'success'
    ) {

        result.classList.remove(
            'hidden',
            'bg-green-100',
            'text-green-700',
            'bg-red-100',
            'text-red-700'
        );


        if (type === 'success') {

            result.classList.add(
                'bg-green-100',
                'text-green-700'
            );

        } else {

            result.classList.add(
                'bg-red-100',
                'text-red-700'
            );

        }


        result.textContent =
            message;

    }


    /*
    |--------------------------------------------------------------------------
    | BUTTON EVENTS
    |--------------------------------------------------------------------------
    */

    if (registerFaceButton) {

        registerFaceButton.addEventListener(
            'click',
            registerFace
        );

    }


    if (checkInButton) {

        checkInButton.addEventListener(
            'click',
            checkIn
        );

    }


    if (checkOutButton) {

        checkOutButton.addEventListener(
            'click',
            checkOut
        );

    }


    /*
    |--------------------------------------------------------------------------
    | START
    |--------------------------------------------------------------------------
    */

    updateProgress();

    await loadModels();

    await startCamera();

});

</script>
@endsection