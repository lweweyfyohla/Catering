<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'quotation_id', 'po_number', 'total_price', 'invoice_no', 'invoice_file',
    'invoice_date', 'status', 'delivery_status', 'issues_reported',
    'goods_verified', 'delivered_at', 'issued_at',
])]
class PurchaseOrder extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'invoice_date' => 'datetime',
            'delivered_at' => 'datetime',
            'issued_at' => 'datetime',
            'goods_verified' => 'boolean',
        ];
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
