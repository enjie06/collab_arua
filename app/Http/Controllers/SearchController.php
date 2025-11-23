<?php

namespace App\Http\Controllers;

use App\Services\SparqlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    protected $sparqlService;

    public function __construct(SparqlService $sparqlService)
    {
        $this->sparqlService = $sparqlService;
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        
        // Test connection first
        if (!$this->sparqlService->testConnection()) {
            return view('search.error', [
                'message' => 'Server RDF sedang tidak dapat diakses. Silakan coba lagi nanti.',
                'keyword' => $keyword
            ]);
        }
        
        $results = $this->sparqlService->searchWisata($keyword);

        return view('search.results', [
            'results' => $results,
            'keyword' => $keyword
        ]);
    }

    public function byCategory($category)
    {
        if (!$this->sparqlService->testConnection()) {
            return view('search.error', [
                'message' => 'Server RDF sedang tidak dapat diakses. Silakan coba lagi nanti.',
                'category' => $category
            ]);
        }

        $results = $this->sparqlService->getByKategori($category);

        return view('search.category', [
            'results' => $results,
            'category' => $category
        ]);
    }

    public function allWisata()
    {
        if (!$this->sparqlService->testConnection()) {
            return view('search.error', [
                'message' => 'Server RDF sedang tidak dapat diakses. Silakan coba lagi nanti.'
            ]);
        }

        $results = $this->sparqlService->getAllWisata();

        return view('search.all', [
            'results' => $results
        ]);
    }
}