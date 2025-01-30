<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedPrompt extends Model
{
    protected $fillable = ['user_id', 'prompt_id', 'reason'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }
}
