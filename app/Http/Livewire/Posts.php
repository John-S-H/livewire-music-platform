<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $post;

    public $confirmingPostDeletion = false;
    public $confirmingPostAdd = false;

    protected $queryString = [
        'active' => ['except' => false],
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    protected $rules = [
        'post.title' => 'required|string|min:4',
        'post.description' => 'required|string|min:4',
        'post.status' => 'boolean'
    ];

    public function render()
    {
        $query = Post::query();

        // Apply filter if $active is set, the scopeActive is used for this check in the Post model
        if ($this->active) {
            $query->active();
        }

        // Apply search filter if $q (search query) is set
        if ($this->q) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->q . '%')
                    ->orWhere('type', 'like', '%' . $this->q . '%');
            });
        }

        // Use orderBy() to sort the results if needed
        $query->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        // Get the SQL query before pagination
        $sqlQuery = $query->toSql();

        // Use paginate() method to fetch paginated results
        $posts = $query->paginate(20);

        return view('livewire.posts', [
            'posts' => $posts,
            'sqlQuery' => $sqlQuery,
        ]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy($field) 
    {

        if($field === $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }

        $this->sortBy = $field;
    }

    public function confirmPostDeletion($postId)
    {
        $this->confirmingPostDeletion = $postId;
    }
    
    public function deletePost()
    {

        $post = Post::find($this->confirmingPostDeletion);
        if ($post) {
            $post->delete();
        }
    
        // After successful deletion, close the modal
        $this->confirmingPostDeletion = null;
        session()->flash('message', 'Post is verwijderd');
    }

    public function confirmPostAdd()
    {
        $this->reset();
        $this->confirmingPostAdd = true;
    }

    public function confirmPostEdit(Post $post)
    {
        $this->post = $post;
        $this->confirmingPostAdd = true;
    }
    

    public function savePost()
    {
        $this->validate();

        // Check to see if the item id isset if so edit existing else create one
        if(isset($this->post->id)) {
            $this->post->save();
            session()->flash('message', 'Post is aangepast');
        } else {
            auth()->user()->posts()->create([
                "title" => $this->post['title'],
                "description" => $this->post['description'],
                "status" => $this->post['status'] ?? 0,
            ]);
            session()->flash('message', 'Post is opgeslagen');
        }

        $this->confirmingPostAdd = false;
    }
}



