<?php

namespace App\Helper;


class FlashMsg
{
  /** @var Array $flashes flash list */
  public static $flashes = [];


  public function __construct() {
    FlashMsg::$flashes = session()->get('flash') ?? [];
  }

  public static function add(String $type, String $msg)
  {
    FlashMsg::$flashes[] = [$type, $msg];

    session()->flash('flash', FlashMsg::$flashes);
  }
}
