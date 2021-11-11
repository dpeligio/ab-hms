<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\RoomType;
use Carbon\CarbonPeriod;

class HomeController
{
    public function index()
    {
        $now = now()->subWeeks(5);
        $weeks = [];
        foreach(range(1,10) as $index)
        {
            $startOfWeek = $now->copy()->startOfWeek();
            $endOfWeek = $now->copy()->endOfWeek();
            array_push($weeks, [ $startOfWeek, $endOfWeek ]);
            $now->addWeek();
        }

        $selectedWeek = [];
        $weekInput = explode(' - ', request()->input('week'));
        if(count($weekInput) === 2)
        {
            $period = CarbonPeriod::create($weekInput[0], $weekInput[1]);
        }
        else
        {
            $period = CarbonPeriod::create(now()->startOfWeek(), now()->endOfWeek());
        }
        $selectedWeek = $period->toArray();

        $rooms = Room::filters()
            ->take(101)
            ->get();

        $roomTypes = RoomType::pluck('name', 'id');

        if($rooms->count() > 100)
        {
            $rooms = null;
        }

        return view('home', compact('rooms', 'roomTypes', 'weeks', 'selectedWeek'));
    }
}