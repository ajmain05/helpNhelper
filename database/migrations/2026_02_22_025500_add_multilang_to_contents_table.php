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
        Schema::table('contents', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->string('title_ar')->nullable()->after('title_bn');
            $table->longText('description_bn')->nullable()->after('description');
            $table->longText('description_ar')->nullable()->after('description_bn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'title_ar', 'description_bn', 'description_ar']);
        });
    }
};
