<?php


namespace App\Xstudioz;


class ImageResize
{
  static function resize($src, $w, $h = 0): string
  {
    return "https://ik.imagekit.io/hydlcbl5qlg/" . $src . "?tr=h-$h,w-$w,pr-true,fo-auto";
  }
}
