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
        Schema::table('jadwal', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['guru_id']);
            // Baru hapus kolomnya
            $table->dropColumn('guru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Tambahkan kembali kolom dan constraint
            $table->foreignId('guru_id')->constrained('kelas')->onDelete('cascade');
        });
    }
};
