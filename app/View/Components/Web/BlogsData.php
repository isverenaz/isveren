<?php

namespace App\View\Components\Web;

use Illuminate\View\Component;

class BlogsData extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $blogs;

    public function __construct($blogs)
    {
        $this->blogs = $blogs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.blogs-data');
    }
}
