<?php

use App\Xstudioz\ImageResize;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Psy\VarDumper\Dumper;
use Symfony\Component\VarDumper\VarDumper;

function resizeImage($src, $w, $h = 0)
{
  return ImageResize::resize($src, $w, $h);
}

if (!function_exists('d')) {
  /**
   * Dump the passed variables.
   *
   * @param mixed
   * @return void
   */
  function d($x)
  {
    VarDumper::dump($x);
  }
}

function amountWithSymbol($amount): string
{
  return MyAppSettings::currency() . ' ' . $amount;
}

function secondsToTime($seconds): string
{
  return gmdate('h \h\r\s m \m\i\n', $seconds);//CarbonInterval::seconds($seconds)->format('');
}

function formatToIndianTime(Carbon $d, $format = 'dS M Y'): string
{
  return $d->timezone('Asia/Kolkata')->format($format);
}
