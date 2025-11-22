<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedParticipant extends Model
{
    protected $table = 'fixed_participants';

    protected $fillable = [
        'name',
        'team',
        'chest_no',
        'section',
    ];

    public $timestamps = true;
}
