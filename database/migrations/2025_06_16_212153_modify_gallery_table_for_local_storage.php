<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Mengubah kolom public_id untuk menyimpan path file lokal
     * dan menambahkan komentar bahwa kolom ini sekarang menyimpan path file lokal
     * bukan Cloudinary public_id
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('public_id')->comment('Menyimpan path file lokal, bukan Cloudinary public_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('public_id')->comment('Cloudinary public_id')->change();
        });
    }
};
