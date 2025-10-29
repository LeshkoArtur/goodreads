<?php

namespace App\Actions\Favorites;

use App\Data\Favorite\FavoriteToggleData;
use App\Models\Favorite;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ToggleFavorite
{
    use AsAction;

    public function handle(FavoriteToggleData $data, User $user): array
    {
        $favorite = Favorite::where('user_id', $user->id)
            ->where('favoriteable_type', $data->favoriteable_type)
            ->where('favoriteable_id', $data->favoriteable_id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return [
                'action' => 'removed',
                'message' => 'Видалено з улюблених.',
            ];
        }

        $favorite = new Favorite;
        $favorite->user_id = $user->id;
        $favorite->favoriteable_type = $data->favoriteable_type;
        $favorite->favoriteable_id = $data->favoriteable_id;
        $favorite->save();

        return [
            'action' => 'added',
            'message' => 'Додано в улюблені.',
            'favorite' => $favorite->fresh(['user', 'favoriteable']),
        ];
    }
}
