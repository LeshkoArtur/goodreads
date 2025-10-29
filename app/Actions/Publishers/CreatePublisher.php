<?php

namespace App\Actions\Publishers;

use App\Data\Publisher\PublisherStoreData;
use App\Models\Publisher;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePublisher
{
    use AsAction;

    public function handle(PublisherStoreData $data): Publisher
    {
        $publisher = new Publisher;
        $publisher->name = $data->name;
        $publisher->description = $data->description;
        $publisher->website = $data->website;
        $publisher->country = $data->country;
        $publisher->founded_year = $data->founded_year;
        $publisher->logo = $data->logo;
        $publisher->contact_email = $data->contact_email;
        $publisher->phone = $data->phone;
        $publisher->save();

        return $publisher->fresh(['books']);
    }
}
