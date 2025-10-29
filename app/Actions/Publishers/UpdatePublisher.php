<?php

namespace App\Actions\Publishers;

use App\Data\Publisher\PublisherUpdateData;
use App\Models\Publisher;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePublisher
{
    use AsAction;

    public function handle(Publisher $publisher, PublisherUpdateData $data): Publisher
    {
        $publisher->update(array_filter([
            'name' => $data->name,
            'description' => $data->description,
            'website' => $data->website,
            'country' => $data->country,
            'founded_year' => $data->founded_year,
            'logo' => $data->logo,
            'contact_email' => $data->contact_email,
            'phone' => $data->phone,
        ], fn ($value) => $value !== null));

        return $publisher->fresh(['books']);
    }
}
