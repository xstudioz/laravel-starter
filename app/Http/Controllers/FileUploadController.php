<?php

namespace App\Http\Controllers;


use App\Xstudioz\ImageResize;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Storage;

class FileUploadController extends Controller
{


  public function __invoke($type = null): array
  {
    $type = $type ?? 'misc';
    switch ($type) {

      case 'city-banners': //
        $dir = 'public/city-banners';
        break;
      case 'study-material': //
        $dir = 'public/study-material';
        break;
      case 'testimonials': //
        $dir = 'public/testimonial';
        break;
      case 'blog-banners': //
        $dir = 'public/blog-banners';
        break;
      case 'banners':
        $dir = 'public/banners';
        break;
      case 'grades':
        $dir = 'public/grades';
        break;
      case 'home-slides':
        $dir = 'public/home-slides';
        break;
      default:
        $dir = 'public/' . $type;
        break;
    }
    $files = request()->file('file');
    $uploads = [];
    foreach ($files as $file) {
      $path = $file->store($dir);
      $uploads [] = ['path' => $path, 'url' => ImageResize::resize($path, 300, 0)];
    }
    return $uploads;

  }


}
