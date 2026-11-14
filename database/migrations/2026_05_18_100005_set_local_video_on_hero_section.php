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
            
            // Set the layout mode to video
            $content['layout_mode'] = 'video';
            
            // Set to your local high-fidelity download video in the public folder
            $content['video'] = '/hero-sewing.mp4';
            
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
            $content['video'] = '';
            $hero->update(['content' => $content]);
        }
    }
};
