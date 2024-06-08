<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use OpenApi\Attributes as OA;

class IfdbController extends Controller
{
    #[OA\Get(path: '/', description: 'Display a listing of games.')]
    #[OA\Response(response: JsonResponse::HTTP_OK, description: 'OK')]
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'searchfor' => 'string|required',
        ]);
        $result = Http::get('https://ifdb.org/search?xml&game&searchfor='.$request->searchfor);

        return JsonResponse::fromJsonString(json_encode(new SimpleXMLElement($result)));
    }

    public function competitionEntries(Request $request, string $id) //: JsonResponse
    {
        $matches = [];
        $result = Http::get('https://ifdb.org/viewcomp?id='.$id);
        $pattern = '/href="viewgame\?id=([a-zA-Z0-9]+)"/';
        preg_match_all($pattern, $result->body(), $matches);
        $listId = array_values(array_unique($matches[1]));

        if (count($listId) === 0) {
            abort(404, 'No entry found for comp '.$id);
        }

        return response()->json($listId);
    }

    public function gameDetail(Request $request, string $id): JsonResponse
    {
        $result = Http::get('https://ifdb.org/viewgame?ifiction&id='.$id);

        return JsonResponse::fromJsonString(json_encode(new SimpleXMLElement($result)));
    }
}
