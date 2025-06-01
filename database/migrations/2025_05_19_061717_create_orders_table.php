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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel users
        $table->decimal('total_price', 10, 2); // Total harga pesanan
        $table->enum('status', ['pending', 'processed', 'completed', 'cancelled'])->default('pending'); // Status pesanan
        $table->enum('order_type', ['dine_in', 'takeaway']); // Jenis pesanan (dine-in atau takeaway)
        $table->foreignId('meja_id')->nullable()->constrained('mejas')->nullOnDelete(); // Meja terkait, nullable dan dihapus jika meja dihapus
        $table->timestamps(); // Waktu dibuat dan diubah
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
