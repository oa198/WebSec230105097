<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('course')->default('Unknown Course')->change();
            $table->string('student_name')->after('id');
        });

    }


    /**
     * Reverse the migrations.
     */
   public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('course')->default(null)->change();
            $table->dropColumn('student_name');
        });

    }

};
