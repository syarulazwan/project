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
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedBigInteger('jobgrade_id')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // $table->foreign('jobgrade_id')->references('id')->on('job_grades');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
