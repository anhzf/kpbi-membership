<?php

namespace App\View\Components\input;

use Illuminate\View\Component;

class select extends Component
{

  public $name;
  public $label;
  public $choices;
  public $value;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(String $name, String $label, array $choices, $value = null)
  {
    $this->name = $name;
    $this->label = $label;
    $this->choices = $choices;
    $this->value = $value;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('components.input.select');
  }
}
