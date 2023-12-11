<?php

namespace App\Http\Livewire;

use App\Models\MusicianType;
use App\Models\Province;
use App\Models\Post;

class ViewPost extends Posts
{
    public $postId;
    public $post;
    public $author;

    public function mount($id)
    {
        $this->postId = $id;

        // Fetch post with necessary relationships in one query
        $this->post = Post::with('user:id,name,email', 'province:id,title', 'musicianType:id,name')
            ->findOrFail($id);

        // Assign the loaded relationships directly
        $this->author = $this->post->user;
        $this->province = $this->post->province;
        $this->musicianType = $this->post->musicianType;

        // Fetch all provinces and musician types for select dropdowns without unnecessary data we only need id, title and name
        $this->provinces = Province::select('id', 'title')->get();
        $this->musicianTypes = MusicianType::select('id', 'name')->get();
    }


    public function render()
    {
        return view('livewire.view-post', [
            'post' => $this->post,
            'author' => $this->author,
            'province' => $this->province,
            'provinces' =>  $this->provinces,
            'musicianType' => $this->musicianType,
            'musicianTypes' =>  $this->musicianTypes,
        ]);
    }
}
