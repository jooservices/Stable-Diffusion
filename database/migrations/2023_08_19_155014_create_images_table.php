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
        Schema::create('images', function (Blueprint $table) {
            $table->id();

            $table->uuid()->unique();

            $table->unsignedBigInteger('queue_id');
            $table->foreign('queue_id')->references('id')->on('queues')->onDelete('cascade');

            $table->string('prompt');
            $table->string('negative_prompt')->nullable();

            $table->string('sampler_name');

            $table->integer('seed');
            $table->integer('width');
            $table->integer('height');
            $table->float('cfg_scale')->default(6.5);
            $table->float('denoising_strength')->default(0.35);

            $table->integer('clip_skip');

            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
