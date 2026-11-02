<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_opname', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_id')->constrained('bahan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->unsignedInteger('stok_sistem');
            $table->unsignedInteger('stok_fisik');
            $table->integer('selisih')->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_opname');
    }
};