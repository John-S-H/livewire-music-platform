<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;

class ViewPost extends Component
{
    public $postId;
    public $post;
    public $author;

    public function mount($id)
    {
        $this->postId = $id;
        // get the post with the author so we dont need to preform extra queries
        $this->post = Post::with('user')->findOrFail($id);
        // Assign the author to the $author variable
        $this->author = $this->post->user; 
    } 

    public function render()
    {
        return view('livewire.view-post', ['post' => $this->post, 'author' => $this->author]);
    }
}
