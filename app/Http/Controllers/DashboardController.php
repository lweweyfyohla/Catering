<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $events = Event::where('user_id', $userId)->get();

        $stats = [
            'total_events' => $events->count(),
            'active_sourcing' => $events->where('status', 'sourcing')->count(),
            'pending_quotes' => Quotation::whereIn('event_id', $events->pluck('id'))->where('status', 'pending')->count(),
            'pending_deliveries' => PurchaseOrder::whereIn('quotation_id', Quotation::whereIn('event_id', $events->pluck('id'))->pluck('id'))
                ->where('delivery_status', 'pending')->count(),
        ];

        $upcomingEvents = $events->sortBy('event_date')->take(5);

        return view('dashboard', compact('stats', 'upcomingEvents'));
    }
}
