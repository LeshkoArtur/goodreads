<?php

namespace App\Actions\Publishers;

use App\DTOs\Publisher\PublisherStoreDTO;
use App\Models\Publisher;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePublisher
{
    use AsAction;

    /**
     * Створити нового видавця.
     *
     * @param PublisherStoreDTO $dto
     * @return Publisher
     */
    public function handle(PublisherStoreDTO $dto): Publisher
    {
        $publisher = new Publisher();
        $publisher->name = $dto->name;
        $publisher->description = $dto->description;
        $publisher->website = $dto->website;
        $publisher->country = $dto->country;
        $publisher->founded_year = $dto->foundedYear;
        $publisher->contact_email = $dto->contactEmail;
        $publisher->phone = $dto->phone;

        if ($dto->logo) {
            $publisher->logo = $publisher->handleFileUpload($dto->logo, 'logos');
        }

        $publisher->save();

        return $publisher->load(['books']);
    }
}
