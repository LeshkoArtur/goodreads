<?php

namespace App\Http\Controllers;

use App\Actions\Books\AttachAuthor;
use App\Actions\Books\AttachGenre;
use App\Actions\Books\AttachPublisher;
use App\Actions\Books\CreateBook;
use App\Actions\Books\DetachAuthor;
use App\Actions\Books\DetachGenre;
use App\Actions\Books\DetachPublisher;
use App\Actions\Books\GetBookAuthors;
use App\Actions\Books\GetBookCharacters;
use App\Actions\Books\GetBookCollections;
use App\Actions\Books\GetBookGenres;
use App\Actions\Books\GetBookOffers;
use App\Actions\Books\GetBookPosts;
use App\Actions\Books\GetBookPublishers;
use App\Actions\Books\GetBookQuestions;
use App\Actions\Books\GetBookQuotes;
use App\Actions\Books\GetBookRatings;
use App\Actions\Books\GetBookReviews;
use App\Actions\Books\GetBooks;
use App\Actions\Books\GetBookSeriesBooks;
use App\Actions\Books\GetBookStats;
use App\Actions\Books\GetSimilarBooks;
use App\Actions\Books\MarkBookAsDNF;
use App\Actions\Books\MarkBookAsFavorite;
use App\Actions\Books\MarkBookAsOnHold;
use App\Actions\Books\MarkBookAsOwned;
use App\Actions\Books\MarkBookAsRead;
use App\Actions\Books\MarkBookAsReading;
use App\Actions\Books\MarkBookAsRereading;
use App\Actions\Books\MarkBookAsWantToRead;
use App\Actions\Books\UpdateBook;
use App\Data\Book\BookIndexData;
use App\Data\Book\BookRelationIndexData;
use App\Data\Book\BookStoreData;
use App\Data\Book\BookUpdateData;
use App\Http\Requests\Book\BookDeleteRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Requests\Book\BookRelationRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\AuthorQuestionResource;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookOfferResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookSeriesResource;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\GenreResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PublisherResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\UserBookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function index(BookIndexRequest $request): AnonymousResourceCollection
    {
        $books = GetBooks::run(BookIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function show(Book $book): BookResource
    {
        return new BookResource($book->load(['authors', 'genres', 'publishers', 'series']));
    }

    public function store(BookStoreRequest $request): BookResource
    {
        $book = CreateBook::run(BookStoreData::fromRequest($request));

        return new BookResource($book);
    }

    public function update(BookUpdateRequest $request, Book $book): BookResource
    {
        $book = UpdateBook::run($book, BookUpdateData::fromRequest($request));

        return new BookResource($book);
    }

    public function destroy(BookDeleteRequest $request, Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'message' => 'Книгу успішно видалено.',
        ], 200);
    }

    public function authors(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $authors = GetBookAuthors::run($book, BookRelationIndexData::fromRequest($request));

        return AuthorResource::collection($authors);
    }

    public function genres(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $genres = GetBookGenres::run($book, BookRelationIndexData::fromRequest($request));

        return GenreResource::collection($genres);
    }

    public function publishers(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $publishers = GetBookPublishers::run($book, BookRelationIndexData::fromRequest($request));

        return PublisherResource::collection($publishers);
    }

    public function series(Book $book): ?BookSeriesResource
    {
        if (! $book->series) {
            return null;
        }

        return new BookSeriesResource($book->series);
    }

    public function seriesBooks(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $books = GetBookSeriesBooks::run($book, BookRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function characters(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $characters = GetBookCharacters::run($book, BookRelationIndexData::fromRequest($request));

        return CharacterResource::collection($characters);
    }

    public function quotes(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $quotes = GetBookQuotes::run($book, BookRelationIndexData::fromRequest($request));

        return QuoteResource::collection($quotes);
    }

    public function ratings(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $ratings = GetBookRatings::run($book, BookRelationIndexData::fromRequest($request));

        return RatingResource::collection($ratings);
    }

    public function reviews(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $reviews = GetBookReviews::run($book, BookRelationIndexData::fromRequest($request));

        return RatingResource::collection($reviews);
    }

    public function posts(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $posts = GetBookPosts::run($book, BookRelationIndexData::fromRequest($request));

        return PostResource::collection($posts);
    }

    public function discussions(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $posts = GetBookPosts::run($book, BookRelationIndexData::fromRequest($request));

        return PostResource::collection($posts);
    }

    public function questions(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $questions = GetBookQuestions::run($book, BookRelationIndexData::fromRequest($request));

        return AuthorQuestionResource::collection($questions);
    }

    public function stats(Book $book): JsonResponse
    {
        $stats = GetBookStats::run($book);

        return response()->json($stats);
    }

    public function similar(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $books = GetSimilarBooks::run($book, BookRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function offers(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $offers = GetBookOffers::run($book, BookRelationIndexData::fromRequest($request));

        return BookOfferResource::collection($offers);
    }

    public function collections(BookRelationRequest $request, Book $book): AnonymousResourceCollection
    {
        $collections = GetBookCollections::run($book, BookRelationIndexData::fromRequest($request));

        return CollectionResource::collection($collections);
    }

    public function attachAuthor(Book $book, Author $author): JsonResponse
    {
        $success = AttachAuthor::run($book, $author);

        if (! $success) {
            return response()->json([
                'message' => 'Автор вже прикріплений до цієї книги.',
            ], 409);
        }

        return response()->json([
            'message' => 'Автора успішно прикріплено до книги.',
        ], 201);
    }

    public function detachAuthor(Book $book, Author $author): JsonResponse
    {
        $success = DetachAuthor::run($book, $author);

        if (! $success) {
            return response()->json([
                'message' => 'Автор не прикріплений до цієї книги.',
            ], 404);
        }

        return response()->json([
            'message' => 'Автора успішно відкріплено від книги.',
        ], 200);
    }

    public function attachGenre(Book $book, Genre $genre): JsonResponse
    {
        $success = AttachGenre::run($book, $genre);

        if (! $success) {
            return response()->json([
                'message' => 'Жанр вже прикріплений до цієї книги.',
            ], 409);
        }

        return response()->json([
            'message' => 'Жанр успішно прикріплено до книги.',
        ], 201);
    }

    public function detachGenre(Book $book, Genre $genre): JsonResponse
    {
        $success = DetachGenre::run($book, $genre);

        if (! $success) {
            return response()->json([
                'message' => 'Жанр не прикріплений до цієї книги.',
            ], 404);
        }

        return response()->json([
            'message' => 'Жанр успішно відкріплено від книги.',
        ], 200);
    }

    public function attachPublisher(Book $book, Publisher $publisher): JsonResponse
    {
        $success = AttachPublisher::run($book, $publisher);

        if (! $success) {
            return response()->json([
                'message' => 'Видавець вже прикріплений до цієї книги.',
            ], 409);
        }

        return response()->json([
            'message' => 'Видавця успішно прикріплено до книги.',
        ], 201);
    }

    public function detachPublisher(Book $book, Publisher $publisher): JsonResponse
    {
        $success = DetachPublisher::run($book, $publisher);

        if (! $success) {
            return response()->json([
                'message' => 'Видавець не прикріплений до цієї книги.',
            ], 404);
        }

        return response()->json([
            'message' => 'Видавця успішно відкріплено від книги.',
        ], 200);
    }

    public function markAsRead(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsRead::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsReading(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsReading::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsWantToRead(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsWantToRead::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsDNF(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsDNF::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsOnHold(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsOnHold::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsFavorite(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsFavorite::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsRereading(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsRereading::run($book, $request->user());

        return new UserBookResource($userBook);
    }

    public function markAsOwned(Request $request, Book $book): UserBookResource
    {
        $userBook = MarkBookAsOwned::run($book, $request->user());

        return new UserBookResource($userBook);
    }
}
