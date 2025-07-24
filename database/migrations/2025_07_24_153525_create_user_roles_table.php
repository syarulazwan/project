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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idp0')->nullable();
            $table->unsignedBigInteger('idp1')->nullable();
            $table->unsignedBigInteger('idp2')->nullable();
            $table->unsignedBigInteger('idp3')->nullable();
            $table->string('name');
            $table->string('code');
            $table->string('url');
            $table->string('route')->nullable(); 
            $table->string('icon')->nullable();
            $table->integer('priority')->default(0);
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
        Schema::dropIfExists('user_roles');
    }
};
