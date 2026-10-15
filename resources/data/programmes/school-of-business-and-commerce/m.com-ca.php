<?php

/**
 * Centralised program data — M.Com Computer Applications (AI-Ready Accountant)
 * ---------------------------------------------------------------------------
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
        'department_name' => 'M.Com Computer Applications',
        'program_name' => 'M.Com CA — Computer Applications with AI (AI-Ready Accountant)',
        'school' => 'School of Business and Commerce',
        'campus' => 'Rathinam Global Deemed to be University',
        'academic_year' => '2026-2027',
        'prepared_by' => 'Dr. G. Arut Geevitha',
        'duration_label' => '2 Years · 4 Semesters · Full Time',
        'mode' => 'Full Time',
        'level' => 'Post-Graduate',
        'school_slug' => 'school-of-business-and-commerce',
        'program_slug' => 'm.com-ca',
        'apply_url' => 'https://rathinamglobal.edu.in/?utm_source=program-lp&utm_medium=apply-cta&utm_campaign=mcom-ca',
        'brochure_url' => '#',
        'curriculum_pdf' => '#',
        'prospectus_pdf' => '#',
    ],

    /* ─────────────────────────────────────────────────────────
     *  2 · HERO
     * ───────────────────────────────────────────────────────── */
    'hero' => [
        'eyebrow' => 'School of Business and Commerce',
        'title' => 'M.Com Computer Applications (AI-Ready Accountant)',
        'subtitle' => 'Master of Commerce combining core commerce, AI, Python, C++, VB and Business Intelligence',
        'tagline' => 'An AI-ready postgraduate degree for the finance-tech generation',
        // Hero photo — drop the file next to this data file
        'image' => 'courses/programmes/school-of-business-and-commerce/herosection_bsc_cs.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     *  3 · OVERVIEW  (Section 1 of docx — verbatim)
     * ───────────────────────────────────────────────────────── */
    'overview' => [
        'headline' => 'An AI-ready postgraduate degree for the finance-tech generation',
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
            'title' => 'Advanced Commerce & Finance Core',
            'color' => 'emerald',
            'points' => [
                'Accounting for Business Decisions',
                'Cost & Management Accounting',
                'Financial Management',
                'Direct Tax',
                'Financial Markets & Institutions',
            ],
            'note' => 'A rigorous PG commerce core prepares graduates for senior finance-tech roles.',
        ],
        [
            'icon' => 'sparkles',
            'title' => 'AI, Programming & BI Specialisation',
            'color' => 'indigo',
            'points' => [
                'Programming with Python',
                'Object-Oriented Programming (C++)',
                'Visual Basic for Business Applications',
                'Business Intelligence & Database Systems',
                'Smart Accounting Systems with Python',
            ],
            'note' => 'Hands-on with the technologies driving next-generation commerce.',
        ],
        [
            'icon' => 'flask-conical',
            'title' => 'Hands-On Labs & Industry Immersion',
            'color' => 'amber',
            'points' => [
                'Database Solutions for Business',
                'Programming Practice with Visual Basic',
                'Digital Marketing labs',
                'Business Research Methods',
                'Semester 4 Project + Institute Training',
            ],
            'note' => 'Practical labs and a full project semester build precision and shipping habits.',
        ],
        [
            'icon' => 'graduation-cap',
            'title' => 'Research & Higher Studies Orientation',
            'color' => 'rose',
            'points' => [
                'Business Research Methods',
                'Project viva voce (Semester 4)',
                'Ph.D pathways',
                'Publication & seminar support',
                'Industry-institute collaboration',
            ],
            'note' => 'Graduates are equally prepared for professional practice and research careers.',
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
     *  7 · FEE STRUCTURE (docx: Rs.50000 per year)
     * ───────────────────────────────────────────────────────── */
    'fees' => [
        ['heading' => 'Tuition Fees',                          'body' => 'Rs. 50,000 per year.'],
        ['heading' => 'Hostel Fee Structure (new admissions)', 'body' => ''],
        ['heading' => 'Other Fees',                            'body' => ''],
    ],

    /* ─────────────────────────────────────────────────────────
     *  8 · FACILITIES (Section 6 of docx — verbatim paragraph)
     * ───────────────────────────────────────────────────────── */
    'facilities' => [
        [
            'name' => 'Learning Environment & Infrastructure',
            'desc' => 'The School of Business and Commerce offers a modern and technology-enabled learning environment designed to foster academic excellence and professional competence. The department is equipped with well-furnished smart classrooms, advanced computer laboratories with high-speed internet connectivity, and industry-relevant software such as Tally Prime, Microsoft Office Suite, Advanced Excel, Power BI, Python, ERP applications, and AI-enabled business tools. Students have access to a well-stocked library with extensive print and digital resources, seminar halls with state-of-the-art audio-visual facilities, and dedicated skill development spaces that support communication, aptitude, and employability training. Complemented by campus-wide Wi-Fi, research support, industry-integrated learning resources, and career guidance services, these facilities provide students with a comprehensive and enriching educational experience.',
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     *  9 · CURRICULUM (Section 2 of docx — verbatim, 4 semesters + Elective Bucket)
     *      Note: LTPC values like "3-0-03" are preserved verbatim from the docx.
     * ───────────────────────────────────────────────────────── */
    'curriculum' => [
        [
            'sem' => 'Semester 1',
            'total_hours' => '52',
            'total_credits' => '26',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'Accounting for Business Decisions',        'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Financial Management',                     'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Digital Marketing',                        'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Database Solutions for Business',          'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'E Commerce',                               'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Investment Management',                    'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Business Intelligence & Database System',  'ltpc' => '0-0-6-0', 'credit' => '3', 'eval' => '50/50'],
            ],
        ],
        [
            'sem' => 'Semester 2',
            'total_hours' => '52',
            'total_credits' => '26',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'Cost Accounting Techniques',                'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Object Oriented Programming with C++',      'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Business Research Methods',                 'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Human Resource Management',                 'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Communication for Business Professionals',  'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Blockchain Technology for Commerce',        'ltpc' => '3-0-03', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Object Oriented Programming with C++ Lab',  'ltpc' => '0-0-6-0', 'credit' => '3', 'eval' => '50/50'],
            ],
        ],
        [
            'sem' => 'Semester 3',
            'total_hours' => '55',
            'total_credits' => '26',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'Management Accounting',                     'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Direct Tax',                                'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Programming with Python',                   'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Visual Basic for Business Applications',    'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Programming Practice with Visual Basic',    'ltpc' => '4-0-0-4', 'credit' => '4', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Financial Markets and Institution',         'ltpc' => '3-0-03', 'credit' => '3', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Smart Accounting Systems with Python',      'ltpc' => '0-0-6-3', 'credit' => '3', 'eval' => '50/50'],
            ],
        ],
        [
            'sem' => 'Semester 4',
            'total_hours' => '12',
            'total_credits' => '12',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'Project viva voce',                'ltpc' => '0-0-20-0', 'credit' => '8', 'eval' => '50/50'],
                ['cat' => '', 'code' => '', 'title' => 'Industrial / Institute Training',  'ltpc' => '0-0-0-0', 'credit' => '4', 'eval' => '100/0'],
            ],
        ],
        [
            'sem' => 'Elective Bucket',
            'total_hours' => '',
            'total_credits' => '',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'Artificial Intelligence for Business',                 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Blockchain for Digital Business',                      'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Digital Business & Commerce',                          'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Digital Marketing',                                    'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Service Marketing',                                    'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Brand Management',                                     'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'AI for Decision Making',                               'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Digital Marketing and Social Media Analytics',         'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Artificial Intelligence for Everyday Life',            'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Cyber Security and Digital Safety',                    'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Smart Technologies in Business',                       'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Entrepreneurship and Startup Management',              'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'AI Tools for Academic Research and Content Creation',  'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'E-Commerce and Digital Business',                      'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Blockchain and Digital Assets',                        'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Business Communication with AI Tools',                 'ltpc' => '', 'credit' => '', 'eval' => ''],
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
        'headline' => 'Why RGU for M.Com Computer Applications?',
        'body' => 'Rathinam Global deemed to be University (RGU) offers a transformative learning experience by combining academic excellence with industry-driven education, innovation, and global exposure. Students benefit from an outcome-based curriculum, experienced faculty, experiential learning, industry internships, value-added certification programmes, and strong corporate partnerships that enhance employability. The institution provides excellent placement support through dedicated career development initiatives, skill enhancement programmes, entrepreneurship and innovation opportunities, international collaborations, global immersion programmes, and student exchange initiatives. With state-of-the-art infrastructure, technology-enabled classrooms, research and incubation facilities, comprehensive student support services, and a vibrant campus ecosystem, RGU empowers students to become competent professionals, responsible leaders, and lifelong learners prepared to thrive in a rapidly evolving global environment.',
        'stats' => [
            ['value' => '4',   'label' => 'Semesters'],
            ['value' => '90',  'label' => 'Total Credits'],
            ['value' => '40+', 'label' => 'Industry Partners'],
            ['value' => '100%', 'label' => 'Placement Support'],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 13 · CAREER PATHWAYS
     * ───────────────────────────────────────────────────────── */
    'careers' => [
        'roles' => [
            'AI-Ready Accountant',
            'Business Intelligence Developer',
            'Financial Analyst',
            'Data Analyst',
            'Python Developer',
            'ERP / Tally Consultant',
            'Investment Analyst',
            'Digital Marketing Manager',
            'Research Associate',
            'Corporate Trainer',
        ],
        'higher_studies' => [
            'Ph.D in Commerce',
            'Ph.D in Business Analytics',
            'MBA (Business Analytics / AI)',
            'M.Phil in Commerce',
            'Professional CA / CMA / CS',
        ],
        'image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     * 14 · DETAILED COURSE TEMPLATE (blank in docx — kept blank for faculty)
     * ───────────────────────────────────────────────────────── */
    'course_template' => [
        'details' => [
            ['field' => 'Course Name',  'value' => ''],
            ['field' => 'Course Code',  'value' => ''],
            ['field' => 'Program',      'value' => 'M.Com CA'],
            ['field' => 'Semester',     'value' => ''],
            ['field' => 'Credits',      'value' => ''],
            ['field' => 'Campus',       'value' => 'Rathinam Global Deemed to be University'],
        ],
        'syllabus' => [
            ['unit' => 'Unit 1', 'content' => ''],
            ['unit' => 'Unit 2', 'content' => ''],
            ['unit' => 'Unit 3', 'content' => ''],
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
        'assets/images/life/03.webp',
        'assets/images/life/05.webp',
        'assets/images/life/07.webp',
        'assets/images/life/09.webp',
        'assets/images/life/11.webp',
        'assets/images/life/13.webp',
        'assets/images/life/15.webp',
        'assets/images/life/02.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     * 16.b · FACILITIES CAROUSEL (business / tech themed)
     * ───────────────────────────────────────────────────────── */
    'facilities_carousel' => [
        ['img' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Python & C++ Programming Lab'],
        ['img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Business Intelligence Lab'],
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
        'overview' => 'M.Com Computer Applications students learning in a postgraduate business and technology environment at Rathinam Global University',
        'rgu_distinct' => 'Rathinam Global University advanced learning environment for postgraduate commerce students',
        'careers' => 'Career pathways for M.Com Computer Applications graduates',
        'gallery' => 'Campus gallery image for M.Com Computer Applications at Rathinam Global University',
    ],
];
