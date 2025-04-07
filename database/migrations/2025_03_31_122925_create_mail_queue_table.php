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
        Schema::create('mail_queue', function (Blueprint $table) {
            $table->id();
            $table->json('users_email');
            $table->string('mail_body');
            $table->text('subject');
            $table->json('attachment_ids');
            $table->string('country');
            $table->boolean('is_sent')->default(0);
            $table->timestamp('mail_sent_at')->useCurrent()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_queue');
    }
};
