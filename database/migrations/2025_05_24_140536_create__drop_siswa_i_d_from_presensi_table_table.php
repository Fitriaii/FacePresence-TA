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
            // Hapus foreign key constraint dulu
            $table->dropForeign(['siswa_id']);
            // Baru hapus kolomnya
            $table->dropColumn('siswa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            // Tambahkan kembali kolom dan constraint
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
        });
    }
};
