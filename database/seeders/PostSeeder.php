<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts=Post::factory(60)->create();
        foreach($posts as $post){
            $post->tags()->attach($this->devolverIdTags());
        }
    }

    private function devolverIdTags(): array{
        $entrada=[1,2,3,4,5,6];
        return array_slice($entrada, random_int(0, 2), random_int(1,3));
    }
}
