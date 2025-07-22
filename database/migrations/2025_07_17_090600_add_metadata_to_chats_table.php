<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->string('question_type')->nullable()->after('answer');
            $table->string('language_preference', 2)->default('en')->after('question_type');
            $table->text('enhanced_question')->nullable()->after('question');
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn(['question_type', 'language_preference', 'enhanced_question']);
        });
    }
};