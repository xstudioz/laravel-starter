<?php


namespace App\Xstudioz\Traits;

trait FromArray
{
  public static function fromArray(array $data = [])
  {
    foreach (get_object_vars($obj = new self) as $property => $default) {
      if (!array_key_exists($property, $data)) continue;
      $obj->{$property} = $data[$property]; // assign value to object
    }
    return $obj;
  }

  public function updateFromArray(array $data = [])
  {
    $vars = get_object_vars($this);
    foreach ($vars as $property => $default) {
      if (!array_key_exists($property, $data)) continue;
      $this->{$property} = $data[$property]; // assign value to object
    }
  }
}
