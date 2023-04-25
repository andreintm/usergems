<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE = 'events';
    const USERS_TABLE = 'users';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreignId('user_id')->constrained(self::USERS_TABLE);
            $table->string('title');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('changed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
