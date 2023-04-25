<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE = 'attendees';
    const COMPANY_TABLE = 'companies';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained(self::COMPANY_TABLE);
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('title')->nullable();
            $table->string('linkedin_url')->nullable();
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
