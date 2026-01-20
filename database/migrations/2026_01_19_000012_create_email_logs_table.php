<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->string('to_email')->index();
            $table->foreignId('to_user_id')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->string('subject')->nullable();
            $table->string('status', 20)->index();
            $table->text('error_message')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('sent_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
