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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // Foreign key to faculties table
            $table->foreignId('faculty_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Course details
            $table->string('name');
            $table->string('code')->unique(); // Optional: unique course code
            $table->integer('duration_years'); // Duration in years, e.g. 3 or 4

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
