<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias=[
            'Informatica'=>"#c0392b",
            'VideoJuegos'=>"#52be80",
            'Cine'=>"#52be80",
            'Deportes'=>"#f39c12",
            "Música"=>"#424949"
        ];
        foreach($categorias as $nombre=>$color){
            Category::create([
                'nombre'=>$nombre,
                'color'=>$color
            ]);
        }
    }
}
