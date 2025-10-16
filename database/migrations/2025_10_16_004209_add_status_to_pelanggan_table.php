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
      Schema::table('pelanggan', function (Blueprint $table) {
            // Memperbarui kolom 'gender' dengan opsi baru
            $table->enum('gender', ['Male', 'Female', 'Other', 'Non-binary'])
                  ->nullable()
                  ->change(); // Perintah 'change()' wajib
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // Mengembalikan ke opsi enum sebelumnya (sebelum penambahan 'Non-binary')
            $table->enum('gender', ['Male', 'Female', 'Other'])
                  ->nullable()
                  ->change();
       
        });
    }
};

