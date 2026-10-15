<?php

/**
 * Homepage content that is rendered from lists rather than fixed markup.
 */
return [

    /* Rathinam TV — YouTube video ids, rendered as click-to-load facades. */
    'tv_videos' => [
        'izya9OIsDGk', 'd_Q-_dRdxaY', 'niMsbCsmV5g', 'SPC74ZVd9OA', 'HxUJA3_hoto',
    ],

    /*
     * Life at RGU marquee rows: [image id, shape, alt text].
     * Images live in storage/app/public/assets/images/life/{id}.webp.
     */
    'gallery_rows' => [
        [
            ['01', 'wide',   'Aerial view of the Rathinam Global University campus and sports ground in Coimbatore'],
            ['02', 'tall',   'Aerial view of Rathinam campus academic blocks and hostel building'],
            ['03', 'square', 'Rathinam Global University academic buildings seen from above'],
            ['04', 'wide',   'Rathinam Research Hub building on campus'],
            ['05', 'square', 'Rathinam Institutions and IT Parks entrance arch with rocket model'],
            ['06', 'tall',   'Campus academic block with outdoor basketball courts'],
            ['07', 'wide',   'Campus football ground at Rathinam Global University'],
            ['08', 'square', 'Wall of Fame displaying university rankings, placement and research achievements'],
            ['09', 'wide',   'Open-air amphitheatre with tiered seating on campus'],
        ],
        [
            ['10', 'wide',   'Rathinam Grand Hall illuminated at sunset with students gathered outside'],
            ['11', 'square', 'Discussion room with a motivational wall mural'],
            ['12', 'tall',   'Computer lab with rows of desktop workstations'],
            ['13', 'wide',   'Rathinam Hybrid Learning Hub classroom with tiered seating'],
            ['14', 'square', 'Innovation lab with partitioned workstations and technology partner logos'],
            ['15', 'tall',   'Bio InnoSpace incubation laboratory with shared work desks'],
            ['16', 'wide',   'Wooden tiered seating area used as an informal student collaboration space'],
            ['17', 'square', 'Open-plan student workspace with rows of desks and colourful ceiling lighting'],
        ],
    ],

    /* Rendered card sizes per shape (must match the gallery CSS) to avoid layout shift. */
    'gallery_dimensions' => [
        'wide' => ['w' => 380, 'h' => 210],
        'square' => ['w' => 260, 'h' => 210],
        'tall' => ['w' => 190, 'h' => 210],
    ],

    /* FAQ preview: [category id, question index] picked from resources/data/faqs.php. */
    'faq_preview' => [
        ['admissions',  1],   // Are admissions currently open for 2026-2027?
        ['programs',    0],   // What are the core academic programs offered?
        ['placements',  0],   // Highest salary package achieved
        ['campus-life', 0],   // Hostel facilities
    ],

];
