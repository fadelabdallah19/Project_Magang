<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 30)->unique();
            $table->foreignId('bahan_id')->constrained('bahan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->unsignedInteger('jumlah');
            $table->string('satuan', 20);
            $table->string('supplier', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};