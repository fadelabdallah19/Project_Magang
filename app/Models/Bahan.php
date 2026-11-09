<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';

    public const STOCK_MINIMUM = 20;

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'stok',
        'satuan',
    ];

    protected function casts(): array
    {
        return [
            'stok' => 'integer',
        ];
    }

    public function barangMasuk(): HasMany
    {
        return $this->hasMany(BarangMasuk::class, 'bahan_id');
    }

    public function barangKeluar(): HasMany
    {
        return $this->hasMany(BarangKeluar::class, 'bahan_id');
    }

    public function stokOpname(): hasMany
    {
        return $this->hasMany(StokOpname::class, 'bahan_id');
    }

    public function getStatusAttribute(): string
    {
        return $this->stok <= self::STOCK_MINIMUM ? 'Stok Rendah' : 'Aman';
    }
}