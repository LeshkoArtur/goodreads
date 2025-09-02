<?php

namespace App\Actions\Publishers;

use App\DTOs\Publisher\PublisherUpdateDTO;
use App\Models\Publisher;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePublisher
{
    use AsAction;

    /**
     * Оновити існуючого видавця.
     *
     * @param Publisher $publisher
     * @param PublisherUpdateDTO $dto
     * @return Publisher
     */
    public function handle(Publisher $publisher, PublisherUpdateDTO $dto): Publisher
    {
        $attributes = [
            'name' => $dto->name,
            'country' => $dto->country,
            'founded_year' => $dto->foundedYear,
            'contact_email' => $dto->contactEmails[0] ?? null, // Assuming single email for simplicity
            'description' => $dto->description,
        ];

        $publisher->fill(array_filter($attributes, fn($value) => $value !== null));

        $publisher->save();

        return $publisher->load(['books']);
    }
}
