<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    public bool $openCrear=false;
    public $imagen;
    public string $titulo="", $contenido="", $estado="", $category_id="";
    
    protected function rules(): array{
        return [
            'titulo'=>['required', 'string', 'min:3', 'unique:posts,titulo'],
            'contenido'=>['required', 'string', 'min:10'],
            'estado'=>['required', 'in:PUBLICADO,BORRADOR'],
            'category_id'=>['required', 'exists:categories,id'],
            'imagen'=>['required', 'image', 'max:2048']
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
        ksort($categorias);
        return view('livewire.create-post', compact('categorias'));
    }

    public function guardar(){
        $this->validate();
        $rutaImagen=$this->imagen->store('imagenes');
        Post::create([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'category_id'=>$this->category_id,
            'estado'=>$this->estado,
            'imagen'=>$rutaImagen,
            'user_id'=>auth()->user()->id
        ]);
        $this->reset(['openCrear', 'imagen', 'titulo', 'contenido', 'estado', 'category_id']);
        $this->emitTo('show-posts', 'render');
        $this->emit('mensaje', 'Post guardado con éxito.');
    }
    public function cerrar(){
        $this->reset(['openCrear', 'imagen', 'titulo', 'estado', 'contenido', 'category_id']);
    }
}
