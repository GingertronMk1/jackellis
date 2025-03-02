<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TimesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia( 'Times', [
            'timezones' => \DateTimeZone::listIdentifiers(\DateTimeZone::ALL),
        ]);
    }
}
