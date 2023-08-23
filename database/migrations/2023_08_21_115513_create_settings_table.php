<?php

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('group');
            $table->string('key');
            $table->text('value');

            $table->timestamps();
        });

        $settings = [
            'sampler_name' => 'Euler a',
            'seed' => -1,
            'width' => 768,
            'height' => 768,
            'send_images' => true,
            'save_images' => false,
            'steps' => 150,
            'restore_faces' => true,
            'cfg_scale' => 6.5,
            'enable_hr' => true,
            'hr_upscaler' => 'Latent',
            'denoising_strength' => 0.35,
            'jpeg_quality' => 100,
        ];

        $now = Carbon::now();
        Setting::insert(collect($settings)->map(function ($value, $key) use ($now) {
            return [
                'group' => 'payload',
                'key' => $key,
                'value' => $value,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->toArray());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
