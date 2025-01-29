<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function prompts():BelongsToMany
    {
        return $this->belongsToMany(Prompt::class, 'prompt_tag', 'tag_id', 'prompt_id');
    }
}
