<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    public $fillable = [

        'userID',
        'approvalDate',
        'terminationDate',
        'resignationDate',
        'memberNotes'

    ];
}
