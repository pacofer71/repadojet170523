<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['titulo', 'contenido', 'estado', 'imagen', 'category_id', 'user_id'];

    //Relaciones
    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    //Relacion N:M con tags
    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class);
    }
}
