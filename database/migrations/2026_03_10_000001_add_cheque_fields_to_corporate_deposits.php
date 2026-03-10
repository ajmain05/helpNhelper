<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('corporate_deposits', function (Blueprint $table) {
            // Cheque-specific fields (all nullable – only used for offline/cheque method)
            $table->string('cheque_no')->nullable()->after('transaction_id');
            $table->string('bank_name')->nullable()->after('cheque_no');
            $table->string('cheque_image')->nullable()->after('bank_name');
            $table->text('admin_note')->nullable()->after('cheque_image');

            // Extend status enum to include under_review and rejected
            // MySQL: modify enum via DB statement
            DB::statement("ALTER TABLE corporate_deposits MODIFY COLUMN status ENUM('pending','under_review','completed','failed','cancelled','rejected') NOT NULL DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        Schema::table('corporate_deposits', function (Blueprint $table) {
            $table->dropColumn(['cheque_no', 'bank_name', 'cheque_image', 'admin_note']);
            DB::statement("ALTER TABLE corporate_deposits MODIFY COLUMN status ENUM('pending','completed','failed','cancelled') NOT NULL DEFAULT 'pending'");
        });
    }
};
