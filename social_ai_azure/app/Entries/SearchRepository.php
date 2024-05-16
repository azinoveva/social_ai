<?php

namespace App\Entries;

use Illuminate\Database\Eloquent\Collection;

interface SearchRepository
{
    public function search(string $query): Collection;
}