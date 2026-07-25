<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'event_name', 'event_type', 'event_date', 'guest_count', 'notes', 'status'])]
class Event extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function statusLabel(): string
    {
        return ucfirst($this->resolvedStatus());
    }

    /**
     * Work out which pipeline step this event is really on. The stored
     * `status` column only tracks 5 states (draft/sourcing/ordered/delivered/closed),
     * so "quotation" and "paid" are derived here from related quotation/payment
     * records. This is the single source of truth used by both the dashboard
     * pipeline timeline and the events list, so they never fall out of sync.
     */
    public function resolvedStatus(): string
    {
        if ($this->status === 'sourcing') {
            // A quote request has been sent and is awaiting a supplier's response:
            // that's the "quotation" step, not still "sourcing".
            $hasPendingQuotation = $this->quotations->contains(fn (Quotation $q) => $q->status === 'pending');

            return $hasPendingQuotation ? 'quotation' : 'sourcing';
        }

        if ($this->status === 'delivered') {
            $acceptedQuotation = $this->quotations
                ->where('status', 'accepted')
                ->sortByDesc('created_at')
                ->first();

            $paymentStatus = $acceptedQuotation?->purchaseOrder?->payment?->payment_status;

            return $paymentStatus === 'paid' ? 'paid' : 'delivered';
        }

        return $this->status;
    }
}
