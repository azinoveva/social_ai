<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entry;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $json_entries = file_get_contents('socialmaps-items.json');
        $data = json_decode($json_entries, true);
        $data = $data['items'];

        foreach ($data as $item) {

            $description = '';
            foreach($item['description'] as $text) {
                $description .= $text;
            }
            dump($description);
            Entry::create([
                'title' => $item['title'],
                'body' => $text,
                'tags' => $item['tags'],
                'primaryTopic' => $item['primaryTopic'],
            ]);
        }

    }
}
