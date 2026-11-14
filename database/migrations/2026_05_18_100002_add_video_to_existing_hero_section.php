<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\HomePageSection;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fetch the existing Hero section and inject the dynamic background video default key
        $hero = HomePageSection::where('section_type', 'hero')->first();
        if ($hero) {
            $content = (array) $hero->content;
            
            // Set the ultra-premium silk fabric loop video from Mixkit
            $content['video'] = 'https://assets.mixkit.co/videos/preview/mixkit-waving-a-golden-silk-fabric-40348-large.mp4';
            
            $hero->update(['content' => $content]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hero = HomePageSection::where('section_type', 'hero')->first();
        if ($hero) {
            $content = (array) $hero->content;
            unset($content['video']);
            $hero->update(['content' => $content]);
        }
    }
};
