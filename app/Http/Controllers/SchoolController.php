<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * School pages under /courses/{school}. Each school has its own view
 * (resources/views/schools/{slug}.blade.php) and, where the page lists
 * content, a data file in resources/data/schools/{slug}.php.
 */
class SchoolController extends Controller
{
    public const SCHOOLS = [
        'school-of-applied-biosciences',
        'school-of-business-and-commerce',
        'school-of-engineering-emerging-technologies',
        'school-of-fashion-design',
        'school-of-liberal-arts-science',
        'school-of-media-and-performing-arts',
        'school-of-quantum-science',
        'school-of-sports-and-health-sciences',
        'school-of-sustainability-and-climate-studies',
    ];

    public function show(string $school, ContentRepository $content): View
    {
        $data = $content->has("schools/{$school}") ? $content->viewData("schools/{$school}") : [];

        if (isset($data['groups'], $data['programLinks'])) {
            $data['groups'] = $this->linkProgrammes($school, $data['groups'], $data['programLinks']);
        }

        return view("schools.{$school}", $data);
    }

    /**
     * Turn each group's course names into [name, url] pairs; courses that have
     * a programme page link to it, the rest have a null url.
     *
     * @param  array<int, array<string, mixed>>  $groups
     * @param  array<string, string>  $programLinks  course name => programme slug
     * @return array<int, array<string, mixed>>
     */
    private function linkProgrammes(string $school, array $groups, array $programLinks): array
    {
        foreach ($groups as $g => $group) {
            $groups[$g]['courses'] = array_map(function (string $name) use ($school, $programLinks): array {
                $slug = $programLinks[html_entity_decode($name, ENT_QUOTES, 'UTF-8')] ?? null;

                return [
                    'name' => $name,
                    'url' => $slug === null ? null : route('programmes.show', ['school' => $school, 'programme' => $slug]),
                ];
            }, $group['courses']);
        }

        return $groups;
    }
}
