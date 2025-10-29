<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorUpdateData;
use App\Models\Author;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAuthor
{
    use AsAction;

    public function handle(Author $author, AuthorUpdateData $data): Author
    {
        $author->update(array_filter([
            'name' => $data->name,
            'bio' => $data->bio,
            'birth_date' => $data->birth_date,
            'birth_place' => $data->birth_place,
            'nationality' => $data->nationality,
            'website' => $data->website,
            'profile_picture' => $data->profile_picture,
            'death_date' => $data->death_date,
            'social_media_links' => $data->social_media_links,
            'media_images' => $data->media_images,
            'media_videos' => $data->media_videos,
            'fun_facts' => $data->fun_facts,
            'type_of_work' => $data->type_of_work,
        ], fn ($value) => $value !== null));

        when($data->user_ids !== null, fn () => $author->users()->sync($data->user_ids));

        return $author->fresh(['users', 'books']);
    }
}
