<?php

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
        Schema::create('profile_sponsorship', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->cascadeOnDelete();

            $table->unsignedBigInteger('sponsorship_id');
            $table->foreign('sponsorship_id')->references('id')->on('sponsorship')->cascadeOnDelete();

            $table->dateTime('expire_date');
            $table->decimal('current_price',4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_sponsorship');
    }
};
