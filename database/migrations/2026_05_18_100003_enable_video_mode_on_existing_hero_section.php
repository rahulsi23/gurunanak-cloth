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
        $hero = HomePageSection::where('section_type', 'hero')->first();
        if ($hero) {
            $content = (array) $hero->content;
            
            // Toggle the layout mode to video
            $content['layout_mode'] = 'video';
            
            // Set the ultra-stable, premium sewing and fabric craftsmanship video from Mixkit
            $content['video'] = 'https://assets.mixkit.co/videos/preview/mixkit-sewing-machine-stitching-a-fabric-close-up-41684-large.mp4';
            
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
            $content['layout_mode'] = 'image';
            $hero->update(['content' => $content]);
        }
    }
};
