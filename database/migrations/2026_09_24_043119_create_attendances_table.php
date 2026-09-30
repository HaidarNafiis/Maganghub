<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            $table->enum('status', [
                'hadir',
                'terlambat',
                'tidak_hadir',
            ])->default('hadir');

            // Total keterlambatan dalam detik
            $table->unsignedInteger('terlambat_detik')->default(0);

            // Data lokasi saat melakukan absensi
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Akurasi GPS dari browser/device
            $table->decimal('accuracy', 10, 2)->nullable();

            // Jarak user dengan lokasi kerja
            $table->decimal('jarak_meter', 10, 2)->nullable();

            // Foto hasil verifikasi wajah
            $table->string('foto')->nullable();

            $table->timestamps();

            // Satu user hanya boleh memiliki satu data absensi per hari
            $table->unique([
                'user_id',
                'tanggal',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};