<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Search\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tag;
use App\Models\PrimaryTopic;

class Entry extends Model
{
    
     protected $casts = [
         'tags' => 'json',
     ];

        public function tags(): BelongsToMany
        {
            return $this->belongsToMany(Tag::class);
        }

        public function primaryTopic(): BelongsTo
        {
            return $this->belongsTo(PrimaryTopic::class);
        }
}
