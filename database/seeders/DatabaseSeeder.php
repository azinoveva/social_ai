<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Entry;
use App\Models\Tag;
use App\Models\PrimaryTopic;

class DatabaseSeeder extends Seeder
{
    private $tags = [
        'labour' => 'Arbeit und Beschäftigung',
        'counseling' => 'Beratung',
        'sports' => 'Bewegung und Sport',
        'education' => 'Bildung und Sprache',
        'recreation' => 'Freizeit',
        'volunteer_work' => 'Freiwilliges Engagement',
        'health' => 'Gesundheit',
        'hospice' => 'Hospiz',
        'lobby' => 'Interessenvertretung',
        'kindergarden' => 'Kinderbetreuung',
        'arts' => 'Kreativität und Kunst',
        'victim_support' => 'Opferhilfe',
        'care' => 'Pflege',
        'self_help' => 'Selbsthilfe',
        'neighborhood' => 'Stadtteilarbeit und Nachbarschaft',
        'offender_services' => 'Straffälligenhilfe',
        'addiction' => 'Sucht',
        'housing' => 'Wohnen',
    ];

    public function run(): void
    {
        $json_entries = file_get_contents('socialmaps-items.json');
        $data = json_decode($json_entries, true);

        foreach ($data as $item) {

            if (isset($item['description']['de'])) {
                $description = $item['description']['de'];
            } else {
                $description = '';
            }

            if (isset($item['brief']['de'])) {
                $brief = $item['brief']['de'];
            } else {
                $brief = '';
            }

            $entry = Entry::create([
                'title' => $item['title'],
                'body' => $description,
                'brief' => $brief,
                'slug' => $item['id'],
            ]);

            if (isset($item['primaryTopic'])) {
                $primaryTopic = PrimaryTopic::firstOrCreate([
                    'slug' => $item['primaryTopic'],
                    'name' => $this->tags[$item['primaryTopic']],
                ]);
                dump($item['primaryTopic']);
            }

            $tagIds = [];
            
            if (isset($item['tags'])) {
                foreach($item['tags'] as $tag) {
                    $tag = Tag::firstOrCreate([
                        'name' => $tag
                    ]);
                    $tagIds[] = $tag->id;
                }
            }
            $entry->primary_topic_id = $primaryTopic->id;
            $entry->tags()->attach($tagIds);
            $entry->save();

                      
        }

    }
}
