<?php

namespace Tests\Feature;

use App\Livewire\EventsCalendar;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventsCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_shows_an_event_on_its_day(): void
    {
        Event::factory()->create([
            'title' => 'Charity Marathon',
            'starts_at' => now()->startOfMonth()->addDays(10),
        ]);

        Livewire::test(EventsCalendar::class)
            ->assertSee('Charity Marathon');
    }

    public function test_next_and_previous_month_navigation_changes_the_displayed_month(): void
    {
        $component = Livewire::test(EventsCalendar::class);
        $currentMonthLabel = now()->format('F Y');
        $nextMonthLabel = now()->addMonthNoOverflow()->format('F Y');

        $component->assertSee($currentMonthLabel);

        $component->call('nextMonth')->assertSee($nextMonthLabel);

        $component->call('previousMonth')->assertSee($currentMonthLabel);
    }

    public function test_upcoming_events_list_only_shows_future_events(): void
    {
        // Two months back so it's off the currently-displayed calendar grid
        // too — isolates the assertion to the "Upcoming" list's own filter.
        Event::factory()->create(['title' => 'Past Event', 'starts_at' => now()->subMonths(2)]);
        Event::factory()->create(['title' => 'Future Event', 'starts_at' => now()->addWeek()]);

        Livewire::test(EventsCalendar::class)
            ->assertSee('Future Event')
            ->assertDontSee('Past Event');
    }

    /**
     * Exit criteria: "stay responsive at scale (test with 100+ dummy items)".
     */
    public function test_calendar_stays_responsive_with_over_100_events(): void
    {
        Event::factory()->count(120)->create();

        $start = microtime(true);

        $this->get('/events')->assertOk();

        $this->assertLessThan(2.0, microtime(true) - $start, 'Events calendar took too long to render with 120 events.');
    }
}
