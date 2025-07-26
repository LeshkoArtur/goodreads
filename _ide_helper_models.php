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
 * @property int $id
 * @property string $name
 * @property string|null $bio
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $birth_place
 * @property string|null $nationality
 * @property string|null $website
 * @property string|null $profile_picture
 * @property \Illuminate\Support\Carbon|null $death_date
 * @property array<array-key, mixed>|null $social_media_links
 * @property array<array-key, mixed>|null $media_images
 * @property array<array-key, mixed>|null $media_videos
 * @property array<array-key, mixed>|null $fun_facts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type_of_work
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
 * @method static \Database\Factories\AuthorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereDeathDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereFunFacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereMediaImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereMediaVideos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereSocialMediaLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereTypeOfWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereWebsite($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthor {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $question_id
 * @property string $author_id
 * @property string $content
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $answer_status
 * @property-read \App\Models\Author $author
 * @property-read \App\Models\AuthorQuestion $question
 * @method static \Database\Factories\AuthorAnswerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereAnswerStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorAnswer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthorAnswer {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $author_id
 * @property string|null $book_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $question_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AuthorAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Author $author
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\AuthorQuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereQuestionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuthorQuestion whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthorQuestion {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property string|null $organizer
 * @property string|null $country
 * @property string|null $ceremony_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Nomination> $nominations
 * @property-read int|null $nominations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereCeremonyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereOrganizer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereYear($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAward {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $plot
 * @property string|null $history
 * @property string $series_id
 * @property int|null $number_in_series
 * @property int|null $page_count
 * @property string|null $languages
 * @property string|null $cover_image
 * @property string|null $fun_facts
 * @property string|null $adaptations
 * @property bool|null $is_bestseller
 * @property string $average_rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $age_restriction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Collection> $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NominationEntry> $nominationEntries
 * @property-read int|null $nomination_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Publisher> $publishers
 * @property-read int|null $publishers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rating> $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBook> $userBooks
 * @property-read int|null $user_books_count
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAdaptations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAgeRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereFunFacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereIsBestseller($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereNumberInSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book wherePageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book wherePlot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereSeriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBook {}
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
 * @method static \Database\Factories\BookSeriesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereTotalBooks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookSeries whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBookSeries {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $book_id
 * @property string $name
 * @property string|null $other_names
 * @property string|null $race
 * @property string|null $nationality
 * @property string|null $residence
 * @property string|null $biography
 * @property string|null $fun_facts
 * @property string|null $links
 * @property string|null $media_images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @method static \Database\Factories\CharacterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereBiography($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereFunFacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereMediaImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereOtherNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereRace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereResidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Character whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCharacter {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @method static \Database\Factories\CollectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCollection {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $commentable_type
 * @property string $commentable_id
 * @property string $content
 * @property string|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read Comment|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Comment> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperComment {}
}

namespace App\Models{
/**
 * @property-read \App\Models\GroupEvent|null $event
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\EventRsvpFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventRsvp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventRsvp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventRsvp query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEventRsvp {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $favoriteable_id
 * @property string $favoriteable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favoriteable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\FavoriteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereFavoriteableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereFavoriteableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFavorite {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $parent_id
 * @property string|null $description
 * @property int $book_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \Database\Factories\GenreFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereBookCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGenre {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @property string $join_policy
 * @property string $post_policy
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
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereJoinPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMemberCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePostPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroup {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $group_id
 * @property string $creator_id
 * @property string $title
 * @property string|null $description
 * @property string|null $event_date
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $group_status
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventRsvp> $rsvps
 * @property-read int|null $rsvps_count
 * @method static \Database\Factories\GroupEventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereGroupStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupEvent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $group_id
 * @property string $inviter_id
 * @property string $invitee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\User $invitee
 * @property-read \App\Models\User $inviter
 * @method static \Database\Factories\GroupInvitationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereInviteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereInviterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupInvitation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupInvitation {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @method static \Database\Factories\GroupModerationLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereModeratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereTargetableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereTargetableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupModerationLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupModerationLog {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @method static \Database\Factories\GroupPollFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPoll whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupPoll {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $group_id
 * @property string $user_id
 * @property string $content
 * @property bool $is_pinned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $category
 * @property string $post_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\GroupPostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPost whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupPost {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $likeable_type
 * @property string $likeable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $likeable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\LikeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereLikeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereLikeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLike {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $award_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Award $award
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NominationEntry> $entries
 * @property-read int|null $entries_count
 * @method static \Database\Factories\NominationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination whereAwardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nomination whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNomination {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nomination_id
 * @property string|null $book_id
 * @property string|null $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nomination_status
 * @property-read \App\Models\Author|null $author
 * @property-read \App\Models\Book|null $book
 * @property-read \App\Models\Nomination $nomination
 * @method static \Database\Factories\NominationEntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereNominationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereNominationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NominationEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNominationEntry {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereContainsSpoilers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note wherePageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNote {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $data
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNotification {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $group_poll_id
 * @property string $text
 * @property int $vote_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GroupPoll|null $poll
 * @method static \Database\Factories\PollOptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption whereGroupPollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollOption whereVoteCount($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPollOption {}
}

namespace App\Models{
/**
 * @property string $group_poll_id
 * @property string $poll_option_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\PollOption|null $option
 * @property-read \App\Models\GroupPoll|null $poll
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PollVoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote whereGroupPollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote wherePollOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PollVote whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPollVote {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string|null $book_id
 * @property string|null $author_id
 * @property string $title
 * @property string|null $slug
 * @property string $content
 * @property string|null $cover_image
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $post_type
 * @property string $post_status
 * @property-read \App\Models\Author|null $author
 * @property-read \App\Models\Book|null $book
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPost {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \Database\Factories\PublisherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereFoundedYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereWebsite($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPublisher {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @method static \Database\Factories\QuoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereContainsSpoilers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote wherePageNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quote whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperQuote {}
}

namespace App\Models{
/**
 * @property int $id
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
 * @method static \Database\Factories\RatingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRating {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property int $year
 * @property int $books_read
 * @property int $pages_read
 * @property string|null $genres_read
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ReadingStatFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat whereBooksRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat whereGenresRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat wherePagesRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReadingStat whereYear($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReadingStat {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $reportable_type
 * @property string $reportable_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $report_type
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reportable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ReportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReport {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBook> $userBooks
 * @property-read int|null $user_books_count
 * @method static \Database\Factories\ShelfFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shelf whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperShelf {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Taggable> $taggables
 * @property-read int|null $taggables_count
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTag {}
}

namespace App\Models{
/**
 * @property string $tag_id
 * @property string $taggable_type
 * @property string $taggable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tag $tag
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $taggable
 * @method static \Database\Factories\TaggableFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable whereTaggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Taggable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTaggable {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $profile_picture
 * @property string|null $bio
 * @property bool $is_public
 * @property string|null $birthday
 * @property string|null $address
 * @property string|null $last_login
 * @property string|null $social_media_links
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property string $gender
 * @property string $invitation_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $follows
 * @property-read int|null $follows_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupInvitation> $groupInvitations
 * @property-read int|null $group_invitations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quote> $quotes
 * @property-read int|null $quotes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rating> $ratings
 * @property-read int|null $ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shelf> $shelves
 * @property-read int|null $shelves_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBook> $userBooks
 * @property-read int|null $user_books_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ViewHistory> $viewHistories
 * @property-read int|null $view_histories_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereInvitationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSocialMediaLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $book_id
 * @property string $shelf_id
 * @property string|null $start_date
 * @property string|null $read_date
 * @property int|null $progress_pages
 * @property bool $is_private
 * @property int|null $rating
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $reading_format
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\Shelf $shelf
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\UserBookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereProgressPages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereReadDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereReadingFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereShelfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBook whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserBook {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $user_id
 * @property string $viewable_type
 * @property string $viewable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $viewable
 * @method static \Database\Factories\ViewHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory whereViewableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewHistory whereViewableType($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperViewHistory {}
}

