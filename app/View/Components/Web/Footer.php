<?php

namespace App\View\Components\Web;

use App\Models\Role;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $roles = Role::whereIn('slug',['company','users'])->get();
        return view('components.web.footer',['roles'=>$roles]);
    }
}
