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
        Schema::create('organization_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->decimal('target_amount', 12, 2);
            $table->decimal('collected_amount', 12, 2)->default(0);
            
            // Seeker Details
            $table->string('seeker_name')->nullable();
            $table->string('seeker_location')->nullable();
            
            // Payment info
            $table->string('payment_method');
            $table->string('payment_account');
            
            // Statuses and Config
            $table->string('cert_image')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->decimal('service_charge_pct', 5, 2)->default(7.00);
            $table->decimal('net_amount_payable', 12, 2)->default(0);
            
            // Assignment and verification
            $table->foreignId('assigned_volunteer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('rejection_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_applications');
    }
};
