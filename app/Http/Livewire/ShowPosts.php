<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public string $campo='id', $orden='desc';
    public string $buscar="";
    public bool $openDetalle=false, $openEditar=false;
    public $imagen;
    public Post $miPost;
    public array $selectedTags=[];
    
    protected $listeners=[
        'render',
        'borrarPost'=>'borrar'
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
        $categorias=Category::orderBy('nombre')->pluck('nombre', 'id')->toArray();

        
        $etiquetas=Tag::orderBy('nombre')->pluck('nombre', 'id')->toArray();
        return view('livewire.show-posts', compact('posts', 'categorias', 'etiquetas'));
    }

    protected function rules(): array{
        return [
            'miPost.titulo'=>['required', 'string', 'min:3', 'unique:posts,titulo,'.$this->miPost->id],
            'miPost.contenido'=>['required', 'string', 'min:10'],
            'miPost.estado'=>['required', 'in:PUBLICADO,BORRADOR'],
            'miPost.category_id'=>['required', 'exists:categories,id'],
            'imagen'=>['nullable', 'image', 'max:2048'],
            'selectedTags'=>['required', 'exists:tags,id'],
        ];
    }

    public function ordenar(string $campo){
        $this->orden=($this->orden=='desc') ? 'asc' : 'desc';
        $this->campo=$campo;
    }

    public function detalle(Post $post){
        $this->authorize('view', $post);
        $this->miPost=$post;
        $this->openDetalle=true;
    }

    public function confirmar(Post $post){
        $this->authorize('delete', $post);
        $this->emit('permisoBorrar', $post->id);
    }
    
    public function borrar(Post $post){
        //Borramos la imagen asociada al post
       
        Storage::delete($post->imagen);
        //Borro el registro de la bbdd
        $post->delete();
        //emito un mensaje
        $this->emit('mensaje', "Post borrado");
    }

    public function editar(Post $post){
        $this->authorize('update', $post);
        $this->miPost=$post;

        $this->selectedTags=$this->miPost->tags->pluck('id')->toArray();
        
        $this->openEditar=true;
    }

    public function update(){
        $this->validate();

        //si he subido una imagen debo borrar la vieja y guardar la nueva
        $ruta=$this->miPost->imagen;
        if($this->imagen){
            $ruta=$this->imagen->store('imagenes');
            Storage::delete($this->miPost->imagen);
        }
        $this->miPost->update([
            'titulo'=>$this->miPost->titulo,
            'contenido'=>$this->miPost->contenido,
            'category_id'=>$this->miPost->category_id,
            'estado'=>$this->miPost->estado,
            'imagen'=>$ruta,
        ]);
        
        $this->miPost->tags()->sync($this->selectedTags);

        $this->miPost=new Post;
        $this->reset(['openEditar', 'imagen']);
        $this->emit('mensaje', 'Post Editado');
    }
    public function cambiarEstado(Post $post){
        $estado=($post->estado=="PUBLICADO") ? "BORRADOR" : "PUBLICADO";
        $post->update([
            'estado'=>$estado,
        ]);
        $this->emit("mensaje", "De cambió es estado del post");
    }
}
