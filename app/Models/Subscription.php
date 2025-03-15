<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $casts = [
        'expires_at' => 'datetime', // Or 'timestamp' if it's a timestamp
    ];
    
    protected $fillable = ['user_id', 'plan', 'payment_details', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
