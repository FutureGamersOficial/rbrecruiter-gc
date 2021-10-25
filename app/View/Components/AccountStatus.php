<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;

class AccountStatus extends Component
{
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->user = User::findOrFail($userId);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.account-status');
    }
}
