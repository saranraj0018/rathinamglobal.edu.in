<?php

/**
 * Centralised program data — B.Com Computer Applications (Business Intelligence & AI)
 * -----------------------------------------------------------------------------------
 * Single source of truth for the program landing page.
 * Same shape as the other program data files — only the values differ.
 * Keep this file PURE DATA — no HTML, no styling, no logic.
 *
 * Blank fields intentionally left empty (faculty will fill later),
 * exactly as in the source docx.
 */

return [

    /* ─────────────────────────────────────────────────────────
     *  1 · BASIC IDENTITY
     * ───────────────────────────────────────────────────────── */
    'meta' => [
        'department_name' => 'B.Com Computer Applications',
        'program_name' => 'B.Com CA — Computer Applications with AI',
        'school' => 'School of Business and Commerce',
        'campus' => 'Rathinam Global Deemed to be University',
        'academic_year' => '2026-2027',
        'prepared_by' => 'Dr. G. Arut Geevitha',
        'duration_label' => '3 Years · 6 Semesters · Full Time',
        'mode' => 'Full Time',
        'level' => 'Under-Graduate',
        'school_slug' => 'school-of-business-and-commerce',
        'program_slug' => 'b.com-ca',
        'apply_url' => 'https://rathinamglobal.edu.in/?utm_source=program-lp&utm_medium=apply-cta&utm_campaign=bcom-ca',
        'brochure_url' => '#',
        'curriculum_pdf' => '#',
        'prospectus_pdf' => '#',
    ],

    /* ─────────────────────────────────────────────────────────
     *  2 · HERO
     * ───────────────────────────────────────────────────────── */
    'hero' => [
        'eyebrow' => 'School of Business and Commerce',
        'title' => 'B.Com Computer Applications (BI & AI)',
        'subtitle' => 'Bachelor of Commerce blending core accounting with Data Analytics, AI, Python & Web Technologies',
        'tagline' => 'Commerce meets Computer Applications — the AI-ready degree',
        // Hero photo — drop the file next to this data file
        'image' => 'courses/programmes/school-of-business-and-commerce/herosection_bsc_cs.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     *  3 · OVERVIEW  (Section 1 of docx — verbatim)
     * ───────────────────────────────────────────────────────── */
    'overview' => [
        'headline' => 'Commerce meets Computer Applications — the AI-ready degree',
        'paragraphs' => [
            "Established in 2001, the School of Commerce has evolved into a vibrant and multidisciplinary center of academic excellence, offering a comprehensive portfolio of undergraduate, postgraduate, and research programmes. Committed to nurturing future-ready professionals, the school seamlessly integrates academic rigour with experiential learning, industry engagement, and innovation. Through a curriculum that reflects emerging global business trends and professional standards, the school equips students with the knowledge, skills, and ethical values required to excel in today's dynamic and competitive business environment.",
        ],
        'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     *  4 · WHY CHOOSE THIS PROGRAM
     * ───────────────────────────────────────────────────────── */
    'why_choose' => [
        [
            'icon' => 'calculator',
            'title' => 'Strong Commerce & Accounting Core',
            'color' => 'emerald',
            'points' => [
                'Financial & Corporate Accounting',
                'Cost & Management Accounting',
                'Taxation & Business Law',
                'Banking Theory Law & Practice',
                'Business Economics & Statistics',
            ],
            'note' => 'A solid commerce foundation prepares every graduate for finance-tech careers.',
        ],
        [
            'icon' => 'sparkles',
            'title' => 'AI, Analytics & Python Skills',
            'color' => 'indigo',
            'points' => [
                'Python Programming',
                'Data Analytics with R / Python',
                'Data Analysis using SPSS',
                'Digital Information Management',
                'AI for Business & Decision Making',
            ],
            'note' => 'Hands-on with the technologies driving the next generation of commerce.',
        ],
        [
            'icon' => 'flask-conical',
            'title' => 'Hands-On Labs & Industry Immersion',
            'color' => 'amber',
            'points' => [
                'Data Visualization with Excel',
                'HTML & Web Development Lab',
                'Financial Statement Analysis',
                'Commerce Practices lab',
                'Live capstone project in Semester 6',
            ],
            'note' => 'Practical labs every semester build precision, analytics and shipping habits.',
        ],
        [
            'icon' => 'graduation-cap',
            'title' => 'Research & Higher Studies Orientation',
            'color' => 'rose',
            'points' => [
                'Research Methodology',
                'SPSS-based data analysis',
                'Capstone project (Semester 6)',
                'M.Com · MBA · MCA pathways',
                'Publication & seminar support',
            ],
            'note' => 'Graduates are equally prepared for industry and post-graduate study.',
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     *  5 · WHAT MAKES RGU DISTINCT
     * ───────────────────────────────────────────────────────── */
    'rgu_distinct' => [
        'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&h=900&q=80',
        'points' => [
            'Learner-centric academic environment',
            'Outcome-based education framework',
            'Industry-co-designed curriculum, updated yearly',
            'Excellent placement support',
            'Scholarship opportunities',
            'Separate hostel facilities for boys and girls',
            'NAAC A++ accredited deemed university',
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     *  6 · ADMISSION & ELIGIBILITY  (Section 3 of docx — verbatim)
     * ───────────────────────────────────────────────────────── */
    'eligibility' => [
        ['field' => 'Educational Qualification',                   'value' => 'HSC — PASSED'],
        ['field' => 'Rathinam Qualification',                      'value' => 'As per RGU Admission Norms.'],
        ['field' => 'Minimum Marks Required in 10th Standard',     'value' => 'Pass'],
        ['field' => 'Minimum Marks Required in 12th Standard',     'value' => 'Pass (Minimum 40% marks preferred, as per UGC norms)'],
        ['field' => 'Additional Eligibility / Admission Notes',    'value' => 'Students from any stream (Commerce, Science or Arts) are eligible. Admission is based on university guidelines & document verification.'],
    ],

    /* ─────────────────────────────────────────────────────────
     *  7 · FEE STRUCTURE (blank — docx)
     * ───────────────────────────────────────────────────────── */
    'fees' => [
        ['heading' => 'Tuition Fees',                          'body' => ''],
        ['heading' => 'Hostel Fee Structure (new admissions)', 'body' => ''],
        ['heading' => 'Other Fees',                            'body' => ''],
    ],

    /* ─────────────────────────────────────────────────────────
     *  8 · FACILITIES (Section 6 of docx — verbatim paragraph)
     *      Rendered as a single narrative card in the LP.
     * ───────────────────────────────────────────────────────── */
    'facilities' => [
        [
            'name' => 'Learning Environment & Infrastructure',
            'desc' => 'The School of Business and Commerce offers a modern and technology-enabled learning environment designed to foster academic excellence and professional competence. The department is equipped with well-furnished smart classrooms, advanced computer laboratories with high-speed internet connectivity, and industry-relevant software such as Tally Prime, Microsoft Office Suite, Advanced Excel, Power BI, Python, ERP applications, and AI-enabled business tools. Students have access to a well-stocked library with extensive print and digital resources, seminar halls with state-of-the-art audio-visual facilities, and dedicated skill development spaces that support communication, aptitude, and employability training. Complemented by campus-wide Wi-Fi, research support, industry-integrated learning resources, and career guidance services, these facilities provide students with a comprehensive and enriching educational experience.',
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     *  9 · CURRICULUM (Section 2 of docx — verbatim, 6 semesters + Elective Bucket)
     * ───────────────────────────────────────────────────────── */
    'curriculum' => [
        [
            'sem' => 'Semester 1',
            'total_hours' => '32',
            'total_credits' => '26',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil I',                          'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English I',                        'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Financial Accounting',             'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Law',                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Economics',               'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Mathematics',             'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Ethics',                  'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Data Visualization with Excel',    'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => '50/50'],
                ['cat' => '',   'code' => '', 'title' => 'Industrial Training',              'ltpc' => '0-0-0-0', 'credit' => '1', 'eval' => '0/100'],
                ['cat' => '',   'code' => '', 'title' => 'AEC I',                            'ltpc' => '0-0-4-4', 'credit' => '2', 'eval' => '100/0'],
            ],
        ],
        [
            'sem' => 'Semester 2',
            'total_hours' => '34',
            'total_credits' => '27',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil II',                         'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English II',                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Corporate Accounting',             'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => '100/0'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Communication',           'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Environment',             'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Statistics',              'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Export and Import Documentation',  'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Data Analytics with R',            'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => '50/50'],
                ['cat' => '',   'code' => '', 'title' => 'Industrial Training',              'ltpc' => '0-0-0-0', 'credit' => '1', 'eval' => '0/100'],
                ['cat' => '',   'code' => '', 'title' => 'AEC II',                           'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => '100/0'],
                ['cat' => '',   'code' => '', 'title' => 'NASA',                             'ltpc' => '0-0-2-0', 'credit' => '1', 'eval' => '100/0'],
            ],
        ],
        [
            'sem' => 'Semester 3',
            'total_hours' => '32',
            'total_credits' => '27',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil III',                         'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English III',                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Cost Accounting',                   'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => '100/0'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Taxation',                          'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Markup Language for Web Design',    'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => '100/0'],
                ['cat' => 'MATM', 'code' => '', 'title' => 'Banking Theory Law and Practice',   'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Data Analysis using SPSS',          'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'HTML & Web Development Lab',        'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => '50/50'],
                ['cat' => '',    'code' => '', 'title' => 'Industrial Training',               'ltpc' => '0-0-0-0', 'credit' => '2', 'eval' => '0/100'],
                ['cat' => '',    'code' => '', 'title' => 'AEC',                               'ltpc' => '2-0-0-2', 'credit' => '2', 'eval' => '100/0'],
            ],
        ],
        [
            'sem' => 'Semester 4',
            'total_hours' => '29',
            'total_credits' => '23',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil IV',                                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English IV',                                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Management Accounting',                          'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => '100/0'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Python Programming',                             'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => '100/0'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Digital Information Management',                 'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Financial Statement Analysis and Reporting',     'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Data Analytics with Python',                     'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Research Methodology',                           'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => '',   'code' => '', 'title' => 'Industrial Training',                            'ltpc' => '0-0-0-0', 'credit' => '2', 'eval' => '0/100'],
                ['cat' => '',   'code' => '', 'title' => 'NASA',                                           'ltpc' => '0-0-2-0', 'credit' => '1', 'eval' => '100/0'],
            ],
        ],
        [
            'sem' => 'Semester 5',
            'total_hours' => '15',
            'total_credits' => '15',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Digital Information Management',   'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'DSE',                              'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'DSE',                              'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Commerce Practices',               'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => '50/50'],
                ['cat' => '',   'code' => '', 'title' => 'AEC',                              'ltpc' => '2-0-0-2', 'credit' => '2', 'eval' => '100/0'],
                ['cat' => '',   'code' => '', 'title' => 'Industrial Training',              'ltpc' => '0-0-0-0', 'credit' => '2', 'eval' => '0/100'],
            ],
        ],
        [
            'sem' => 'Semester 6',
            'total_hours' => '22',
            'total_credits' => '10',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'DSE',     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'OE',      'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Project', 'ltpc' => '0-0-8-0', 'credit' => '4', 'eval' => '50/50'],
            ],
        ],
        [
            'sem' => 'Elective Bucket',
            'total_hours' => '',
            'total_credits' => '',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Artificial Intelligence for Business',              'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Blockchain for Digital Business',                   'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Digital Business & Commerce',                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Digital Marketing',                                 'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Service Marketing',                                 'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Brand Management',                                  'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'AI for Decision Making',                            'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Digital Marketing and Social Media Analytics',      'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Artificial Intelligence for Everyday Life',         'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Cyber Security and Digital Safety',                 'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Smart Technologies in Business',                    'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Entrepreneurship and Startup Management',           'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'AI Tools for Academic Research and Content Creation', 'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'E-Commerce and Digital Business',                   'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Blockchain and Digital Assets',                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Communication with AI Tools',              'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
            ],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 10 · PROGRAM OUTCOMES — PEO / PSO / PO
     *      Descriptions BLANK in docx → kept blank.
     * ───────────────────────────────────────────────────────── */
    'outcomes' => [
        'peo' => [
            ['no' => 'PEO1', 'title' => '', 'desc' => ''],
            ['no' => 'PEO2', 'title' => '', 'desc' => ''],
            ['no' => 'PEO3', 'title' => '', 'desc' => ''],
            ['no' => 'PEO4', 'title' => '', 'desc' => ''],
        ],
        'pso' => [
            ['no' => 'PSO1', 'title' => '', 'desc' => ''],
            ['no' => 'PSO2', 'title' => '', 'desc' => ''],
            ['no' => 'PSO3', 'title' => '', 'desc' => ''],
        ],
        'po' => [
            ['no' => 'PO1', 'title' => 'Course Knowledge',                          'desc' => ''],
            ['no' => 'PO2', 'title' => 'Problem Analysis',                          'desc' => ''],
            ['no' => 'PO3', 'title' => 'Design and Development of Solutions',       'desc' => ''],
            ['no' => 'PO4', 'title' => 'Conduct Investigations of Complex Problems', 'desc' => ''],
            ['no' => 'PO5', 'title' => 'Modern Tool Usage',                         'desc' => ''],
            ['no' => 'PO6', 'title' => 'The Engineer and Society',                  'desc' => ''],
            ['no' => 'PO7', 'title' => 'Environment and Sustainability',            'desc' => ''],
            ['no' => 'PO8', 'title' => 'Ethics',                                    'desc' => ''],
            ['no' => 'PO9', 'title' => 'Individual and Team Work',                  'desc' => ''],
            ['no' => 'PO10', 'title' => 'Communication',                             'desc' => ''],
            ['no' => 'PO11', 'title' => 'Project Management and Finance',            'desc' => ''],
            ['no' => 'PO12', 'title' => 'Life-long Learning',                        'desc' => ''],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 11 · CURRICULUM RECOMMENDATIONS (8 blank rows — docx)
     * ───────────────────────────────────────────────────────── */
    'recommendations' => [
        ['no' => '1', 'point' => ''],
        ['no' => '2', 'point' => ''],
        ['no' => '3', 'point' => ''],
        ['no' => '4', 'point' => ''],
        ['no' => '5', 'point' => ''],
        ['no' => '6', 'point' => ''],
        ['no' => '7', 'point' => ''],
        ['no' => '8', 'point' => ''],
    ],

    /* ─────────────────────────────────────────────────────────
     * 12 · WHY RGU  (Section 7 of docx — verbatim)
     * ───────────────────────────────────────────────────────── */
    'why_rgu' => [
        'headline' => 'Why RGU for B.Com Computer Applications?',
        'body' => 'Rathinam Global deemed to be University (RGU) offers a transformative learning experience by combining academic excellence with industry-driven education, innovation, and global exposure. Students benefit from an outcome-based curriculum, experienced faculty, experiential learning, industry internships, value-added certification programmes, and strong corporate partnerships that enhance employability. The institution provides excellent placement support through dedicated career development initiatives, skill enhancement programmes, entrepreneurship and innovation opportunities, international collaborations, global immersion programmes, and student exchange initiatives. With state-of-the-art infrastructure, technology-enabled classrooms, research and incubation facilities, comprehensive student support services, and a vibrant campus ecosystem, RGU empowers students to become competent professionals, responsible leaders, and lifelong learners prepared to thrive in a rapidly evolving global environment.',
        'stats' => [
            ['value' => '6',    'label' => 'Semesters'],
            ['value' => '128+', 'label' => 'Total Credits'],
            ['value' => '40+',  'label' => 'Industry Partners'],
            ['value' => '100%', 'label' => 'Placement Support'],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 13 · CAREER PATHWAYS
     * ───────────────────────────────────────────────────────── */
    'careers' => [
        'roles' => [
            'Business Analyst',
            'Data Analyst · BI Developer',
            'Accounts / Finance Executive',
            'Python Developer',
            'Web Developer',
            'ERP / Tally Consultant',
            'Digital Marketing Executive',
            'AI Solutions Associate',
            'E-Commerce Manager',
            'Research Associate',
        ],
        'higher_studies' => [
            'M.Com Computer Applications',
            'MBA (Business Analytics / AI)',
            'MCA',
            'M.Sc Data Science',
            'M.Sc AI & Data Science',
        ],
        'image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     * 14 · DETAILED COURSE TEMPLATE
     *      Sample seeded from the docx (Financial Accounting).
     *      Faculty will duplicate this template for every course later.
     * ───────────────────────────────────────────────────────── */
    'course_template' => [
        'details' => [
            ['field' => 'Course Name',  'value' => 'Financial Accounting'],
            ['field' => 'Course Code',  'value' => ''],
            ['field' => 'Program',      'value' => 'B.Com CA'],
            ['field' => 'Semester',     'value' => 'I'],
            ['field' => 'Credits',      'value' => '3'],
            ['field' => 'Campus',       'value' => 'Rathinam Global Deemed to be University'],
        ],
        'syllabus' => [
            ['unit' => 'Unit 1', 'content' => 'Meaning and Definition of Accounting – Objectives and Functions of Accounting – Generally Accepted Accounting Principles (GAAP) – Accounting Concepts and Conventions – Fundamentals of Book-keeping – Difference between Book-keeping and Accounting – Accounting Equation – Capital and Revenue Expenditure – Capital and Revenue Receipts.'],
            ['unit' => 'Unit 2', 'content' => 'Journal – Ledger – Subsidiary Books: Purchases Book, Sales Book, Purchases Return Book, Sales Return Book, Bills Payable Book, Bills Receivable Book – Cash Book: Simple Cash Book, Double Column Cash Book, Three Column Cash Book, Petty Cash Book – Trial Balance.'],
            ['unit' => 'Unit 3', 'content' => 'Rectification of Errors – Depreciation: Meaning, Causes, Straight Line Method and Written Down Value Method – Preparation of Trading Account – Profit and Loss Account – Balance Sheet with Adjustments (Sole Proprietorship).'],
            ['unit' => 'Unit 4', 'content' => 'Bills of Exchange – Meaning and Need – Types of Bills – Dishonour of a Bill – Renewal of a Bill – Average Due Date – Account Current – Methods of Account Current (basic problems).'],
            ['unit' => 'Unit 5', 'content' => 'Bank Reconciliation Statement – Need and Preparation – Receipts and Payments Account – Income and Expenditure Account – Balance Sheet of Not-for-Profit Organisations.'],
        ],
        'objectives' => '',
        'outcomes' => [
            ['co' => 'CO1', 'statement' => ''],
            ['co' => 'CO2', 'statement' => ''],
            ['co' => 'CO3', 'statement' => ''],
            ['co' => 'CO4', 'statement' => ''],
            ['co' => 'CO5', 'statement' => ''],
        ],
        'co_po_mapping' => [
            'cols' => ['PO1', 'PO2', 'PO3', 'PO4', 'PO5', 'PO6', 'PO7', 'PO8', 'PO9', 'PO10', 'PO11', 'PO12', 'PSO1', 'PSO2', 'PSO3'],
            'rows' => [
                ['co' => 'CO1', 'map' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '']],
                ['co' => 'CO2', 'map' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '']],
                ['co' => 'CO3', 'map' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '']],
                ['co' => 'CO4', 'map' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '']],
                ['co' => 'CO5', 'map' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '']],
            ],
        ],
        'evaluation' => [
            ['assessment' => 'CA',           'internal' => '', 'end_sem' => ''],
            ['assessment' => 'Mid-Term',     'internal' => '', 'end_sem' => ''],
            ['assessment' => 'End Semester', 'internal' => '', 'end_sem' => ''],
        ],
        'textbooks' => '',
        'references' => '',
    ],

    /* ─────────────────────────────────────────────────────────
     * 15 · DOWNLOADS
     * ───────────────────────────────────────────────────────── */
    'downloads' => [
        ['title' => 'Admission Handbook 2026', 'url' => '#'],
        ['title' => 'Curriculum 2026',         'url' => '#'],
        ['title' => 'Prospectus 2026',         'url' => '#'],
    ],

    /* ─────────────────────────────────────────────────────────
     * 16 · GALLERY (from assets/images/life/)
     * ───────────────────────────────────────────────────────── */
    'gallery' => [
        'assets/images/life/02.webp',
        'assets/images/life/04.webp',
        'assets/images/life/06.webp',
        'assets/images/life/08.webp',
        'assets/images/life/10.webp',
        'assets/images/life/12.webp',
        'assets/images/life/14.webp',
        'assets/images/life/01.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     * 16.b · FACILITIES CAROUSEL (business / tech themed)
     * ───────────────────────────────────────────────────────── */
    'facilities_carousel' => [
        ['img' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Python & Web Development Lab'],
        ['img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Data Analytics (SPSS/R) Lab'],
        ['img' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Computerized Accounting Lab'],
        ['img' => 'https://images.unsplash.com/photo-1543286386-713bdd548da4?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Financial Modelling & Excel Studio'],
        ['img' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Smart Classroom · 4K Interactive'],
        ['img' => 'https://images.unsplash.com/photo-1497215842964-222b430dc094?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'AI & Emerging Tech Centre'],
        ['img' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Business Research Library'],
        ['img' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Placement & Training Cell'],
    ],

    /* ─────────────────────────────────────────────────────────
     * 17 · CONTACT
     * ───────────────────────────────────────────────────────── */
    'contact' => [
        'admissions' => [
            'address' => 'Eachanari, Coimbatore, Tamil Nadu – 641021',
            'phone' => '+91-844-844-8909',
            'email' => 'admissions@rathinamglobal.edu.in',
        ],
        'department' => [
            'head' => 'Dr. G. Arut Geevitha',
            'phone' => '',
            'email' => '',
        ],
    ],

    /* Image alt text used by the page template. */
    'image_alts' => [
        'overview' => 'B.Com Computer Applications students learning in a modern classroom at Rathinam Global University',
        'rgu_distinct' => 'Rathinam Global University campus learning environment and student development',
        'careers' => 'B.Com Computer Applications career outcomes and student opportunities',
        'gallery' => 'Campus gallery image for B.Com Computer Applications at Rathinam Global University',
    ],
];
