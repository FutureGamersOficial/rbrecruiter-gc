<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'discriminator',
        'last_used',
        'secret',
        'owner_user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
}
