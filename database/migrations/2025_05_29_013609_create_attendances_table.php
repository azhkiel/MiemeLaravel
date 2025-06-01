<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('attendance_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->string('image')->nullable();
            $table->string('checkout_image')->nullable(); 
            $table->string('shift')->nullable();
            $table->time('attendance_time')->nullable();
            $table->time('checkout_time')->nullable();
            $table->decimal('duration', 5, 2)->nullable();
            $table->integer('salary')->nullable();    
            $table->timestamps(); 
        });     
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
