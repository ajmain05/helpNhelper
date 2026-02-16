<?php

use App\Enums\User\Status;
use App\Enums\User\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('password')->nullable();
            $table->foreignId('upazila_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('permanent_address')->nullable();
            $table->string('present_address')->nullable();
            $table->string('category')->nullable();
            $table->string('auth_file')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            // $table->foreignId('donor_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('type', Type::values());
            $table->enum('status', Status::values())->default(Status::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
