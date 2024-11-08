<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;

class PostForm extends Component
{
    public $post;
    public $title;
    public $content;
    public $tags;
    public $selectedTags = [];

    protected $rules = [
        'title' => 'required|min:5',
        'content' => 'required|min:10',
        'selectedTags' => 'array'
    ];

    public function mount($post = null)
    {
        if ($post) {
            $this->post = $post;
            $this->title = $post->title;
            $this->content = $post->content;
            $this->selectedTags = $post->tags->pluck('id')->toArray();
        }
    }

    public function save()
    {
        $this->validate();

        $isNew = !$this->post;

        if ($isNew) {
            $this->post = new Post();
            $this->post->user_id = auth()->id();
        }

        $this->post->title = $this->title;
        $this->post->slug = Str::slug($this->title);
        $this->post->content = $this->content;
        $this->post->is_published = true;
        $this->post->published_at = now();
        $this->post->save();

        $this->post->tags()->sync($this->selectedTags);

        session()->flash('message', $isNew ? 'Post created successfully.' : 'Post updated successfully.');

        return redirect()->route('posts.show', $this->post);
    }
    public function render()
    {
        $allTags = Tag::all();
        return view('livewire.post-form', [
            'allTags' => $allTags,
        ]);
    }
}
