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
    Schema::create('mejas', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_meja')->unique();
        $table->integer('kapasitas');
        $table->enum('ketersediaan', ['available', 'reserved'])->default('available');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('mejas');
}

};
