<?php

namespace App\View\Components\Web;

use Illuminate\View\Component;

class CvData extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $cv;

    public function __construct($cv)
    {
        $this->cv = $cv;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.cv-data');
    }
}
