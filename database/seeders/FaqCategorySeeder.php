<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqCategorySeeder extends Seeder
{
    private const CATEGORIES = [
        'Admissions' => 'சேர்க்கை', 'Courses' => 'படிப்புகள்', 'Fees' => 'கட்டணம்', 'Eligibility' => 'தகுதி',
        'Placements' => 'வேலைவாய்ப்பு', 'Hostel' => 'விடுதி', 'Scholarships' => 'உதவித்தொகை', 'Facilities' => 'வசதிகள்',
        'Contact Information' => 'தொடர்பு தகவல்', 'General Information' => 'பொது தகவல்',
    ];

    public function run(): void
    {
        $order = 0;

        foreach (self::CATEGORIES as $english => $tamil) {
            FaqCategory::firstOrCreate(['slug' => Str::slug($english)], ['name_en' => $english, 'name_ta' => $tamil, 'sort_order' => $order += 10]);
        }
    }
}
