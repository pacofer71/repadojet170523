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
    public string $titulo, $contenido, $category_id, $estado;
    
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
        $this->reset(['openCrear']);
        $this->emitTo('show-posts', 'render');
    }
}
