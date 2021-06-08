<?php

namespace App\View\Components;

use App\Models\Cab;
use Illuminate\View\Component;

class CabCard extends Component
{
  public Cab $cab;

  /**
   * CabCard constructor.
   * @param Cab $cab
   */
  public function __construct(Cab $cab) { $this->cab = $cab; }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('components.cab-card');
  }
}
