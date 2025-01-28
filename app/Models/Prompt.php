<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;
    protected $fillable = ['topic', 'prompt_text', 'tags', 'category_id', 'language', 'rating', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'prompt_user');
    }
}
