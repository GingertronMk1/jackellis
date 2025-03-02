<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        [
            'year'  => $year,
            'month' => $month,
            'day'   => $day,
            'hour'   => $hour,
            'minute' => $minute,
            'timezone' => $timezone,
            'currentTimezone' => $currentTimezone,
        ] = $request->get('time');

        $time = (new Carbon(timezone: $timezone))
            ->setDate($year, $month, $day)
            ->setTime($hour, $minute, 0)
            ->setTimezone($currentTimezone);
        return response()->json(['time' => $time->format('Y-m-d H:i')]);
    }
}
