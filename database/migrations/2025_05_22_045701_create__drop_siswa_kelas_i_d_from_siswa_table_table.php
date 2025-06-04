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
        Schema::table('siswa', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['siswa_kelas_id']);
            // Baru hapus kolomnya
            $table->dropColumn('siswa_kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            // Tambahkan kembali kolom dan constraint
            $table->foreignId('siswa_kelas_id')->constrained('siswa_kelas')->onDelete('cascade');
        });
    }
};
