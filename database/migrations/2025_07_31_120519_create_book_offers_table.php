<?php

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('store_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->string('referral_url', 255);
            $table->string('availability', 100)->nullable();
            $table->timestamp('last_updated_at')->useCurrent();
            $table->timestamps();

            $table->unique(['book_id', 'store_id']);
        });

        Schema::table('book_offers', function (Blueprint $table) {
            $table->enumAlterColumn('currency', 'currency', Currency::class, default: Currency::USD->value);
            $table->enumAlterColumn('status', 'offer_status', OfferStatus::class, default: OfferStatus::PENDING->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_offers');
        DB::unprepared('DROP TYPE currency');
        DB::unprepared('DROP TYPE offer_status');
    }
};
