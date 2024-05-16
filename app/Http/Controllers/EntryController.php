<?php

namespace App\Http\Controllers;

use App\Services\AzureAISearchService;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    protected $searchService;

   
    public function __construct(AzureAISearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function indexJson(Request $request)
    {
        // Receive the uploaded JSON file
        $json_entries = file_get_contents($request->file('json_file'));

        // Process the uploaded JSON file (e.g., parse and save to the database)
        $data = json_decode($json_entries, true);

        $data = $data['items'];

        $response = $this->searchService->indexData($data);

        return response()->json($response);

        // Your logic to handle the JSON data

        //return view('index-success')->with('success', 'JSON file uploaded successfully.');
    }
}

