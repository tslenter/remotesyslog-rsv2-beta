<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Search extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
