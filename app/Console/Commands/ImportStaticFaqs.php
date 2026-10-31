<?php

namespace App\Console\Commands;

use App\Models\Faq;
use App\Models\FaqCategory;
use Database\Seeders\FaqCategorySeeder;
use Illuminate\Console\Command;

class ImportStaticFaqs extends Command
{
    protected $signature = 'assistant:import-faqs';

    protected $description = 'Import the FAQs of the public FAQ page (resources/data/faqs.php) into the admin-managed FAQ table';

    public function handle(): int
    {
        $this->callSilent('db:seed', ['--class' => FaqCategorySeeder::class, '--force' => true]);

        $imported = 0;

        foreach (require resource_path('data/faqs.php') as $group) {
            $category = FaqCategory::firstOrCreate(
                ['slug' => $group['id']],
                ['name_en' => html_entity_decode(strip_tags($group['label'])), 'sort_order' => 100],
            );

            foreach ($group['items'] as $item) {
                $question = html_entity_decode(strip_tags($item['q']), ENT_QUOTES | ENT_HTML5);

                if (Faq::where('question_en', $question)->exists()) {
                    continue;
                }

                $faq = new Faq([
                    'faq_category_id' => $category->id,
                    'question_en' => $question,
                    'answer_en' => html_entity_decode(strip_tags($item['a']), ENT_QUOTES | ENT_HTML5),
                    'is_active' => true,
                    'published_at' => now(),
                ]);
                $faq->save();
                $imported++;
            }
        }

        $this->info("{$imported} FAQs imported. Add Tamil text and keywords in /admin/faqs.");

        return self::SUCCESS;
    }
}
