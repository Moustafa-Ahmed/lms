<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Seed Demo Video
    |--------------------------------------------------------------------------
    |
    | When enabled, the lesson seeder attaches the bundled demo video to the
    | first lesson of every course so the free preview lessons are playable
    | out of the box. The video is roughly 49 MB and is copied into storage
    | per lesson, so disable this to keep local seeding fast and light.
    |
    */

    'seed_demo_video' => env('SEED_DEMO_VIDEO', true),

];
