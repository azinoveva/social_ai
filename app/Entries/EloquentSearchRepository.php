<?php
 namespace App\Entries;
 use App\Models\Entry;
 use Illuminate\Database\Eloquent\Collection;
 class EloquentSearchRepository implements SearchRepository
 {
     public function search(string $term): Collection
     {
         return Entry::query()
             ->where(fn ($query) => (
                 $query->where('body', 'LIKE', "%{$term}%")
                     ->orWhere('title', 'LIKE', "%{$term}%")
             ))
             ->get();
     }
 } 