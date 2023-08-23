<?php

use App\Models\Prompt;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();

            $table->string('group');
            $table->string('key')->nullable();
            $table->text('prompt')->nullable();
            $table->text('negative_prompt')->nullable();
            $table->json('extra')->nullable();

            $table->timestamps();
        });

        $artists = json_decode(Storage::read('artists.json'), true);
        $styles = collect(json_decode(Storage::read('artists_style.json'), true))->pluck('style', 'name');

        $now = Carbon::now();
        collect($artists)->map(function ($value, $key) use ($now, $styles) {
            $data = [
                'group' => 'author',
                'prompt' => $value['DisplayName'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (isset($styles[$value['DisplayName']])) {
                $data['extra'] = [
                    'style' => $styles[$value['DisplayName']],
                ];
            }

            return $data;
        })->each(function ($value, $key) {
            Prompt::create($value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
