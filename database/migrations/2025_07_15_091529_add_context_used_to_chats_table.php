<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // /**
    //  * Run the migrations.
    //  */
    // public function up(): void
    // {
    //     Schema::table('chats', function (Blueprint $table) {
    //         //
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('chats', function (Blueprint $table) {
    //         //
    //     });
    // }

    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->text('context_used')->nullable()->after('answer');
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('context_used');
        });
    }
};
