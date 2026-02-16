<?php

use App\Enums\Organization\OrganizationApplicationStatus;
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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('volunteer_document')->nullable();
            $table->decimal('requested_amount', 10, 2);
            $table->date('completion_date')->nullable();
            $table->string('sid')->nullable();
            $table->enum('status', OrganizationApplicationStatus::values())->default(OrganizationApplicationStatus::PENDING->value);
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
