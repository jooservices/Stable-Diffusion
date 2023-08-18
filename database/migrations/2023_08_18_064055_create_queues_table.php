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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();

            $table->uuid()->unique();

            $table->text('prompt');
            $table->text('negative_prompt')->nullable();
            $table->string('sampler_name')->default('Euler');
            $table->string('hr_upscaler')->default('Latent');

            $table->json('override_settings')->nullable();

            $table->integer('seed')->default(-1);
            $table->integer('steps')->default(150);
            $table->integer('width')->default(768);
            $table->integer('height')->default(768);

            $table->float('cfg_scale')->default(6.5);
            $table->float('denoising_strength')->default(0.35);

            $table->boolean('completed')->default(false);
            $table->json('result')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
