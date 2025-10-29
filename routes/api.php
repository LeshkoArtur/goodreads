<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes (custom Fortify routes)
require __DIR__.'/fortify.php';

// Get authenticated user
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
        'user' => new \App\Http\Resources\UserResource($request->user()),
    ]);
});

// Core Resources
require __DIR__.'/api/author.php';
require __DIR__.'/api/book.php';
require __DIR__.'/api/user.php';
require __DIR__.'/api/genre.php';
require __DIR__.'/api/publisher.php';
require __DIR__.'/api/book-series.php';

// User Interactions with Books
require __DIR__.'/api/rating.php';
require __DIR__.'/api/quote.php';
require __DIR__.'/api/note.php';
require __DIR__.'/api/user-book.php';
require __DIR__.'/api/shelf.php';
require __DIR__.'/api/collection.php';

// Social Features
require __DIR__.'/api/group.php';
require __DIR__.'/api/post.php';
require __DIR__.'/api/comment.php';
require __DIR__.'/api/like.php';
require __DIR__.'/api/favorite.php';

// Group Activities
require __DIR__.'/api/group-post.php';
require __DIR__.'/api/group-event.php';
require __DIR__.'/api/event-rsvp.php';
require __DIR__.'/api/group-poll.php';
require __DIR__.'/api/poll-option.php';
require __DIR__.'/api/poll-vote.php';
require __DIR__.'/api/group-invitation.php';
require __DIR__.'/api/group-moderation-log.php';

// Awards & Characters
require __DIR__.'/api/award.php';
require __DIR__.'/api/nomination.php';
require __DIR__.'/api/nomination-entry.php';
require __DIR__.'/api/character.php';

// Commerce
require __DIR__.'/api/store.php';
require __DIR__.'/api/book-offer.php';

// Author Q&A
require __DIR__.'/api/author-question.php';
require __DIR__.'/api/author-answer.php';

// Other
require __DIR__.'/api/reading-stat.php';
require __DIR__.'/api/report.php';
require __DIR__.'/api/tag.php';
require __DIR__.'/api/view-history.php';

// Global Features
// require __DIR__.'/api/search.php';
// require __DIR__.'/api/trending.php';
// require __DIR__.'/api/recommendations.php';
// require __DIR__.'/api/feed.php';

// User Dashboard & Analytics
// require __DIR__.'/api/dashboard.php';
// require __DIR__.'/api/statistics.php';
// require __DIR__.'/api/challenge.php';
// require __DIR__.'/api/list.php';

// User Preferences & Notifications
// require __DIR__.'/api/settings.php';
// require __DIR__.'/api/notification.php'; // треба зробити в майбутньому

// Administration
// require __DIR__.'/api/admin.php';
