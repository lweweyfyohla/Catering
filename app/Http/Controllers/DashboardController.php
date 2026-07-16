<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * The full procurement pipeline, in order.
     * "quotation" and "paid" aren't stored on Event.status directly,
     * they're inferred from position between the tracked statuses.
     */
    protected array $stages = ['draft', 'sourcing', 'quotation', 'ordered', 'delivered', 'paid', 'closed'];

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

        $pipelineEvents = $this->pipelineEventsFor($events)->take(2)->values();

        return view('dashboard', compact('stats', 'upcomingEvents', 'pipelineEvents'));
    }

    public function pipeline(): View
    {
        $userId = Auth::id();

        $events = Event::where('user_id', $userId)->get();

        $pipelineEvents = $this->pipelineEventsFor($events)->values();

        return view('pipeline', compact('pipelineEvents'));
    }

    protected function pipelineEventsFor($events)
    {
        return $events
            ->where('status', '!=', 'closed')
            ->sortBy('event_date')
            ->map(fn (Event $event) => $this->buildPipelineItem($event));
    }

    protected function buildPipelineItem(Event $event): array
    {
        $currentIndex = array_search($event->status, $this->stages);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;

        $daysLeft = (int) now()->startOfDay()->diffInDays($event->event_date, false);

        $urgency = null;
        if ($daysLeft <= 3) {
            $urgency = ['label' => 'Urgent', 'class' => 'bg-red-50 text-red-600'];
        } elseif ($daysLeft <= 14) {
            $urgency = ['label' => 'Close to deadline', 'class' => 'bg-amber-50 text-amber-600'];
        }

        $steps = collect($this->stages)->map(function ($stage, $index) use ($currentIndex) {
            return [
                'label' => ucfirst($stage),
                'state' => $index < $currentIndex ? 'done' : ($index === $currentIndex ? 'current' : 'pending'),
            ];
        });

        return [
            'name' => $event->event_name,
            'urgency' => $urgency,
            'deadline' => $event->event_date->format('M j, Y'),
            'days_left' => $daysLeft,
            'steps' => $steps,
        ];
    }
}
