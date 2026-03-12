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
        Schema::table('corporate_allocations', function (Blueprint $table) {
            $table->foreignId('campaign_id')->nullable()->change();
            $table->foreignId('organization_application_id')->nullable()->after('campaign_id')->constrained('organization_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corporate_allocations', function (Blueprint $table) {
            $table->dropForeign(['organization_application_id']);
            $table->dropColumn('organization_application_id');
            $table->foreignId('campaign_id')->nullable(false)->change();
        });
    }
};
