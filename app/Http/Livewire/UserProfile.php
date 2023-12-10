<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{
    public $userId;
    public $userProfile;

    public function mount($id)
    {
        $this->userId = $id;
        $this->userProfile = User::with('musicianType')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.user-profile', [
            'user' => $this->userProfile
        ]);
    }
}
