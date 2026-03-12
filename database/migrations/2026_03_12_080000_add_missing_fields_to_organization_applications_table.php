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
        Schema::table('organization_applications', function (Blueprint $table) {
            // New fields for the mobile app submissions
            $table->string('category')->nullable()->after('title');
            $table->decimal('collected_amount', 12, 2)->default(0)->after('requested_amount');
            $table->string('seeker_name')->nullable()->after('collected_amount');
            $table->string('seeker_location')->nullable()->after('seeker_name');
            $table->string('payment_method')->nullable()->after('seeker_location');
            $table->string('payment_account')->nullable()->after('payment_method');
            $table->string('cert_image')->nullable()->after('payment_account');
            $table->decimal('service_charge_pct', 5, 2)->default(7.00)->after('status');
            $table->decimal('net_amount_payable', 12, 2)->default(0)->after('service_charge_pct');
            $table->unsignedBigInteger('assigned_volunteer_id')->nullable()->after('net_amount_payable');
            $table->unsignedBigInteger('approved_by')->nullable()->after('assigned_volunteer_id');
            $table->text('rejection_reason')->nullable()->after('approved_by');
            
            // Foreign keys
            $table->foreign('assigned_volunteer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_applications', function (Blueprint $table) {
            $table->dropForeign(['assigned_volunteer_id']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'category', 'collected_amount', 'seeker_name', 'seeker_location',
                'payment_method', 'payment_account', 'cert_image',
                'service_charge_pct', 'net_amount_payable',
                'assigned_volunteer_id', 'approved_by', 'rejection_reason'
            ]);
        });
    }
};
