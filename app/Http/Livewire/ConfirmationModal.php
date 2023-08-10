<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\Posts;
use Illuminate\Support\Facades\Route;

class ConfirmationModal extends Posts
{
    public $title;
    public $content;
    public $postId;

    public function mount()
    {
        $this->postId = Route::current()->parameter('id');
    }

    public function render()
    {
        return view('livewire.confirmation-modal', ['postId' => $this->postId]);
    }
}