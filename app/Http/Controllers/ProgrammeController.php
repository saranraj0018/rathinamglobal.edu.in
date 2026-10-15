<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * Programme landing pages: /courses/programmes/{school}/{programme}.
 *
 * Every programme shares one template; its content comes from
 * resources/data/programmes/{school}/{programme}.php.
 */
class ProgrammeController extends Controller
{
    public function show(string $school, string $programme, ContentRepository $content): View
    {
        $name = "programmes/{$school}/{$programme}";

        abort_unless(in_array($school, SchoolController::SCHOOLS, true) && $content->has($name), 404);

        $data = $content->get($name);

        foreach (['hero', 'overview', 'rgu_distinct', 'careers'] as $section) {
            if (isset($data[$section]['image'])) {
                $data[$section]['image'] = $this->imageUrl($data[$section]['image']);
            }
        }

        foreach ($data['facilities_carousel'] ?? [] as $i => $facility) {
            $data['facilities_carousel'][$i]['img'] = $this->imageUrl($facility['img']);
        }

        foreach ($data['curriculum'] as $i => $semester) {
            // Badge: S1..S8 for regular semesters, a star / "E" for the special tabs after them.
            $data['curriculum'][$i]['short_label'] = $i < 8 ? 'S'.($i + 1) : ($i === 8 ? '★' : 'E');
        }

        return view('programmes.show', [
            'programme' => $data,
            'meta' => $data['meta'],
            'courseTemplate' => $data['course_template'],
            'semesterCount' => $this->semesterCount($data['curriculum']),
            'facilitiesGrid' => $this->facilitiesGrid(count($data['facilities'] ?? [])),
            'gallery' => array_map(fn (string $image): array => [
                'src' => $this->imageUrl($image),
                // Fallback: the same photo as .jpg when the .webp is unavailable.
                'fallback' => $this->imageUrl(preg_replace('/\.webp$/i', '.jpg', $image)),
            ], $data['gallery'] ?? []),
        ]);
    }

    /**
     * Only "Semester N" entries count (not "Elective Bucket", "Project & Internship Semester", ...).
     *
     * @param  array<int, array{sem: string}>  $curriculum
     */
    private function semesterCount(array $curriculum): int
    {
        return count(array_filter(
            $curriculum,
            fn (array $semester): bool => preg_match('/^Semester\s+\d+$/i', trim($semester['sem'])) === 1,
        ));
    }

    /**
     * Grid width adapts to the card count so a lone card is not stranded in an empty row.
     */
    private function facilitiesGrid(int $count): string
    {
        return match ($count) {
            1 => 'grid-cols-1 max-w-3xl mx-auto',
            2 => 'grid-cols-1 md:grid-cols-2 max-w-4xl mx-auto',
            default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        };
    }

    /**
     * Remote images are used as-is; anything else is a path on the public disk.
     */
    private function imageUrl(string $image): string
    {
        return preg_match('#^https?://#i', $image) ? $image : storage_asset($image);
    }
}
