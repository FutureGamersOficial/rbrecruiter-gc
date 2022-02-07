<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
      'requesterID',
      'start',
      'predicted_end',
      'available_assist',
      'reason',
      'status',
      'reviewer',
      'reviewed_date'
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo('App\User', 'requesterID', 'id');
    }
}
