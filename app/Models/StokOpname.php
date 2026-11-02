<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokOpname extends Model
{
    use HasFactory;
    
    protected $table = 'stok_opname';

    protected $fillable = [
        'bahan_id',
        'tanggal',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'stok_sistem' => 'integer',
            'stok_fisik' => 'integer',
            'selisih' => 'integer',
        ];
    }

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
}