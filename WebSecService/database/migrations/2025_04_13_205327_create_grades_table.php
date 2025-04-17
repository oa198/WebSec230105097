<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('course_code', 10);
            $table->string('course_name', 100);
            $table->unsignedTinyInteger('credit_hours'); // Typically 1-5 credit hours
            $table->string('grade', 2); // Letter grades like A, B+, C-
            $table->unsignedTinyInteger('term'); // 1, 2, or 3
            $table->year('year'); // Stores only the year
            $table->timestamps(); // created_at and updated_at

            // Indexes for better performance
            $table->index(['user_id', 'term', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
};
