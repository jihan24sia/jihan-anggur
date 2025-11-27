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
        Schema::table('multipleuploads', function (Blueprint $table) {
            $table->string('ref_table', 100)->after('filename');
            $table->unsignedBigInteger('ref_id')->after('ref_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multipleuploads', function (Blueprint $table) {
            $table->dropColumn(['ref_table', 'ref_id']);
        });
    }
};
