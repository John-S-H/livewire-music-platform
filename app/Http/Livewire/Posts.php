<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $active;

    public function render()
    {
        $query = Post::query();

        // Apply filter if $active is set the scopeActive is used for this check the post model
        if ($this->active) {
            $query->active();
        }

        // Use orderBy() to sort the results if needed
        $query->orderBy('created_at', 'desc');

        // Use paginate() method to fetch paginated results
        $posts = $query->paginate(20);

        return view('livewire.posts', [
            'posts' => $posts
        ]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }
}