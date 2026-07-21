<?php

namespace App\Filament\Widgets;

use App\Models\BusinessInquiry;
use App\Models\NewsletterSubscription;
use App\Models\PageView;
use App\Models\ProductClick;
use App\Services\LiveStatus\LiveStatusManager;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $status = app(LiveStatusManager::class)->current();
        $unreadInquiries = BusinessInquiry::query()->where('is_read', false)->count();
        $sponsorRequests = BusinessInquiry::query()->where('campaign_type', 'sponsorship')->count();

        return [
            Stat::make('Live Status', $status->isLive ? 'LIVE' : 'Offline')
                ->color($status->isLive ? 'success' : 'gray')
                ->description($status->isLive ? "on {$status->platform}" : 'no active stream'),

            Stat::make('Traffic (7 days)', PageView::query()->where('viewed_at', '>=', now()->subDays(7))->count())
                ->description('page views'),

            Stat::make('Recent Inquiries', $unreadInquiries)
                ->description('unread')
                ->color($unreadInquiries > 0 ? 'warning' : 'gray'),

            Stat::make('Sponsor Requests', $sponsorRequests)
                ->description('total sponsorship inquiries'),

            Stat::make('Newsletter Growth', NewsletterSubscription::query()->count())
                ->description('total local signups')
                ->chart(
                    NewsletterSubscription::query()
                        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                        ->where('created_at', '>=', now()->subDays(7))
                        ->groupBy('date')
                        ->pluck('count')
                        ->all()
                ),

            Stat::make('Merch Clicks (7 days)', ProductClick::query()->where('clicked_at', '>=', now()->subDays(7))->count())
                ->description('outbound shop link clicks'),
        ];
    }
}
