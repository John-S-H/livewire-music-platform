<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MusicianType;
use Livewire\WithPagination;

class MusicianTypes extends Component
{
    use WithPagination;

    public function render()
    {
        $musicianTypes = MusicianType::paginate(10);

        return view('livewire.musician-types', [
            'musicianTypes' => $musicianTypes
        ]);
    }
}
