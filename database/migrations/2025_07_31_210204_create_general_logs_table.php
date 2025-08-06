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
        Schema::create('general_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_type')->nullable(); 
            $table->string('table')->nullable();  
            $table->json('after')->nullable();  
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->softDeletes();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_logs');
    }
};
