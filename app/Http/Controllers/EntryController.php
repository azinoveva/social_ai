<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\PrimaryTopic;
use App\Models\Tag;


class EntryController extends Controller
{

    public function azureQueryConstructor(Request $request)
    // Call the vectorize_search.py script to get the vector representation of the search query
    // The vectorize_search.py script is a Python script that uses the BERT model
    // to convert the search query into a vector representation

    // The vector representation is then used to query the Azure Cognitive Search service
    {   
        $text = $request->input('q');

        $client = new Client();
        $url = env('AZURE_FUNCTION_URL');
        $primary_topic = $request->input('primary_topic');
        
        try {
            $response = $client->post($url, [
                'json' => [
                    'text' => $text
                ]
            ]);

            $body = $response->getBody();
            $vector = json_decode($body, true);

            return $vector[0];
        } catch (RequestException $e) {
            // Handle exception or return an error message
            return ['error' => 'Unable to process request'];
        }
    }

    public function keywordSearch(Request $request)
    {
        $term = $request->input('q');
        $primary_topic = $request->input('primary_topic');
        $perPage = 10; // Number of items per page

        $tokens = explode(' ', $term);
        $matchQuery = '';
        foreach ($tokens as $token) {
            $matchQuery .= "+{$token} ";
        }

        $entries = Entry::query();

        if ($term || $primary_topic) {
            foreach ($tokens as $token) {
                $entries->where(function ($query) use ($token) {
                    $token = '%' . $token . '%';
                    $query->where('title', 'LIKE', $token)
                          ->orWhere('body', 'LIKE', $token)
                          ->orWhere('brief', 'LIKE', $token);
                });
            }
            if($primary_topic) {
                 $entries->where('primary_topic_id', $primary_topic);
            }
        } else {
            $entries = Entry::all();
        }

        $entries = $entries->paginate($perPage);


        return view('dashboard', ['entries' => $entries, 'primaryTopics' => PrimaryTopic::all()]);
    }

    public function azureSearch(Request $request)
    // Query the Azure Cognitive Search service
    
    {
        $term = $request->input('q');
        $primary_topic = $request->input('primary_topic');
        $perPage = 10; // Number of items per page

        if (empty($term) && empty($primary_topic)) {
            return view('dashboard', ['entries' => Entry::paginate($perPage), 'primaryTopics' => PrimaryTopic::all()]);
        }
        else {

            $endpoint = env('AZURE_SEARCH_SERVICE_NAME');
            $apiKey = env('AZURE_SEARCH_API_KEY');
            $indexName = env('AZURE_SEARCH_INDEX_NAME');
            $apiVersion = '2023-11-01';

            $vector = $this->azureQueryConstructor($request);

            $searchQuery = [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'api-key' => $apiKey,
                ],
                'json' => [
                    "search" => "{$term}",
                    "count" => true,
                    "select" => "id",
                    "facets" => ["primaryTopic", "tags"],
                    "queryType" => "semantic",
                    "answers" => "extractive|count-3",
                    "captions" => "extractive|highlight-true",
                    "semanticConfiguration" => "my-semantic-config",
                    "vectorQueries" => [
                        [
                        "vector" => $vector,
                        "fields" => "vector_title, vector_description, vector_brief",  // Field name where vectors are stored in the index
                        "k" => 10,  // Number of results to return
                        "kind" => "vector",
                        "exhaustive" => true,
                        ],
                    ],
                ]
        ];

            $client = new Client();

            $response = $client->post("https://$endpoint.search.windows.net/indexes/$indexName/docs/search?api-version=$apiVersion", $searchQuery);

            $data = json_decode($response->getBody()->getContents(), true);

            $collection = collect();

            // If the response is successful, get the entries from the database
            if ($response->getStatusCode() == 200){

                $facets = $data['@search.facets']['tags'];
                $primaryFacets = $data['@search.facets']['primaryTopic'];

                $tags = "";
                $primaryTags = "";

                for ($i = 0; $i < min(5, count($facets)); $i++) {
                    $tags .= $facets[$i]['value'] . ", ";
                }
                $tags = substr($tags, 0, -2);

                for ($i = 0; $i < min(2, count($primaryFacets)); $i++) {
                    $primaryFacets[$i]['value'] = PrimaryTopic::where('slug', $primaryFacets[$i]['value'])->first();
                    $primaryTags .= $primaryFacets[$i]['value']->name . ", ";
                }
                $primaryTags = substr($primaryTags, 0, -2);

                for ($i = 0; $i < count($data['value']); $i++) {
                    $entry = Entry::where('slug', $data['value'][$i]['id'])->first();
                    $collection->add($entry);
                }

                if (!empty($primary_topic)) {
                    $collection = $collection->where('primary_topic_id', $primary_topic);
                }
                $collection = $collection->paginate($perPage);
                return view('dashboard', ['entries' => $collection, 'primaryTopics' => PrimaryTopic::all(), 'primaryTags' => $primaryTags, 'tags' => $tags]);
            } else {
                return ['entries' => [], 'primaryTopics' => PrimaryTopic::all()];
            }
        }
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function primaryTopic()
    {
        return $this->belongsTo(PrimaryTopic::class);
    }

}

