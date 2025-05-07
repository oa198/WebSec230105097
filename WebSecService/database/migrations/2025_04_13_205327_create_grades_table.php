<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('grade', 2);
            $table->unsignedTinyInteger('term');
            $table->year('year');
            $table->timestamps();

            $table->index(['user_id', 'term', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};

