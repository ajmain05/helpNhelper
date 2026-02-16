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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->string('title_ar')->nullable()->after('title_bn');
            $table->text('short_description_bn')->nullable()->after('short_description');
            $table->text('short_description_ar')->nullable()->after('short_description_bn');
            $table->text('long_description_bn')->nullable()->after('long_description');
            $table->text('long_description_ar')->nullable()->after('long_description_bn');
            $table->text('terms_bn')->nullable()->after('terms');
            $table->text('terms_ar')->nullable()->after('terms_bn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'title_bn',
                'title_ar',
                'short_description_bn',
                'short_description_ar',
                'long_description_bn',
                'long_description_ar',
                'terms_bn',
                'terms_ar',
            ]);
        });
    }
};
