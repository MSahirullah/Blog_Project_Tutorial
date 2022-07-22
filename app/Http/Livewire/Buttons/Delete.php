<?php

namespace App\Http\Livewire\Buttons;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class Delete extends Component
{
    public $post;
    public bool $confirmPostDeletion = false;

    public function confirmPostDeletion()
    {
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('confirming-delete-post');
        $this->confirmPostDeletion = true;
    }

    public function deletePost()
    {
        File::delete(storage_path('app/public/images/' . $this->post->cover_image));
        $this->post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }

    public function render()
    {
        return view('livewire.buttons.delete');
    }
}
