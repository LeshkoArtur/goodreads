<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorStoreData;
use App\Models\Author;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAuthor
{
    use AsAction;

    public function handle(AuthorStoreData $data): Author
    {
        $author = new Author;
        $author->name = $data->name;
        $author->bio = $data->bio;
        $author->birth_date = $data->birth_date;
        $author->birth_place = $data->birth_place ? substr($data->birth_place, 0, 50) : null;
        $author->nationality = $data->nationality ? substr($data->nationality, 0, 50) : null;
        $author->website = $data->website;
        $author->profile_picture = $data->profile_picture;
        $author->death_date = $data->death_date;
        $author->social_media_links = $data->social_media_links;
        $author->media_images = $data->media_images;
        $author->media_videos = $data->media_videos;
        $author->fun_facts = $data->fun_facts;
        $author->type_of_work = $data->type_of_work;
        $author->save();

        if ($data->user_ids) {
            $author->users()->sync($data->user_ids);
        }

        return $author->fresh(['users', 'books']);
    }
}
