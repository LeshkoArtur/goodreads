<?php

namespace App\Actions\Authors;

use App\DTOs\Author\AuthorStoreDTO;
use App\Models\Author;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAuthor
{
    use AsAction;

    /**
     * Створити нового автора.
     *
     * @param AuthorStoreDTO $dto
     * @return Author
     */
    public function handle(AuthorStoreDTO $dto): Author
    {
        $author = new Author();
        $author->name = $dto->name;
        $author->bio = $dto->bio;
        $author->birth_date = $dto->birthDate;
        $author->birth_place = $dto->birthPlace;
        $author->nationality = $dto->nationality;
        $author->website = $dto->website;
        $author->profile_picture = $dto->profilePicture;
        $author->death_date = $dto->deathDate;
        $author->social_media_links = $dto->socialMediaLinks;
        $author->media_images = $dto->mediaImages;
        $author->media_videos = $dto->mediaVideos;
        $author->fun_facts = $dto->funFacts;
        $author->type_of_work = $dto->typeOfWork;

        if ($dto->profilePicture) {
            $author->profile_picture = $author->handleFileUpload($dto->profilePicture, 'author_profiles');
        }

        $author->save();

        if ($dto->userIds) {
            $author->users()->sync($dto->userIds);
        }


        return $author->load(['users']);
    }
}
