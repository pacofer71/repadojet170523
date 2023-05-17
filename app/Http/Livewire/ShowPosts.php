<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;
    public string $campo='id', $orden='desc';
    public string $buscar="";
    
    protected $listeners=[
        'render'
    ];

    public function updatingBuscar(){
        $this->resetPage();
    }

    public function render()
    {
        $posts=Post::with('category')
        ->where('user_id', auth()->user()->id)
        ->where('titulo', 'like', "%$this->buscar%")
        ->orderBy($this->campo, $this->orden)
        ->paginate(5);
        return view('livewire.show-posts', compact('posts'));
    }

    public function ordenar(string $campo){
        $this->orden=($this->orden=='desc') ? 'asc' : 'desc';
        $this->campo=$campo;
    }
}
