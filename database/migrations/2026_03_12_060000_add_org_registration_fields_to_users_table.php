<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Organization registration type
            $table->string('org_reg_type')->nullable()->after('office_address'); // 'registered' | 'unregistered'

            // Registered org fields
            $table->string('reg_body')->nullable()->after('org_reg_type');      // Registration authority
            $table->string('reg_no')->nullable()->after('reg_body');             // Registration number
            $table->string('cert_image')->nullable()->after('reg_no');           // Certificate image path

            // Unregistered org fields
            $table->string('years_of_op')->nullable()->after('cert_image');           // Years of operation
            $table->string('beneficiaries_count')->nullable()->after('years_of_op'); // No. of beneficiaries
            $table->string('working_sectors')->nullable()->after('beneficiaries_count'); // Comma-separated sectors
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'org_reg_type',
                'reg_body',
                'reg_no',
                'cert_image',
                'years_of_op',
                'beneficiaries_count',
                'working_sectors',
            ]);
        });
    }
};
