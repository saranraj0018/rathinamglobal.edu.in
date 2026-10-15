<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use App\Support\IndianNumberFormat;
use Illuminate\View\View;

/**
 * Directorate of Research portal: overview, people pages and the research
 * output tables (grants, publications, books, patents, ...). Table data
 * lives in resources/data/research/*.php.
 */
class ResearchController extends Controller
{
    public function __construct(private ContentRepository $content) {}

    public function index(): View
    {
        $overview = $this->content->viewData('research/overview');

        $overview['heroCards'] = array_map(
            fn (array $card): array => $card + ['url' => route($card[4])],
            $overview['heroCards'],
        );

        $overview['glance'] = array_map(
            fn (array $item): array => $item + ['count_attributes' => $this->countAttributes($item)],
            $overview['glance'],
        );

        return view('research.index', ['active' => 'home'] + $overview);
    }

    public function directorate(): View
    {
        return view('research.directorate', ['active' => 'directorate'] + $this->content->viewData('research/directorate'));
    }

    public function registrar(): View
    {
        return view('research.registrar', ['active' => 'registrar'] + $this->content->viewData('research/registrar'));
    }

    public function grants(): View
    {
        $years = $this->padRows($this->content->get('research/grants'), 7);
        $totalRupees = 0;

        foreach ($years as $year) {
            $amount = preg_replace('/\D/', '', $year['total']);
            $totalRupees += $amount === '' ? 0 : (int) $amount;
        }

        return view('research.grants', [
            'academicYears' => $years,
            'totalRows' => $this->countRows($years),
            'totalRupees' => $totalRupees,
            'totalRupeesFormatted' => IndianNumberFormat::format($totalRupees),
        ]);
    }

    public function publications(): View
    {
        $years = $this->padRows($this->content->get('research/publications'), 6);

        return view('research.publications', [
            'academicYears' => $years,
            'totalRows' => $this->countRows($years),
        ]);
    }

    public function bookChapters(): View
    {
        $years = $this->padRows($this->content->get('research/book-chapters'), 7);

        return view('research.book-chapters', [
            'academicYears' => $years,
            'totalRows' => $this->countRows($years),
        ]);
    }

    public function patents(): View
    {
        $years = $this->padRows($this->content->get('research/patents'), 7);
        $statusCounts = ['granted' => 0, 'published' => 0, 'filed' => 0];

        foreach ($years as $y => $year) {
            foreach ($year['rows'] as $r => $row) {
                $status = $this->patentStatus($row[4]);
                $statusCounts[$status]++;
                $years[$y]['rows'][$r]['badge'] = 'status-'.$status;
            }
        }

        return view('research.patents', [
            'academicYears' => $years,
            'totalRows' => $this->countRows($years),
            'grantedCount' => $statusCounts['granted'],
            'publishedCount' => $statusCounts['published'],
            'filedCount' => $statusCounts['filed'],
        ]);
    }

    public function extensionConsultancy(): View
    {
        $rows = $this->content->get('research/extension-consultancy')['rows'];
        $totalRupees = array_sum(array_map(
            fn (array $row): int => (int) preg_replace('/\D/', '', $row['amount']),
            $rows,
        ));

        return view('research.extension-consultancy', [
            'rows' => $rows,
            'totalProjects' => count($rows),
            'totalRupees' => $totalRupees,
            'totalRupeesFormatted' => IndianNumberFormat::format($totalRupees),
        ]);
    }

    public function hackathons(): View
    {
        $years = $this->padRows($this->content->get('research/hackathons'), 10);

        return view('research.hackathons', [
            'academicYears' => $years,
            'totalRows' => $this->countRows($years),
        ]);
    }

    public function startups(): View
    {
        $startups = [];

        foreach ($this->content->get('research/startups') as $section) {
            foreach ($section['groups'] as $group) {
                foreach ($group['rows'] as $row) {
                    [$sno, $name, $date, $field, $regno, $founder, $members] = array_pad($row, 7, '');

                    $startups[] = [
                        'category' => $section['category'],
                        'year' => $group['year'],
                        'sno' => $sno,
                        'name' => $name,
                        'date' => $date,
                        'field' => $field,
                        'regno' => $regno,
                        'founder' => $founder,
                        'members' => $members,
                        'badge' => str_contains($section['category'], 'Student') ? 'cat-student' : 'cat-faculty',
                    ];
                }
            }
        }

        $studentCount = count(array_filter($startups, fn (array $s): bool => str_contains($s['category'], 'Student')));

        return view('research.startups', [
            'allRows' => $startups,
            'totalStudent' => $studentCount,
            'totalFaculty' => count($startups) - $studentCount,
            'totalStartups' => count($startups),
        ]);
    }

    /**
     * @param  array<int, array{rows: array<int, array<int, string>>}>  $years
     * @return array<int, array{rows: array<int, array<int, string>>}>
     */
    private function padRows(array $years, int $columns): array
    {
        foreach ($years as $y => $year) {
            $years[$y]['rows'] = array_map(fn (array $row): array => array_pad($row, $columns, ''), $year['rows']);
        }

        return $years;
    }

    /**
     * @param  array<int, array{rows: array<mixed>}>  $years
     */
    private function countRows(array $years): int
    {
        return array_sum(array_map(fn (array $year): int => count($year['rows']), $years));
    }

    private function patentStatus(string $status): string
    {
        $status = strtolower($status);

        return match (true) {
            str_contains($status, 'granted') => 'granted',
            str_contains($status, 'published') => 'published',
            default => 'filed',
        };
    }

    /**
     * data-count / data-prefix / data-suffix / data-dec attributes for the
     * animated "at a glance" counters.
     *
     * @param  array<int, mixed>  $item
     */
    private function countAttributes(array $item): string
    {
        if ($item[0] !== 'count') {
            return '';
        }

        $attributes = 'data-count="'.e($item[1]).'"';

        if (! empty($item[5])) {
            $attributes .= ' data-prefix="'.e($item[5]).'"';
        }
        if (! empty($item[6])) {
            $attributes .= ' data-suffix="'.e($item[6]).'"';
        }
        if (isset($item[7])) {
            $attributes .= ' data-dec="'.(int) $item[7].'"';
        }

        return $attributes;
    }
}
