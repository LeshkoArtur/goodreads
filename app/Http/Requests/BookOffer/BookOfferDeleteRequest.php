<?php

namespace App\Http\Requests\BookOffer;

use App\Models\BookOffer;
use Illuminate\Foundation\Http\FormRequest;

class BookOfferDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $bookOffer = $this->route('book_offer');
        return $this->user()->can('delete', $bookOffer);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'book_offer' => [
                'description' => 'ID пропозиції книги для видалення.',
                'example' => 'offer-uuid123',
            ],
        ];
    }
}
