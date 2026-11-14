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
            
            // Explicitly enable video layout mode
            $content['layout_mode'] = 'video';
            
            // Set the gorgeous, high-fidelity sewing/garment crafting loop video from Singer
            $content['video'] = 'https://www.singer.co.nz/wp-content/uploads/production-ID-4817952.mp4';
            
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
