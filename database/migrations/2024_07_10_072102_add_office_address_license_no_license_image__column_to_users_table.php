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
        Schema::table('users', function (Blueprint $table) {
            $table->string('office_address')->after('present_address')->nullable();
            $table->string('license_no')->after('office_address')->nullable();
            $table->string('license_image')->after('license_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('office_address');
            $table->dropColumn('license_no');
            $table->dropColumn('license_image');
        });
    }
};
