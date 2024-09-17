<?php

namespace App\Filament\Widgets;

use App\Http\Controllers\PrestashopController;
use App\Models\Group;
use App\Models\Link;
use App\Models\Newsletter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Stat::make('Aantal ingeschreven klanten', count(PrestashopController::contacts())),
            Stat::make('Aantal groepen', Group::count()),
            Stat::make('Verstuurde nieuwsbrieven', Newsletter::whereNot('send_at', null)->count())
                ->description('Van de ' . Newsletter::count() . ' nieuwsbrieven'),
            Stat::make('Te versturen', DB::table('jobs')->where('queue', 'default')->count()),
            Stat::make('Linken', Link::count()),
            Stat::make('Linken geklikt', Link::sum('clicked'))
        ];
    }
}
