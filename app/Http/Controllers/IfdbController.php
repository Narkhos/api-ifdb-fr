<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenApi\Attributes as OA;
use SimpleXMLElement;

#[OA\Schema(
    schema: "Game",
    description: "Game detail",
    properties: [
        new OA\Property(property: "tuid", type: "string", example: "rddap2p8rbqok2qb",),
        new OA\Property(property: "title", type: "string", example: "Deux pages avant la fin du monde"),
        new OA\Property(property: "link", type: "string", example: "https://ifdb.org/viewgame?id=rddap2p8rbqok2qb"),
        new OA\Property(property: "author", type: "string", example: "Narkhos"),
        new OA\Property(property: "averageRating", type: "string", example: "4.5"),
        new OA\Property(property: "numRatings", type: "string", example: "2"),
        new OA\Property(property: "starRating", type: "string", example: "4.5"),
        new OA\Property(property: "hasCoverArt", type: "string", example: "yes"),
        new OA\Property(property: "devsys", type: "string", example: "Custom"),
        new OA\Property(
            property: "published",
            type: "array",
            items: new OA\Items(
                properties: [
                    new OA\Property(property: "machine", type: "string", format: "date", example: "2023-01-31"),
                    new OA\Property(property: "printable", type: "string", example: "January 31, 2023")
                ]
            )
        ),
        new OA\Property(property: "coverArtLink", type: "string", example: "https://ifdb.org/viewgame?id=rddap2p8rbqok2qb&coverart"),
    ]
)]
#[OA\Schema(
    schema: "GameList",
    description: "Game list",
    properties: [
        new OA\Property(
            property: 'games',
            type: 'object',
            properties: [
                new OA\Property(
                    property: "game",
                    type: "array",
                    items: new OA\Items(ref: '#/components/schemas/Game')
                ),
            ]
        ),
    ]
)]
class IfdbController extends Controller
{
    #[OA\Get(
        path: '/',
        summary: 'Display a listing of games.',
        parameters: [
            new OA\Parameter(
                name: "searchfor",
                in: "query"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'successful operation',
                content: new OA\JsonContent(ref: "#/components/schemas/GameList")
            ),
            new OA\Response(
                response: '404',
                description: 'Not found.'
            ),
            new OA\Response(
                response: '422',
                description: 'Unprocessable Entity.'
            ),

        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'searchfor' => 'string|required',
        ]);
        $result = Http::get('https://ifdb.org/search?xml&game&searchfor=' . $request->searchfor);

        return JsonResponse::fromJsonString(json_encode(new SimpleXMLElement($result)));
    }

    #[OA\Get(
        path: "/competitions/{id}",
        summary: "List games in a given competition",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'successful operation',
            ),
            new OA\Response(
                response: '404',
                description: 'Not found.'
            ),
            new OA\Response(
                response: '422',
                description: 'Unprocessable Entity.'
            ),

        ]
    )]
    public function competitionEntries(Request $request, string $id): JsonResponse
    {
        $matches = [];
        $result = Http::get('https://ifdb.org/viewcomp?id=' . $id);
        $pattern = '/href="viewgame\?id=([a-zA-Z0-9]+)"/';
        preg_match_all($pattern, $result->body(), $matches);
        $listId = array_values(array_unique($matches[1]));

        if (count($listId) === 0) {
            abort(404, 'No entry found for comp ' . $id);
        }

        return response()->json($listId);
    }

    public function gameDetail(Request $request, string $id): JsonResponse
    {
        $result = Http::get('https://ifdb.org/viewgame?ifiction&id=' . $id);

        return JsonResponse::fromJsonString(json_encode(new SimpleXMLElement($result)));
    }
}
