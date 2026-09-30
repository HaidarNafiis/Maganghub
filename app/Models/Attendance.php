<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'terlambat_detik',
        'latitude',
        'longitude',
        'accuracy',
        'jarak_meter',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
        'accuracy' => 'float',
        'jarak_meter' => 'float',
        'terlambat_detik' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS MASUK
    |--------------------------------------------------------------------------
    */

    public function getStatusMasukAttribute()
    {
        if (!$this->jam_masuk) {
            return 'Belum Absen';
        }

        $jamMasuk = Carbon::parse($this->jam_masuk);
        $batasMasuk = Carbon::createFromTime(7, 0, 0);

        if ($jamMasuk->lte($batasMasuk)) {
            return 'Tepat Waktu';
        }

        return 'Terlambat';
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS KELUAR
    |--------------------------------------------------------------------------
    */

    public function getStatusKeluarAttribute()
    {
        if (!$this->jam_keluar) {
            return 'Belum Absen';
        }

        $jamKeluar = Carbon::parse($this->jam_keluar);
        $batasKeluar = Carbon::createFromTime(15, 0, 0);

        if ($jamKeluar->lt($batasKeluar)) {
            return 'Terlalu Cepat';
        }

        return 'Sesuai';
    }


    /*
    |--------------------------------------------------------------------------
    | DURASI KERJA
    |--------------------------------------------------------------------------
    */

    public function getDurasiKerjaAttribute()
    {
        if (!$this->jam_masuk || !$this->jam_keluar) {
            return '-';
        }

        $masuk = Carbon::parse($this->jam_masuk);
        $keluar = Carbon::parse($this->jam_keluar);

        $detik = $masuk->diffInSeconds($keluar);

        $jam = floor($detik / 3600);
        $menit = floor(($detik % 3600) / 60);

        return sprintf(
            '%02d jam %02d menit',
            $jam,
            $menit
        );
    }
}