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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->String('nama_lengkap', 100);
            $table->String('email', 100)->unique();
            $table->String('nomor_telepon', 15);
            $table->date('tanggal_lahir');
            $table->text('alamat')->nullable();
            $table->date('tanggal_masuk');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->onDelete('set null')->onUpdate('cascade');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
