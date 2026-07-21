<?php

namespace App\Livewire;

use App\Models\Event;
use Carbon\CarbonImmutable;
use Livewire\Attributes\Url;
use Livewire\Component;

class EventsCalendar extends Component
{
    #[Url(as: 'month', history: true)]
    public string $monthParam = '';

    public function mount(): void
    {
        $this->monthParam = $this->monthParam ?: now()->format('Y-m');
    }

    public function previousMonth(): void
    {
        $this->monthParam = $this->month()->subMonthNoOverflow()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->monthParam = $this->month()->addMonthNoOverflow()->format('Y-m');
    }

    private function month(): CarbonImmutable
    {
        return CarbonImmutable::createFromFormat('Y-m', $this->monthParam)->startOfMonth();
    }

    public function render()
    {
        $month = $this->month();
        $gridStart = $month->startOfMonth()->startOfWeek(CarbonImmutable::SUNDAY);
        $gridEnd = $month->endOfMonth()->endOfWeek(CarbonImmutable::SATURDAY);

        $eventsByDay = Event::query()
            ->whereBetween('starts_at', [$gridStart, $gridEnd])
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn (Event $event) => $event->starts_at->format('Y-m-d'));

        $days = [];
        $cursor = $gridStart;

        while ($cursor->lte($gridEnd)) {
            $days[] = [
                'date' => $cursor,
                'inCurrentMonth' => $cursor->month === $month->month,
                'isToday' => $cursor->isToday(),
                'events' => $eventsByDay->get($cursor->format('Y-m-d'), collect()),
            ];
            $cursor = $cursor->addDay();
        }

        $upcoming = Event::query()
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->limit(6)
            ->get();

        return view('livewire.events-calendar', [
            'month' => $month,
            'days' => $days,
            'upcoming' => $upcoming,
        ]);
    }
}
