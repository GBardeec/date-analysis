<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('report:send')->dailyAt('02:00');
