<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $user;

    public function render()
    {
        $users = User::all();

        return view('livewire.users', [
            'users' => $users
        ]);
    }

 
}



