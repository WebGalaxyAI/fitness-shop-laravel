<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            $this->getNewItemsStats('users'),
            $this->getNewItemsStats('products'),
            $this->getNewItemsStats('brands'),
        ];
    }

    private function getNewItemsStats(string $table, ?string $title = null): Stat
    {
        $title = $title ?? 'New ' . str($table)->replace('_', ' ');

        $stats = [];
        for ($i = 0; $i < 6; $i++) {
            $stats[Carbon::now()->subMonths($i)->format('Y-m')] = 0;
        }

        $itemsPerLastSixMonths = DB::table($table)
            ->select(DB::raw('COUNT(*) as count'), DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        foreach ($itemsPerLastSixMonths as $item) {
            $key = sprintf('%04d-%02d', $item->year, $item->month);
            $stats[$key] = $item->count;
        }

        $stats = array_reverse($stats);
        $newItemsCount = $stats[now()->format('Y-m')];
        $previousMonthItemsCount = $stats[now()->subMonth()->format('Y-m')];

        if ($previousMonthItemsCount > 0) {
            $percentageChange = ceil((($newItemsCount - $previousMonthItemsCount) / $previousMonthItemsCount) * 100);
        } else if ($previousMonthItemsCount === 0 && $newItemsCount > 0) {
            $percentageChange = 100;
        } else {
            $percentageChange = 0;
        }

        return Stat::make($title, $newItemsCount)
            ->description(abs($percentageChange) . '% ' . ($percentageChange < 0 ? 'decrease' : 'increase'))
            ->descriptionIcon($percentageChange < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-arrow-trending-up')
            ->chart($stats)
            ->color($percentageChange < 0 ? 'danger' : 'success');
    }
}
