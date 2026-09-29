<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signing_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            $table->foreignId('signer_id')
                ->constrained('signers')
                ->cascadeOnDelete();

            $table->string('status')->default('waiting');

            $table->timestamp('opened_at')->nullable();
            $table->timestamp('signed_at')->nullable();

            $table->string('device_id')->nullable();
            $table->string('ip_address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signing_sessions');
    }
};
