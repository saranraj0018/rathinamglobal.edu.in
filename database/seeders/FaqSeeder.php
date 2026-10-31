<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * @var array<string, list<array{0: string, 1: string}>>
     */
    private const FAQS = [
        'hostel' => [
            ['Does Rathinam provide hostel facilities?', 'Yes. Separate hostel facilities for boys and girls are provided within or very close to the campus.'],
            ['Where are the hostels located?', 'Hostels are located within the campus or very close to the campus for easy academic access.'],
            ['Are hostels separate for boys and girls?', 'Yes. Separate hostels are available for boys and girls with dedicated wardens.'],
            ['What types of hostel rooms are available?', '2-sharing, 4-sharing, 6-sharing, 8-sharing, and dormitory rooms are available.'],
            ['How many students can stay in one hostel room?', 'Depending on the category, 2 to 8 students can stay in one room.'],
            ['What furniture is provided in hostel rooms?', 'Beds, study tables, chairs, and cupboards or luggage storage are provided.'],
            ['Is Wi-Fi available in the hostel?', 'Yes. Wi-Fi connectivity is available throughout the hostel premises.'],
            ['Is hot water facility available?', 'Yes. Hot water facility is provided for hostel students.'],
            ['Are attached bathrooms available?', 'Attached or common bathrooms are available based on the selected room category.'],
            ['Is food provided in the hostel?', 'Yes. Both vegetarian and non-vegetarian food is provided.'],
            ['How is food quality monitored?', 'Food quality is monitored through hygiene checks, inspections, and student feedback.'],
            ['Are laundry services available?', 'Yes. Laundry services are available for hostel students.'],
            ['Is housekeeping provided?', 'Yes. Regular housekeeping services are provided.'],
            ['Are there fixed study hours in the hostel?', 'Yes. Dedicated study hours are maintained to support academics.'],
            ['What are the hostel in-time and out-time rules?', 'Clearly defined in-time and out-time rules are followed for boys and girls.'],
            ['Are students allowed to go home on weekends?', 'Yes. Weekend home visits and Sunday outings are allowed with parental consent.'],
            ['Can parents visit the hostel?', 'Yes. Parents can visit during specified visiting hours.'],
            ['What safety measures are available in the hostel?', 'CCTV surveillance, 24/7 security, controlled entry, and wardens ensure safety.'],
            ['Is attendance monitored in the hostel?', 'Yes. Student attendance is monitored regularly.'],
            ['Will parents be informed about absenteeism?', 'Yes. Parents are informed immediately in case of absenteeism.'],
            ['Is medical support available for hostel students?', 'Yes. First-aid facilities, hospital tie-ups, and emergency transport are available.'],
            ['Is outside food allowed in the hostel?', 'Outside food delivery is regulated as per hostel rules.'],
            ['Can students choose their roommates?', 'Roommate preferences are considered subject to availability and policies.'],
        ],
        'transport' => [
            ['Does Rathinam provide transport facilities?', 'Yes. College transport facilities are available across major routes.'],
            ['Which areas are covered under transport facilities?', 'Major towns, residential locations, and student-dense areas are covered.'],
            ['What are the morning pickup timings?', 'Pickup timings range between 6:45 AM and 8:05 AM depending on the route.'],
            ['What time do buses reach the campus?', 'All buses reach the campus by 8:45 AM.'],
            ['What are the evening drop timings?', 'Evening drop timings are between 4:45 PM and 5:00 PM.'],
            ['Is a bus pass issued to transport users?', 'Yes. Students using transport are issued an official bus pass.'],
            ['What safety features are available in college buses?', 'GPS tracking, CCTV cameras, first-aid kits, fire extinguishers, and trained drivers are provided.'],
        ],
    ];

    public function run(): void
    {
        $this->call(FaqCategorySeeder::class);

        $hostel = FaqCategory::where('slug', 'hostel')->firstOrFail();

        $transport = FaqCategory::firstOrCreate(
            ['slug' => 'transport'],
            ['name_en' => 'Transport', 'name_ta' => 'போக்குவரத்து', 'sort_order' => $hostel->sort_order + 5, 'is_active' => true],
        );

        $categories = ['hostel' => $hostel, 'transport' => $transport];

        foreach (self::FAQS as $categorySlug => $faqs) {
            $category = $categories[$categorySlug];

            foreach ($faqs as [$question, $answer]) {
                Faq::firstOrCreate(
                    ['faq_category_id' => $category->id, 'question_en' => $question],
                    ['answer_en' => $answer, 'is_active' => true, 'published_at' => now()],
                );
            }
        }
    }
}
