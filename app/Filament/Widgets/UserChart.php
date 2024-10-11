<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Total users per year';

    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $stats = [];
        for ($i = 0; $i < 12; $i++) {
            $stats[Carbon::now()->subMonths($i)->format('Y-m')] = 0;
        }

        $itemsPerLastYear = DB::table('users')
            ->select(DB::raw('COUNT(*) as count'), DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        foreach ($itemsPerLastYear as $item) {
            $key = sprintf('%04d-%02d', $item->year, $item->month);
            $stats[$key] = $item->count;
        }

        $stats = array_reverse($stats);

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => array_values($stats),
                    'fill' => 'start',
                ],
            ],
            'labels' => array_keys($stats),
        ];
    }
}
