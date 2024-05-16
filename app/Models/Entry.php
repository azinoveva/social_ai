<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Search\Searchable;

class Entry extends Model
{
    
     protected $casts = [
         'tags' => 'json',
     ];
}
