@php
    $theme = app(\App\Services\ThemeService::class)->settings();
    $primary = $theme->primary_color;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; color: #18181b; font-size: 12px; }
        h1 { font-size: 26px; margin: 0 0 4px; }
        h2 { font-size: 16px; margin: 24px 0 8px; border-bottom: 2px solid {{ $primary }}; padding-bottom: 4px; }
        p { line-height: 1.5; }
        .accent { color: {{ $primary }}; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        td { padding: 6px 0; vertical-align: top; }
        .stat-table td { width: 25%; text-align: center; border: 1px solid #e4e4e7; padding: 12px 4px; }
        .stat-value { font-size: 20px; font-weight: bold; display: block; }
        .stat-label { font-size: 10px; color: #71717a; }
        .bar-bg { background: #f4f4f5; height: 8px; border-radius: 4px; }
        .bar-fill { background: {{ $primary }}; height: 8px; border-radius: 4px; }
        .chip { display: inline-block; border: 1px solid #e4e4e7; padding: 3px 10px; border-radius: 999px; margin: 0 6px 6px 0; font-size: 10px; }
        .sponsor-box { border: 1px solid #e4e4e7; padding: 10px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <h1>{{ config('app.name') }} — Media Kit</h1>
    <p>{{ $mediaKit->bio }}</p>

    @if (!empty($mediaKit->brand_values))
        <div>
            @foreach ($mediaKit->brand_values as $value)
                <span class="chip">{{ $value }}</span>
            @endforeach
        </div>
    @endif

    <h2>Reach</h2>
    <table class="stat-table">
        <tr>
            <td><span class="stat-value">{{ number_format($snapshot->followers) }}</span><span class="stat-label">Followers</span></td>
            <td><span class="stat-value">{{ number_format($mediaKit->avg_viewers) }}</span><span class="stat-label">Avg. Viewers</span></td>
            <td><span class="stat-value">{{ number_format($mediaKit->peak_viewers) }}</span><span class="stat-label">Peak Viewers</span></td>
            <td><span class="stat-value">{{ number_format($mediaKit->monthly_impressions) }}</span><span class="stat-label">Monthly Impressions</span></td>
        </tr>
    </table>

    @foreach ([
        ['title' => 'Age Ranges', 'data' => $mediaKit->age_ranges],
        ['title' => 'Gender Distribution', 'data' => $mediaKit->gender_distribution],
        ['title' => 'Languages', 'data' => $mediaKit->languages],
        ['title' => 'Geographic Breakdown', 'data' => $mediaKit->geographic_breakdown],
    ] as $group)
        @if (!empty($group['data']))
            <h2>{{ $group['title'] }}</h2>
            <table>
                @foreach ($group['data'] as $row)
                    <tr>
                        <td style="width: 30%;">{{ $row['label'] }}</td>
                        <td style="width: 10%; text-align: right;">{{ $row['percentage'] }}%</td>
                        <td style="width: 60%;">
                            <div class="bar-bg">
                                <div class="bar-fill" style="width: {{ $row['percentage'] }}%;"></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    @endforeach

    @if ($sponsors->isNotEmpty())
        <h2>Previous Partnerships</h2>
        @foreach ($sponsors as $sponsor)
            <div class="sponsor-box">
                <strong>{{ $sponsor->name }}</strong>
                @if ($sponsor->case_study)
                    <p>{{ $sponsor->case_study }}</p>
                @endif
                @if ($sponsor->campaign_highlights)
                    <p style="color: #71717a; font-size: 10px;">{{ $sponsor->campaign_highlights }}</p>
                @endif
            </div>
        @endforeach
    @endif

    <h2>Business Contact</h2>
    <p>business@example.com</p>
</body>
</html>
