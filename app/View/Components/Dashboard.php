<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $role;
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->role = $this->user->role ?? 'guest';
    }

    public function render()
    {
        return view('components.dashboard');
    }
}
