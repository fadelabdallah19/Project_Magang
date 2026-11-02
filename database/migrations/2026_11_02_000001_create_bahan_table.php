<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 100);
            $table->string('kategori', 50);
            $table->unsignedInteger('stok')->default(0);
            $table->string('satuan', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan');
    }
};