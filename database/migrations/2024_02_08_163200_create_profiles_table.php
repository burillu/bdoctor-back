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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete(); 
            $table->string('curriculum')->nullable();
            $table->string('image')->nullable();
            $table->string('tel', 13)->unique()->nullable();
            $table->tinyInteger('visibility')->default(0);
            // $table->string('surname')->nullable();
            $table->string('address')->nullable();
            $table->text('services')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
