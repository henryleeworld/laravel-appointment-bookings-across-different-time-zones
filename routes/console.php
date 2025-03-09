<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('send:scheduled-notifications')->everyMinute();
