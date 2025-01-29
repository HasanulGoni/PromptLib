<?php

namespace App\Models;

use App\Models\Tag;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function tags():BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'prompt_tag', 'prompt_id', 'tag_id');
    }
}
