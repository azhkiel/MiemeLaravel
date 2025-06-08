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
    Schema::table('orders', function (Blueprint $table) {
        $table->enum('type_pesanan', ['dine_in', 'takeaway'])->default('takeaway');
        $table->foreignId('meja_id')->nullable()->constrained('mejas')->onDelete('set null');
        $table->string('name_order')->nullable();
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('type_pesanan');
        $table->dropForeign(['meja_id']);
        $table->dropColumn('meja_id');
    });
}

};
