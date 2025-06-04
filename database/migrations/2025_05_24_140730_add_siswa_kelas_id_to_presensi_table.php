<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            // Menambahkan kolom siswa_kelas_id
            $table->foreignId('siswa_kelas_id')->nullable()->after('jadwal_id')->constrained('siswa_kelas')->onDelete('cascade');
            // Menambahkan foreign key constraint untuk siswa_kelas_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            // Menghapus foreign key constraint untuk siswa_kelas_id
            $table->dropForeign(['siswa_kelas_id']);
            // Menghapus kolom siswa_kelas_id
            $table->dropColumn('siswa_kelas_id');
        });
    }
};
