<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // bigint(20) AUTO_INCREMENT
            $table->string('code', 64);
            $table->string('name', 256);
            $table->integer('price')->unsigned();
            $table->string('model', 128);
            $table->text('description')->nullable();
            $table->string('photo', 128)->nullable();
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    public function down() {
        Schema::dropIfExists('products');
    }
};
