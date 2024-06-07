<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class IfdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //: JsonResponse
    {
        $result = Http::get('https://ifdb.org/search?xml&game&searchfor=author:"Narkhos"');
        return JsonResponse::fromJsonString(json_encode(new SimpleXMLElement($result)));
    }

    public function competitionEntries(Request $request) //: JsonResponse
    {
        $matches = [];
        $result = Http::get('https://ifdb.org/viewcomp?id=k8u91dwgvhv5r8ls');
        $pattern = '/href="viewgame\?id=([a-zA-Z0-9]+)"/';
        preg_match_all($pattern, $result->body(), $matches);
        $listId = array_values(array_unique($matches[1]));
        return response()->json($listId);
    }

    public function gameDetail(Request $request): JsonResponse
    {
        $result = Http::get("https://ifdb.org/viewgame?ifiction&id=".$request->id);
        return JsonResponse::fromJsonString(json_encode(new SimpleXMLElement($result)));
    }
}
