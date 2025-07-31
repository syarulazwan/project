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
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('role_id', 45)->nullable(); 
            $table->string('action', 45)->nullable(); 
            $table->string('ip_address', 45)->nullable(); 
            $table->text('user_agent')->nullable(); 
            $table->timestamp('login_at')->nullable(); 
            $table->timestamp('logout_at')->nullable(); 
            $table->unsignedBigInteger('created_id')->nullable();
            $table->softDeletes();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
