<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $bio
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $birth_place
 * @property string|null $nationality
 * @property string|null $website
 * @property string|null $profile_picture
 * @property \Illuminate\Support\Carbon|null $death_date
 * @property \Illuminate\Support\Collection|null $social_media_links
 * @property \Illuminate\Support\Collection|null $media_images
 * @property \Illuminate\Support\Collection|null $media_videos
 * @property \Illuminate\Support\Collection|null $fun_facts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\TypeOfWork|null $type_of_work
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuthorAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NominationEntry> $nominations
 * @property-read int|null $nominations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuthorQuestion> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author alive()
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author bornAfter(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author deceased()
 * @method static \Database\Factories\AuthorFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author newModelQuery()
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author newQuery()
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author query()
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereBio($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereBirthDate($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereBirthPlace($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereCreatedAt($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereDeathDate($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereFunFacts($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereHasBook(string $bookId)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereId($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereMediaImages($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereMediaVideos($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereName($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereNationality($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereProfilePicture($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereSocialMediaLinks($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereTypeOfWork($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereUpdatedAt($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author whereWebsite($value)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author withNationality(string $nationality)
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author withPosts()
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author withProfilePicture()
 * @method static \App\Models\Builders\AuthorQueryBuilder<static>|Author withTypeOfWork(string $type)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthor {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $question_id
 * @property string $author_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
<<<<<<< HEAD
 * @property string $answer_status
=======
>>>>>>> ddf399eaeb167a63c56b43963d810c2306a971c3
 * @property \App\Enums\AnswerStatus $status
 * @property-read \App\Models\Author $author
 * @property-read \App\Models\AuthorQuestion $question
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer byAuthor(string $authorId)
 * @method static \Database\Factories\AuthorAnswerFactory factory($count = null, $state = [])
<<<<<<< HEAD
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer forQuestion(string $questionId)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer newModelQuery()
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer newQuery()
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer publishedAfter(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer query()
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereAnswerStatus($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereAuthorId($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereContent($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereCreatedAt($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereId($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer wherePublishedAt($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereQuestionId($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer whereUpdatedAt($value)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer withContent(string $content)
 * @method static \App\Models\Builders\AuthorAnswerQueryBuilder<static>|AuthorAnswer withStatus(\App\Enums\AnswerStatus $status)
=======
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereUpdatedAt($value)
>>>>>>> ddf399eaeb167a63c56b43963d810c2306a971c3
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthorAnswer {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $author_id
 * @property string|null $book_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
<<<<<<< HEAD
 * @property string $question_status
=======
>>>>>>> ddf399eaeb167a63c56b43963d810c2306a971c3
 * @property \App\Enums\QuestionStatus $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuthorAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Author $author
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion byUser(string $userId)
 * @method static \Database\Factories\AuthorQuestionFactory factory($count = null, $state = [])
<<<<<<< HEAD
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion forAuthor(string $authorId)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion forBook(string $bookId)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion newModelQuery()
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion newQuery()
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion query()
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereAuthorId($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereBookId($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereContent($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereCreatedAt($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereId($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereQuestionStatus($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereUpdatedAt($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion whereUserId($value)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion withAnswers()
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion withContent(string $content)
 * @method static \App\Models\Builders\AuthorQuestionQueryBuilder<static>|AuthorQuestion withStatus(\App\Enums\QuestionStatus $status)
=======
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereUserId($value)
>>>>>>> ddf399eaeb167a63c56b43963d810c2306a971c3
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthorQuestion {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property string|null $organizer
 * @property string|null $country
 * @property \Illuminate\Support\Carbon|null $ceremony_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Nomination> $nominations
 * @property-read int|null $nominations_count
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award byOrganizer(string $organizer)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award ceremonyAfter(\Illuminate\Support\Carbon $date)
 * @method static \Database\Factories\AwardFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award fromCountry(string $country)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award fromYear(int $year)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award newModelQuery()
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award newQuery()
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award query()
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereCeremonyDate($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereCountry($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereCreatedAt($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereDescription($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereId($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereName($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereOrganizer($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereUpdatedAt($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award whereYear($value)
 * @method static \App\Models\Builders\AwardQueryBuilder<static>|Award withNominations()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAward {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property string|null $plot
 * @property string|null $history
 * @property string|null $series_id
 * @property int|null $number_in_series
 * @property int|null $page_count
 * @property \Illuminate\Support\Collection|null $languages
 * @property string|null $cover_image
 * @property \Illuminate\Support\Collection|null $fun_facts
 * @property \Illuminate\Support\Collection|null $adaptations
 * @property bool|null $is_bestseller
 * @property numeric $average_rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\AgeRestriction $age_restriction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Collection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NominationEntry> $nominationEntries
 * @property-read int|null $nomination_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \App\Models\BookPublisher|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Publisher> $publishers
 * @property-read int|null $publishers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuthorQuestion> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rating> $ratings
 * @property-read int|null $ratings_count
 * @property-read \App\Models\BookSeries|null $series
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBook> $userBooks
 * @property-read int|null $user_books_count
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book bestseller()
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book inSeries(string $seriesId)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book newModelQuery()
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book newQuery()
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book publishedBetween(?\Illuminate\Support\Carbon $from, ?\Illuminate\Support\Carbon $to)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book query()
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereAdaptations($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereAgeRestriction($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereAverageRating($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereCoverImage($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereCreatedAt($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereDescription($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereFunFacts($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereHistory($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereId($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereIsBestseller($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereLanguages($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereNumberInSeries($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book wherePageCount($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book wherePlot($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereSeriesId($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereTitle($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book whereUpdatedAt($value)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book withAgeRestriction(?string $restriction)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book withAuthor(string $authorId)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book withGenre(string $genreId)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book withLanguages(array $languages)
 * @method static \App\Models\Builders\BookQueryBuilder<static>|Book withMinRating(float $rating)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBook {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $book_id
 * @property string $store_id
 * @property numeric $price
 * @property string $referral_url
 * @property string|null $availability
 * @property \Illuminate\Support\Carbon $last_updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\Currency $currency
 * @property \App\Enums\OfferStatus $status
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\Store $store
 * @method static \Database\Factories\BookOfferFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer forBook(string $bookId)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer fromStore(string $storeId)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer maxPrice(float $price)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer newModelQuery()
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer newQuery()
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer query()
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer updatedAfter(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereAvailability($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereBookId($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereCreatedAt($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereCurrency($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereId($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereLastUpdatedAt($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer wherePrice($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereReferralUrl($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereStatus($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereStoreId($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer whereUpdatedAt($value)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer withCurrency(\App\Enums\Currency $currency)
 * @method static \App\Models\Builders\BookOfferQueryBuilder<static>|BookOffer withStatus(\App\Enums\OfferStatus $status)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBookOffer {}
}

namespace App\Models{
/**
 * @property string $book_id
 * @property string $publisher_id
 * @property \Illuminate\Support\Carbon|null $published_date
 * @property string|null $isbn
 * @property int|null $circulation
 * @property string|null $format
 * @property string|null $translator
 * @property int|null $edition
 * @property numeric $price
 * @property string|null $binding
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $cover_type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereBinding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereCirculation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereCoverType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereEdition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher wherePublishedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereTranslator($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookPublisher whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBookPublisher {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $title
 * @property string|null $description
 * @property int $total_books
 * @property bool $is_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries completed()
 * @method static \Database\Factories\BookSeriesFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries hasBook(string $bookId)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries minBooks(int $count)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries newModelQuery()
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries newQuery()
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries query()
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereCreatedAt($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereDescription($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereId($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereIsCompleted($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereTitle($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereTotalBooks($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries whereUpdatedAt($value)
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries withBooks()
 * @method static \App\Models\Builders\BookSeriesQueryBuilder<static>|BookSeries withTitle(string $title)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBookSeries {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $book_id
 * @property string $name
 * @property \Illuminate\Support\Collection|null $other_names
 * @property string|null $race
 * @property string|null $nationality
 * @property string|null $residence
 * @property string|null $biography
 * @property \Illuminate\Support\Collection|null $fun_facts
 * @property \Illuminate\Support\Collection|null $links
 * @property \Illuminate\Support\Collection|null $media_images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @method static \Database\Factories\CharacterFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character fromBook(string $bookId)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character newModelQuery()
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character newQuery()
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character query()
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereBiography($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereBookId($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereCreatedAt($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereFunFacts($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereId($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereLinks($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereMediaImages($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereName($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereNationality($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereOtherNames($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereRace($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereResidence($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character whereUpdatedAt($value)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character withFunFacts()
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character withName(string $name)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character withNationality(string $nationality)
 * @method static \App\Models\Builders\CharacterQueryBuilder<static>|Character withRace(string $race)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCharacter {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $cover_image
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection byUser(string $userId)
 * @method static \Database\Factories\CollectionFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection isPublic()
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection newModelQuery()
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection newQuery()
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection query()
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereCoverImage($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereCreatedAt($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereDescription($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereId($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereIsPublic($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereTitle($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereUpdatedAt($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection whereUserId($value)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection withBook(string $bookId)
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection withCoverImage()
 * @method static \App\Models\Builders\CollectionQueryBuilder<static>|Collection withTitle(string $title)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCollection {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $commentable_type
 * @property string $commentable_id
 * @property string $content
 * @property string|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupModerationLog> $moderationLogs
 * @property-read int|null $moderation_logs_count
 * @property-read Comment|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment byUser(string $userId)
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment forCommentable(string $type, string $id)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment newModelQuery()
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment newQuery()
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment query()
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment topLevel()
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereCommentableId($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereCommentableType($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereContent($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereCreatedAt($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereId($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereParentId($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereUpdatedAt($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment whereUserId($value)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment withContent(string $content)
 * @method static \App\Models\Builders\CommentQueryBuilder<static>|Comment withReplies()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperComment {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_event_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\EventResponse $response
 * @property-read \App\Models\GroupEvent|null $event
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp byUser(string $userId)
 * @method static \Database\Factories\EventRsvpFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp forEvent(string $eventId)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp newModelQuery()
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp newQuery()
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp query()
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp whereCreatedAt($value)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp whereGroupEventId($value)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp whereId($value)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp whereResponse($value)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp whereUpdatedAt($value)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp whereUserId($value)
 * @method static \App\Models\Builders\EventRsvpQueryBuilder<static>|EventRsvp withResponse(\App\Enums\EventResponse $response)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEventRsvp {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $favoriteable_type
 * @property string $favoriteable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favoriteable
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite byUser(string $userId)
 * @method static \Database\Factories\FavoriteFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite forFavoriteable(string $type, string $id)
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite newModelQuery()
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite newQuery()
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite query()
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite whereCreatedAt($value)
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite whereFavoriteableId($value)
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite whereFavoriteableType($value)
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite whereId($value)
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite whereUpdatedAt($value)
 * @method static \App\Models\Builders\FavoriteQueryBuilder<static>|Favorite whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFavorite {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $parent_id
 * @property string|null $description
 * @property int $book_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Genre> $children
 * @property-read int|null $children_count
 * @property-read Genre|null $parent
 * @method static \Database\Factories\GenreFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre minBooks(int $count)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre newModelQuery()
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre newQuery()
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre query()
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre subGenres(string $parentId)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre topLevel()
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereBookCount($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereCreatedAt($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereDescription($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereId($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereName($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereParentId($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre whereUpdatedAt($value)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre withBook(string $bookId)
 * @method static \App\Models\Builders\GenreQueryBuilder<static>|Genre withName(string $name)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGenre {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $creator_id
 * @property bool $is_public
 * @property string|null $cover_image
 * @property string|null $rules
 * @property int $member_count
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\JoinPolicy $join_policy
 * @property \App\Enums\PostPolicy $post_policy
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupEvent> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupModerationLog> $moderationLogs
 * @property-read int|null $moderation_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupPoll> $polls
 * @property-read int|null $polls_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupPost> $posts
 * @property-read int|null $posts_count
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group byCreator(string $creatorId)
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group isActive()
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group isPublic()
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group minMembers(int $count)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group newModelQuery()
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group newQuery()
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group query()
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereCoverImage($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereCreatedAt($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereCreatorId($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereDescription($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereId($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereIsActive($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereIsPublic($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereJoinPolicy($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereMemberCount($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereName($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group wherePostPolicy($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereRules($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group whereUpdatedAt($value)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group withJoinPolicy(\App\Enums\JoinPolicy $policy)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group withMember(string $userId)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group withName(string $name)
 * @method static \App\Models\Builders\GroupQueryBuilder<static>|Group withPostPolicy(\App\Enums\PostPolicy $policy)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroup {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_id
 * @property string $creator_id
 * @property string $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $event_date
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\EventStatus $status
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRsvp> $rsvps
 * @property-read int|null $rsvps_count
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent afterDate(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent atLocation(string $location)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent byCreator(string $creatorId)
 * @method static \Database\Factories\GroupEventFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent forGroup(string $groupId)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent newModelQuery()
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent newQuery()
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent query()
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereCreatedAt($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereCreatorId($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereDescription($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereEventDate($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereGroupId($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereId($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereLocation($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereStatus($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereTitle($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent whereUpdatedAt($value)
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent withRsvps()
 * @method static \App\Models\Builders\GroupEventQueryBuilder<static>|GroupEvent withStatus(\App\Enums\EventStatus $status)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupEvent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_id
 * @property string $inviter_id
 * @property string $invitee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\InvitationStatus $status
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\User $invitee
 * @property-read \App\Models\User $inviter
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation byInviter(string $inviterId)
 * @method static \Database\Factories\GroupInvitationFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation forGroup(string $groupId)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation forInvitee(string $inviteeId)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation newModelQuery()
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation newQuery()
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation query()
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereCreatedAt($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereGroupId($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereId($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereInviteeId($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereInviterId($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereStatus($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation whereUpdatedAt($value)
 * @method static \App\Models\Builders\GroupInvitationQueryBuilder<static>|GroupInvitation withStatus(\App\Enums\InvitationStatus $status)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupInvitation {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_id
 * @property string $moderator_id
 * @property string $action
 * @property string $targetable_type
 * @property string $targetable_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\User $moderator
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $targetable
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog byModerator(string $moderatorId)
 * @method static \Database\Factories\GroupModerationLogFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog forGroup(string $groupId)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog forTargetable(string $type, string $id)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog newModelQuery()
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog newQuery()
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog query()
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereAction($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereCreatedAt($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereDescription($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereGroupId($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereId($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereModeratorId($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereTargetableId($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereTargetableType($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog whereUpdatedAt($value)
 * @method static \App\Models\Builders\GroupModerationLogQueryBuilder<static>|GroupModerationLog withAction(string $action)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupModerationLog {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_id
 * @property string $creator_id
 * @property string $question
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PollOption> $options
 * @property-read int|null $options_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PollVote> $votes
 * @property-read int|null $votes_count
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll byCreator(string $creatorId)
 * @method static \Database\Factories\GroupPollFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll forGroup(string $groupId)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll isActive()
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll newModelQuery()
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll newQuery()
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll query()
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereCreatedAt($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereCreatorId($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereGroupId($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereId($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereIsActive($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereQuestion($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll whereUpdatedAt($value)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll withQuestion(string $question)
 * @method static \App\Models\Builders\GroupPollQueryBuilder<static>|GroupPoll withVotes()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupPoll {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_id
 * @property string $user_id
 * @property string $content
 * @property bool $is_pinned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\PostCategory $category
 * @property \App\Enums\PostStatus $post_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupModerationLog> $moderationLogs
 * @property-read int|null $moderation_logs_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost byUser(string $userId)
 * @method static \Database\Factories\GroupPostFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost forGroup(string $groupId)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost isPinned()
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost newModelQuery()
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost newQuery()
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost query()
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereCategory($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereContent($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereCreatedAt($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereGroupId($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereId($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereIsPinned($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost wherePostStatus($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereUpdatedAt($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost whereUserId($value)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost withCategory(\App\Enums\PostCategory $category)
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost withComments()
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost withLikes()
 * @method static \App\Models\Builders\GroupPostQueryBuilder<static>|GroupPost withStatus(\App\Enums\PostStatus $status)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupPost {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $likeable_type
 * @property string $likeable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $likeable
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like byUser(string $userId)
 * @method static \Database\Factories\LikeFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like forLikeable(string $type, string $id)
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like newModelQuery()
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like newQuery()
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like query()
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like whereCreatedAt($value)
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like whereId($value)
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like whereLikeableId($value)
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like whereLikeableType($value)
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like whereUpdatedAt($value)
 * @method static \App\Models\Builders\LikeQueryBuilder<static>|Like whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLike {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $award_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Award $award
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NominationEntry> $entries
 * @property-read int|null $entries_count
 * @method static \Database\Factories\NominationFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination forAward(string $awardId)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination newModelQuery()
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination newQuery()
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination query()
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination whereAwardId($value)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination whereCreatedAt($value)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination whereDescription($value)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination whereId($value)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination whereName($value)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination whereUpdatedAt($value)
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination withEntries()
 * @method static \App\Models\Builders\NominationQueryBuilder<static>|Nomination withName(string $name)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNomination {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $nomination_id
 * @property string|null $book_id
 * @property string|null $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\NominationStatus $status
 * @property-read \App\Models\Author|null $author
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\Nomination $nomination
 * @method static \Database\Factories\NominationEntryFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry forAuthor(string $authorId)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry forBook(string $bookId)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry forNomination(string $nominationId)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry newModelQuery()
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry newQuery()
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry query()
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereAuthorId($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereBookId($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereCreatedAt($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereId($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereNominationId($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereStatus($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry whereUpdatedAt($value)
 * @method static \App\Models\Builders\NominationEntryQueryBuilder<static>|NominationEntry withStatus(\App\Enums\NominationStatus $status)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNominationEntry {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $book_id
 * @property string $text
 * @property int|null $page_number
 * @property bool $contains_spoilers
 * @property bool $is_private
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note byUser(string $userId)
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note forBook(string $bookId)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note isPublic()
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note newModelQuery()
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note newQuery()
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note query()
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereBookId($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereContainsSpoilers($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereCreatedAt($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereId($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereIsPrivate($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note wherePageNumber($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereText($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereUpdatedAt($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note whereUserId($value)
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note withSpoilers()
 * @method static \App\Models\Builders\NoteQueryBuilder<static>|Note withText(string $text)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNote {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_poll_id
 * @property string $text
 * @property int $vote_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GroupPoll $poll
 * @method static \Database\Factories\PollOptionFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption forPoll(string $pollId)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption minVotes(int $count)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption newModelQuery()
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption newQuery()
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption query()
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption whereCreatedAt($value)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption whereGroupPollId($value)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption whereId($value)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption whereText($value)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption whereUpdatedAt($value)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption whereVoteCount($value)
 * @method static \App\Models\Builders\PollOptionQueryBuilder<static>|PollOption withText(string $text)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPollOption {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $group_poll_id
 * @property string $poll_option_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PollOption $option
 * @property-read \App\Models\GroupPoll $poll
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote byUser(string $userId)
 * @method static \Database\Factories\PollVoteFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote forOption(string $optionId)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote forPoll(string $pollId)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote newModelQuery()
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote newQuery()
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote query()
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote whereCreatedAt($value)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote whereGroupPollId($value)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote whereId($value)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote wherePollOptionId($value)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote whereUpdatedAt($value)
 * @method static \App\Models\Builders\PollVoteQueryBuilder<static>|PollVote whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPollVote {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $book_id
 * @property string|null $author_id
 * @property string $title
 * @property string|null $slug
 * @property string $content
 * @property string|null $cover_image
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\PostType $type
 * @property \App\Enums\PostStatus $status
 * @property-read \App\Models\Author|null $author
 * @property-read \App\Models\Book|null $book
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post byUser(string $userId)
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post forAuthor(string $authorId)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post forBook(string $bookId)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post newModelQuery()
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post newQuery()
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post publishedAfter(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post query()
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereAuthorId($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereBookId($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereContent($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereCoverImage($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereCreatedAt($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereId($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post wherePublishedAt($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereSlug($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereStatus($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereTitle($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereType($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereUpdatedAt($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post whereUserId($value)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post withComments()
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post withStatus(\App\Enums\PostStatus $status)
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post withTags()
 * @method static \App\Models\Builders\PostQueryBuilder<static>|Post withType(\App\Enums\PostType $type)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPost {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $website
 * @property string|null $country
 * @property int|null $founded_year
 * @property string|null $logo
 * @property string|null $contact_email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BookPublisher|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \Database\Factories\PublisherFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher foundedAfter(int $year)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher fromCountry(string $country)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher newModelQuery()
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher newQuery()
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher query()
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereContactEmail($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereCountry($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereCreatedAt($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereDescription($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereFoundedYear($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereId($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereLogo($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereName($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher wherePhone($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereUpdatedAt($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher whereWebsite($value)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher withBook(string $bookId)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher withName(string $name)
 * @method static \App\Models\Builders\PublisherQueryBuilder<static>|Publisher withWebsite()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPublisher {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $book_id
 * @property string $text
 * @property int|null $page_number
 * @property bool $contains_spoilers
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote byUser(string $userId)
 * @method static \Database\Factories\QuoteFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote forBook(string $bookId)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote isPublic()
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote newModelQuery()
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote newQuery()
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote query()
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereBookId($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereContainsSpoilers($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereCreatedAt($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereId($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereIsPublic($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote wherePageNumber($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereText($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereUpdatedAt($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote whereUserId($value)
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote withComments()
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote withSpoilers()
 * @method static \App\Models\Builders\QuoteQueryBuilder<static>|Quote withText(string $text)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperQuote {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $book_id
 * @property int $rating
 * @property string|null $review
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating byUser(string $userId)
 * @method static \Database\Factories\RatingFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating forBook(string $bookId)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating minRating(int $rating)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating newModelQuery()
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating newQuery()
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating query()
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereBookId($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereCreatedAt($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereId($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereRating($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereReview($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereUpdatedAt($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating whereUserId($value)
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating withComments()
 * @method static \App\Models\Builders\RatingQueryBuilder<static>|Rating withReview()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRating {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property int $year
 * @property int $books_read
 * @property int $pages_read
 * @property array<array-key, mixed>|null $genres_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ReadingStatFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat forUser(string $userId)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat forYear(int $year)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat minBooksRead(int $count)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat minPagesRead(int $count)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat newModelQuery()
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat newQuery()
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat query()
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereBooksRead($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereCreatedAt($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereGenresRead($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereId($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat wherePagesRead($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereUpdatedAt($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereUserId($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat whereYear($value)
 * @method static \App\Models\Builders\ReadingStatQueryBuilder<static>|ReadingStat withGenres(array $genres)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReadingStat {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $reportable_type
 * @property string $reportable_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\ReportType $type
 * @property \App\Enums\ReportStatus $status
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reportable
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report byUser(string $userId)
 * @method static \Database\Factories\ReportFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report forReportable(string $type, string $id)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report newModelQuery()
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report newQuery()
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report query()
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereCreatedAt($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereDescription($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereId($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereReportableId($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereReportableType($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereStatus($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereType($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereUpdatedAt($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report whereUserId($value)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report withStatus(\App\Enums\ReportStatus $status)
 * @method static \App\Models\Builders\ReportQueryBuilder<static>|Report withType(\App\Enums\ReportType $type)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReport {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBook> $userBooks
 * @property-read int|null $user_books_count
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf byUser(string $userId)
 * @method static \Database\Factories\ShelfFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf newModelQuery()
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf newQuery()
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf query()
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf whereCreatedAt($value)
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf whereId($value)
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf whereName($value)
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf whereUpdatedAt($value)
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf whereUserId($value)
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf withBooks()
 * @method static \App\Models\Builders\ShelfQueryBuilder<static>|Shelf withName(string $name)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperShelf {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $logo_url
 * @property string|null $region
 * @property string|null $website_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookOffer> $bookOffers
 * @property-read int|null $book_offers_count
 * @method static \Database\Factories\StoreFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store fromRegion(string $region)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store newModelQuery()
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store newQuery()
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store query()
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereCreatedAt($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereId($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereLogoUrl($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereName($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereRegion($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereUpdatedAt($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store whereWebsiteUrl($value)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store withBookOffers()
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store withName(string $name)
 * @method static \App\Models\Builders\StoreQueryBuilder<static>|Store withWebsite()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperStore {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag newModelQuery()
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag newQuery()
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag query()
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag whereCreatedAt($value)
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag whereId($value)
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag whereName($value)
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag whereUpdatedAt($value)
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag withName(string $name)
 * @method static \App\Models\Builders\TagQueryBuilder<static>|Tag withPosts()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTag {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $username
 * @property string|null $profile_picture
 * @property string|null $bio
 * @property bool $is_public
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $last_login
 * @property \Illuminate\Support\Collection|null $social_media_links
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\Role $role
 * @property \App\Enums\Gender $gender
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBook> $books
 * @property-read int|null $books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRsvp> $eventRsvps
 * @property-read int|null $event_rsvps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $following
 * @property-read int|null $following_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupInvitation> $groupInvitations
 * @property-read int|null $group_invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rating> $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shelf> $shelves
 * @property-read int|null $shelves_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ViewHistory> $viewHistories
 * @property-read int|null $view_histories_count
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User emailVerified()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User followingAuthor(string $authorId)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User inGroup(string $groupId)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User isPublic()
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User lastLoginAfter(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User newModelQuery()
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User newQuery()
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User query()
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereBio($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereBirthday($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereCreatedAt($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereEmail($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereEmailVerifiedAt($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereGender($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereId($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereIsPublic($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereLastLogin($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereLocation($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User wherePassword($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereProfilePicture($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereRole($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereSocialMediaLinks($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereUpdatedAt($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User whereUsername($value)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User withGender(\App\Enums\Gender $gender)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User withRole(\App\Enums\Role $role)
 * @method static \App\Models\Builders\UserQueryBuilder<static>|User withUsername(string $username)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $book_id
 * @property string $shelf_id
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $read_date
 * @property int|null $progress_pages
 * @property bool $is_private
 * @property int|null $rating
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Enums\ReadingFormat $reading_format
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\Shelf $shelf
 * @property-read \App\Models\User $user
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook byUser(string $userId)
 * @method static \Database\Factories\UserBookFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook forBook(string $bookId)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook isPublic()
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook newModelQuery()
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook newQuery()
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook onShelf(string $shelfId)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook query()
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook readAfter(\Illuminate\Support\Carbon $date)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereBookId($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereCreatedAt($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereId($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereIsPrivate($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereNotes($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereProgressPages($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereRating($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereReadDate($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereReadingFormat($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereShelfId($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereStartDate($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereUpdatedAt($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook whereUserId($value)
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook withRating()
 * @method static \App\Models\Builders\UserBookQueryBuilder<static>|UserBook withReadingFormat(\App\Enums\ReadingFormat $format)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserBook {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property string $viewable_type
 * @property string $viewable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $viewable
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory byUser(string $userId)
 * @method static \Database\Factories\ViewHistoryFactory factory($count = null, $state = [])
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory forViewable(string $type, string $id)
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory newModelQuery()
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory newQuery()
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory query()
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory whereCreatedAt($value)
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory whereId($value)
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory whereUpdatedAt($value)
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory whereUserId($value)
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory whereViewableId($value)
 * @method static \App\Models\Builders\ViewHistoryQueryBuilder<static>|ViewHistory whereViewableType($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperViewHistory {}
}

