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
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('organization_application_id')->nullable()->after('campaign_id')->constrained('organization_applications')->onDelete('cascade');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('organization_application_id')->nullable()->after('campaign_id')->constrained('organization_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['organization_application_id']);
            $table->dropColumn('organization_application_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['organization_application_id']);
            $table->dropColumn('organization_application_id');
        });
    }
};
