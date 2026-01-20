<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->unsignedSmallInteger('text_score')->nullable()->after('text_pending_count');
            $table->unsignedSmallInteger('text_total_points')->nullable()->after('text_score');
            $table->unsignedSmallInteger('final_score')->nullable()->after('text_total_points');
            $table->unsignedSmallInteger('final_total_points')->nullable()->after('final_score');
            $table->timestamp('graded_at')->nullable()->after('final_total_points');
            $table->foreignId('graded_by')->nullable()->after('graded_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('exam_attempts', function (Blueprint $table) {
            $table->dropForeign(['graded_by']);
            $table->dropColumn([
                'text_score',
                'text_total_points',
                'final_score',
                'final_total_points',
                'graded_at',
                'graded_by',
            ]);
        });
    }
};
