<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rating_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->decimal('highest_score', 5, 1)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Permission::insert([
            ['name' => 'all-rating-types', 'guard_name' => 'web'],
            ['name' => 'create-rating-types', 'guard_name' => 'web'],
            ['name' => 'edit-rating-types', 'guard_name' => 'web'],
            ['name' => 'delete-rating-types', 'guard_name' => 'web'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_types');

        Permission::whereIn('name', [
            'all-rating-types',
            'create-rating-types',
            'edit-rating-types',
            'delete-rating-types',
        ])->delete();
    }
};
