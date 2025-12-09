<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multipleuploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('ref_table')->nullable();
            $table->string('filename');
            $table->string('filepath');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multipleuploads');
    }
};
