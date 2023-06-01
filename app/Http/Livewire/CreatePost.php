<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    public bool $openCrear=false;
    public $imagen;
    public string $titulo="", $contenido="", $estado="", $category_id="";
    public array $tags=[];
    
    protected function rules(): array{
        return [
            'titulo'=>['required', 'string', 'min:3', 'unique:posts,titulo'],
            'contenido'=>['required', 'string', 'min:10'],
            'estado'=>['required', 'in:PUBLICADO,BORRADOR'],
            'category_id'=>['required', 'exists:categories,id'],
            'imagen'=>['required', 'image', 'max:2048'],
            'tags'=>['required', 'exists:tags,id']
        ];
    }

    public function render()
    {
        $categorias=Category::orderBy('nombre')->pluck('nombre', 'id')->toArray();
        /*
        [
            '-1'=>_____Elige una categoria_____
            '1'=>Informatica,
            '3'=>Deportes
        ]
        */
        $categorias[-1]="______ Elige una categoría _______";
        $etiquetas=Tag::orderBy('nombre')->pluck('nombre', 'id')->toArray();

        ksort($categorias);
        return view('livewire.create-post', compact('categorias', 'etiquetas'));
    }

    public function guardar(){
        $this->validate();
        $rutaImagen=$this->imagen->store('imagenes');
        $post=Post::create([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'category_id'=>$this->category_id,
            'estado'=>$this->estado,
            'imagen'=>$rutaImagen,
            'user_id'=>auth()->user()->id
        ]);
        $post->tags()->attach($this->tags);

        $this->reset(['openCrear', 'imagen', 'titulo', 'contenido', 'estado', 'category_id']);
        $this->emitTo('show-posts', 'render');
        $this->emit('mensaje', 'Post guardado con éxito.');
    }
    public function cerrar(){
        $this->reset(['openCrear', 'imagen', 'titulo', 'estado', 'contenido', 'category_id']);
    }
}
