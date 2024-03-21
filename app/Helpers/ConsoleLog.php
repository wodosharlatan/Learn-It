<?php

use Illuminate\Support\Facades\Log;

/**
 * This function logs data to the console
 * 
 * @param $data
 * 
 * @return void
 */

function consoleLog($data)
{
    Log::info($data);
}

function consoleWarn($data)
{
    Log::warning($data);
}

function consoleError($data)
{
    Log::error($data);
}
