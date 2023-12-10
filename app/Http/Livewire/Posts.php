<?php

namespace App\Http\Livewire;

use App\Models\MusicianType;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $active;
    public $q;
    public $sortBy = 'id';
    public $sortAsc = false;
    public $post;
    public $selectedProvince;
    public $selectedType;
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
        'post.type' => 'required|string|min:4',
        'post.province' => 'required|string|min:4',
        'post.status' => 'boolean'
    ];

    public function render()
    {
        $query = Post::query()->with('province');
        $provinces = Province::all();
        $musicTypes = MusicianType::all();

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

        if ($this->selectedProvince) {
            $query->whereHas('province', function ($query) {
                $query->where('title', $this->selectedProvince);
            });
        }

        if ($this->selectedType) {
            $query->whereHas('musicianType', function ($query) {
                $query->where('name', $this->selectedType);
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
            'provinces' => $provinces,
            'types' => $musicTypes
        ]);
    }

    public function updatingActive(): void
    {
        $this->resetPage();
    }

    // If we are on another page and type in title go back to first page
    public function updatingQ(): void
    {
        $this->resetPage();
    }

       // If we are on another page and select another type show the results
    public function updatingSelectedType(): void
    {
        $this->resetPage();
    }

   // If we are on another page and select another province show the results
    public function updatingSelectedProvince(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {

        if($field === $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }

        $this->sortBy = $field;
    }

    public function checkOwner($postUserId): bool
    {
        if($postUserId === Auth::user()->id)
        {
            return true;
        }

        return false;
    }

    public function confirmPostDeletion($postId): void
    {
        $this->confirmingPostDeletion = $postId;
    }

    public function deletePost(): void
    {
        $post = Post::find($this->confirmingPostDeletion);

        if ($post && $this->checkOwner($post->user_id)) {
            $post->delete();

             // After successful deletion, close the modal
            $this->confirmingPostDeletion = null;
            session()->flash('message', 'Post is verwijderd');
        }
    }

    public function confirmPostAdd(): void
    {
        $this->reset();
        $this->confirmingPostAdd = true;
    }

    public function confirmPostEdit(Post $post): void
    {
        $this->post = $post;
        $this->confirmingPostAdd = true;
    }

    public function savePost(): void
    {
        $this->validate();

        // Check if post belongs to auth user

        // Check to see if the item id isset if so edit existing else create one
        if(isset($this->post->id)) {
            if(isset($this->post->user_id) && $this->checkOwner($this->post->user_id)) {
                $this->post->save();
                session()->flash('message', 'Post is aangepast');
            }
        } else {
            auth()->user()->posts()->create([
                "title" => $this->post['title'],
                "description" => $this->post['description'],
                "type" => $this->post['type'],
                "province" => $this->post['province'],
                "status" => $this->post['status'] ?? 0,
            ]);
            session()->flash('message', 'Post is opgeslagen');
        }


        $this->confirmingPostAdd = false;
    }
}



