<?php

namespace App\Http\Controllers;

use App\Actions\Characters\CreateCharacter;
use App\Actions\Characters\FavoriteCharacter;
use App\Actions\Characters\GetCharacterBook;
use App\Actions\Characters\GetCharacters;
use App\Actions\Characters\GetCharacterStats;
use App\Actions\Characters\UnfavoriteCharacter;
use App\Actions\Characters\UpdateCharacter;
use App\Data\Character\CharacterIndexData;
use App\Data\Character\CharacterStoreData;
use App\Data\Character\CharacterUpdateData;
use App\Http\Requests\Character\CharacterDeleteRequest;
use App\Http\Requests\Character\CharacterIndexRequest;
use App\Http\Requests\Character\CharacterStoreRequest;
use App\Http\Requests\Character\CharacterUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CharacterController extends Controller
{
    public function index(CharacterIndexRequest $request): AnonymousResourceCollection
    {
        $characters = GetCharacters::run(CharacterIndexData::fromRequest($request));

        return CharacterResource::collection($characters);
    }

    public function show(Character $character): CharacterResource
    {
        return new CharacterResource($character->load(['book']));
    }

    public function store(CharacterStoreRequest $request): CharacterResource
    {
        $character = CreateCharacter::run(CharacterStoreData::fromRequest($request));

        return new CharacterResource($character);
    }

    public function update(CharacterUpdateRequest $request, Character $character): CharacterResource
    {
        $character = UpdateCharacter::run($character, CharacterUpdateData::fromRequest($request));

        return new CharacterResource($character);
    }

    public function destroy(CharacterDeleteRequest $request, Character $character): JsonResponse
    {
        $character->delete();

        return response()->json([
            'message' => 'Персонажа успішно видалено.',
        ], 200);
    }

    public function book(Character $character): BookResource
    {
        $book = GetCharacterBook::run($character);

        return new BookResource($book);
    }

    public function stats(Character $character): JsonResponse
    {
        $stats = GetCharacterStats::run($character);

        return response()->json($stats);
    }

    public function favorite(Request $request, Character $character): JsonResponse
    {
        $favorited = FavoriteCharacter::run($character, $request->user());

        return response()->json([
            'message' => $favorited ? 'Персонажа додано до улюблених.' : 'Персонаж вже в улюблених.',
            'favorited' => $favorited,
        ], 200);
    }

    public function unfavorite(Request $request, Character $character): JsonResponse
    {
        $unfavorited = UnfavoriteCharacter::run($character, $request->user());

        return response()->json([
            'message' => $unfavorited ? 'Персонажа видалено з улюблених.' : 'Персонаж не був в улюблених.',
            'unfavorited' => $unfavorited,
        ], 200);
    }
}
