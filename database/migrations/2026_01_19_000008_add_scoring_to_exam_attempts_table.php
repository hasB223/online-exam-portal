<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->unsignedSmallInteger('auto_score')->nullable()->after('submitted_at');
            $table->unsignedSmallInteger('auto_total_points')->nullable()->after('auto_score');
            $table->unsignedSmallInteger('text_pending_count')->nullable()->after('auto_total_points');
        });
    }

    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropColumn(['auto_score', 'auto_total_points', 'text_pending_count']);
        });
    }
};
