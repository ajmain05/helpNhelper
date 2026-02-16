<?php

use App\Enums\Transaction\ReceiverType;
use App\Enums\Transaction\TransactionSubType;
use App\Enums\Transaction\TransactionType;
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
        Schema::create('transaction_amendment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->unsignedBigInteger('invoice_amend_id')->nullable();
            $table->foreign('invoice_amend_id')->references('id')->on('invoice_amendment_histories')->onDelete('cascade');
            $table->enum('receiver_type', ReceiverType::values())->nullable();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->string('reference_number')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->foreign('status')->references('id')->on('invoice_statuses')->onDelete('cascade');
            $table->enum('type', TransactionType::values())->default(TransactionType::Expense->value);
            $table->enum('sub_type', TransactionSubType::values())->nullable();
            $table->foreignId('campaign_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('transaction_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('transaction_mode_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('bank_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('bank_account_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('volunteer_id')->nullable();
            $table->foreign('volunteer_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->foreign('donor_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_amendment_histories');
    }
};
