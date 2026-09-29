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
        Schema::create('visitor_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->nullable()
                ->constrained('events')
                ->nullOnDelete();

            $table->foreignId('visitor_id')
                ->nullable()
                ->constrained('visitors')
                ->nullOnDelete();

            $table->string('name');

            $table->string('organization')->nullable();

            $table->text('comment');

            $table->string('status')
                ->default('published');

            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_comments');
    }
};
