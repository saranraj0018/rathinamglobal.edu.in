<?php

/**
 * Centralised program data — B.Com PA & B.Com PA with Chartered Accountant
 * --------------------------------------------------------------
 * Single source of truth for the program landing page.
 * Same shape as the B.Sc CS data file — only the values differ.
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
        'department_name' => 'B.Com Professional Accounting',
        'program_name' => 'B.Com PA & B.Com PA with Chartered Accountant',
        'school' => 'School of Business and Commerce',
        'campus' => 'Rathinam Global Deemed To Be University',
        'academic_year' => '2026-2027',
        'prepared_by' => '',
        'duration_label' => '3 Years · 6 Semesters · Full Time',
        'mode' => 'Full Time',
        'level' => 'Under-Graduate',
        'school_slug' => 'school-of-business-and-commerce',
        'program_slug' => 'b.com-pa-and-b.com-pa-with-ca',
        'apply_url' => 'https://rathinamglobal.edu.in/?utm_source=program-lp&utm_medium=apply-cta&utm_campaign=bcom-pa',
        'brochure_url' => '#',
        'curriculum_pdf' => '#',
        'prospectus_pdf' => '#',
    ],

    /* ─────────────────────────────────────────────────────────
     *  2 · HERO
     * ───────────────────────────────────────────────────────── */
    'hero' => [
        'eyebrow' => 'School of Business and Commerce',
        'title' => 'B.Com PA & B.Com PA with Chartered Accountant',
        'subtitle' => 'Bachelor of Commerce in Professional Accounting with an integrated Chartered Accountant pathway',
        'tagline' => 'Build a CA-ready foundation in Accounting, Auditing, Taxation & Finance',
        // Hero photo — drop the file next to this data file (folder already holds herosection_bsc_cs.webp)
        'image' => 'courses/programmes/school-of-business-and-commerce/herosection_bsc_cs.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     *  3 · OVERVIEW  (Section 1 of docx — verbatim)
     * ───────────────────────────────────────────────────────── */
    'overview' => [
        'headline' => 'Build a CA-ready foundation in Accounting, Auditing, Taxation & Finance',
        'paragraphs' => [
            'The Department of Professional Accounting at the School of Business and Commerce, Rathinam Global Deemed to be University, is committed to developing highly competent accounting and finance professionals equipped to meet the evolving demands of the global business environment. The department offers B.Com Professional Accounting (B.Com PA) and B.Com Professional Accounting with Chartered Accountant.',
            'The curriculum is designed to provide students with a strong foundation in accounting, auditing, taxation, corporate laws, finance, business analytics, and emerging digital technologies. The programme aligns with professional qualifications such as Chartered Accountant (CA) and incorporates practical exposure through internships, industry projects, skill development programmes, and certification courses.',
            'The department emphasizes experiential learning, ethical business practices, critical thinking, analytical skills, entrepreneurship, and technology-enabled accounting solutions. Students are encouraged to develop competencies in accounting software, financial modelling, data analytics, Artificial Intelligence applications in commerce, and regulatory compliance to enhance their employability.',
            'With a learner-centric approach, experienced faculty members, industry collaborations, and continuous academic enrichment activities, the Department of Professional Accounting strives to produce globally competent, socially responsible, and professionally qualified graduates capable of excelling in accounting, auditing, taxation, financial consulting, banking, corporate finance, and entrepreneurial ventures.',
        ],
        'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     *  4 · WHY CHOOSE THIS PROGRAM
     * ───────────────────────────────────────────────────────── */
    'why_choose' => [
        [
            'icon' => 'calculator',
            'title' => 'Strong Foundation in Accounting & Finance',
            'color' => 'emerald',
            'points' => [
                'Financial & Corporate Accounting',
                'Cost & Management Accounting',
                'Auditing & Assurance',
                'Taxation & Corporate Law',
                'Financial Management',
            ],
            'note' => 'A rigorous commerce core prepares every graduate for CA, CMA and industry roles.',
        ],
        [
            'icon' => 'sparkles',
            'title' => 'CA Pathway & Professional Certifications',
            'color' => 'indigo',
            'points' => [
                'Integrated CA readiness',
                'IFRS & Financial Reporting',
                'CMA / CS / ACCA exposure',
                'Certification-linked electives',
                'Institutional Training every semester',
            ],
            'note' => 'The programme is aligned with the ICAI syllabus for a smoother CA journey.',
        ],
        [
            'icon' => 'flask-conical',
            'title' => 'Hands-On Labs & Industry Immersion',
            'color' => 'amber',
            'points' => [
                'Computerized Accounting (Tally/Zoho)',
                'Financial Modelling with Excel',
                'AI Tools for Financial Reporting',
                'Data Analysis using SPSS',
                'Live capstone project in Semester 6',
            ],
            'note' => 'Practical labs every semester build precision, ethics and shipping habits.',
        ],
        [
            'icon' => 'graduation-cap',
            'title' => 'Research & Higher Studies Orientation',
            'color' => 'rose',
            'points' => [
                'Research Methodology',
                'SPSS-based data analysis',
                'Capstone project (Semester 6)',
                'M.Com · MBA · CA pathways',
                'Publication & seminar support',
            ],
            'note' => 'Graduates are equally prepared for professional practice and post-graduate study.',
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
        [
            'field' => 'Educational Qualification',
            'value' => 'A pass in Higher Secondary Examination (10+2) or its equivalent from a recognized Board with Commerce/Accountancy or any other stream recognized by the University.',
        ],
        [
            'field' => 'Rathinam Qualification',
            'value' => "Admission shall be based on the eligibility norms prescribed by Rathinam Global Deemed to be University and the candidate's academic performance, subject to the University's admission regulations.",
        ],
        [
            'field' => 'Minimum Marks Required in 10th Standard',
            'value' => 'Pass in SSLC / 10th Standard or its equivalent from a recognized Board.',
        ],
        [
            'field' => 'Minimum Marks Required in 12th Standard',
            'value' => 'Pass in Higher Secondary Examination (10+2) or its equivalent from a recognized Board. (Minimum marks as prescribed by the University / Government from time to time.)',
        ],
        [
            'field' => 'Additional Eligibility / Admission Notes',
            'value' => 'Students with a Commerce background are preferred; however, candidates from all recognized streams are eligible. Applicants seeking admission to B.Com Professional Accounting with Chartered Accountant (CA) should possess a strong aptitude for accounting and finance and be willing to pursue professional certification alongside the degree programme. Admission is subject to verification of original certificates.',
        ],
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
     *  8 · FACILITIES (blank — docx)
     * ───────────────────────────────────────────────────────── */
    'facilities' => [],

    /* ─────────────────────────────────────────────────────────
     *  9 · CURRICULUM (Section 2 of docx — verbatim)
     * ───────────────────────────────────────────────────────── */
    'curriculum' => [
        [
            'sem' => 'Semester 1',
            'total_hours' => '32',
            'total_credits' => '26',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil I',                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English I',                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Financial Accounting',          'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Law',                  'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Economics',            'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Mathematics',          'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Forensic Accounting',           'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Computerized Accounting',       'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Institutional Training Report', 'ltpc' => '0-0-0-0', 'credit' => '1', 'eval' => 'External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Aptis',                          'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal'],
            ],
        ],
        [
            'sem' => 'Semester 2',
            'total_hours' => '32',
            'total_credits' => '27',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil II',                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English II',                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Corporate Accounting',           'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Communication',         'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Organizational Behavior',        'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Statistics',            'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Ethics',                'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Financial Modelling with Excel', 'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Industrial Training Report',     'ltpc' => '0-0-0-0', 'credit' => '1', 'eval' => 'External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Design Thinking and IPR',        'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Extension',                      'ltpc' => '0-0-2-0', 'credit' => '1', 'eval' => 'Internal'],
            ],
        ],
        [
            'sem' => 'Semester 3',
            'total_hours' => '32',
            'total_credits' => '27',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil III',                                                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English III',                                                   'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Cost Accounting',                                               'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Management Accounting',                                         'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Financial Management',                                          'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Business Environment',                                          'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Banking Law and Financial Services',                            'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'IFRS Analytics and AI Tools for Financial Reporting Lab',       'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Industrial Training Report',                                    'ltpc' => '0-0-0-0', 'credit' => '2', 'eval' => 'External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'AEC',                                                           'ltpc' => '2-0-0-2', 'credit' => '2', 'eval' => 'Internal'],
            ],
        ],
        [
            'sem' => 'Semester 4',
            'total_hours' => '32',
            'total_credits' => '23',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'Tamil IV',                                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'English IV',                                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Strategic Management',                           'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'CAT', 'code' => '', 'title' => 'Audit and Assurance',                            'ltpc' => '1-0-4-1', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Financial Statement Analysis and Reporting',     'ltpc' => '2-0-2-2', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Audit Practice and Internal Control',            'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Research Methodology',                           'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Industrial Training Report',                     'ltpc' => '0-0-0-0', 'credit' => '2', 'eval' => 'External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Extension',                                      'ltpc' => '0-0-2-0', 'credit' => '1', 'eval' => 'Internal'],
            ],
        ],
        [
            'sem' => 'Semester 5',
            'total_hours' => '15',
            'total_credits' => '15',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'DSE-I',                        'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'DSE-II',                       'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Taxation',                     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Data Analysis Using SPSS',     'ltpc' => '0-0-4-0', 'credit' => '2', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Industrial Training Report',   'ltpc' => '0-0-0-0', 'credit' => '2', 'eval' => 'External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'AEC',                          'ltpc' => '0-0-2-0', 'credit' => '2', 'eval' => 'Internal'],
            ],
        ],
        [
            'sem' => 'Semester 6',
            'total_hours' => '22',
            'total_credits' => '14',
            'courses' => [
                ['cat' => 'MAT', 'code' => '', 'title' => 'DSE-III', 'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'OE',     'ltpc' => '3-0-0-3', 'credit' => '3', 'eval' => 'Internal/External'],
                ['cat' => 'MAT', 'code' => '', 'title' => 'Project', 'ltpc' => '0-0-16-0', 'credit' => '8', 'eval' => 'Internal/External'],
            ],
        ],
        [
            'sem' => 'Elective Bucket',
            'total_hours' => '',
            'total_credits' => '',
            'courses' => [
                ['cat' => '', 'code' => '', 'title' => 'Financial Derivatives and Risk Management',           'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Security Analysis and Portfolio Management',          'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Introduction to IFRS and AI in Financial Reporting',  'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Business Process Automation in Accounting',           'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'Generative AI for Accounting Professionals',          'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => 'AI-Powered Financial Decision Making',                'ltpc' => '', 'credit' => '', 'eval' => ''],
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
     * 11 · CURRICULUM RECOMMENDATIONS (blank rows — docx)
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
     * 12 · WHY RGU
     * ───────────────────────────────────────────────────────── */
    'why_rgu' => [
        'headline' => 'Why RGU for B.Com Professional Accounting?',
        'body' => 'The B.Com Professional Accounting programme at Rathinam Global University blends a rigorous commerce core with a CA-aligned curriculum, industry-driven electives, and hands-on labs in Computerized Accounting, Financial Modelling with Excel, IFRS-AI Reporting and SPSS-based data analysis. With institutional training every semester and a capstone project + placement support, graduates step into the profession as CA-ready professionals or as candidates for M.Com, MBA and specialised finance programmes.',
        'stats' => [
            ['value' => '6',    'label' => 'Semesters'],
            ['value' => '132+', 'label' => 'Total Credits'],
            ['value' => '40+',  'label' => 'Industry Partners'],
            ['value' => '100%', 'label' => 'Placement Support'],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 13 · CAREER PATHWAYS
     * ───────────────────────────────────────────────────────── */
    'careers' => [
        'roles' => [
            'Chartered Accountant',
            'Auditor / Internal Auditor',
            'Tax Consultant',
            'Financial Analyst',
            'Cost & Management Accountant',
            'Banking & Financial Services Officer',
            'Corporate Finance Executive',
            'Accounts Manager',
            'Investment Analyst',
            'Entrepreneur / Practitioner',
        ],
        'higher_studies' => [
            'M.Com Professional Accounting',
            'MBA (Finance)',
            'CA · CMA · CS',
            'ACCA · CPA',
            'M.Com (International Business)',
        ],
        'image' => 'https://images.unsplash.com/photo-1554224155-1696413565d3?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     * 14 · DETAILED COURSE TEMPLATE (blank for faculty)
     * ───────────────────────────────────────────────────────── */
    'course_template' => [
        'details' => [
            ['field' => 'Course Name',  'value' => ''],
            ['field' => 'Course Code',  'value' => ''],
            ['field' => 'Program',      'value' => 'B.Com PA & B.Com PA with Chartered Accountant'],
            ['field' => 'Semester',     'value' => ''],
            ['field' => 'Credits',      'value' => ''],
            ['field' => 'Campus',       'value' => 'Rathinam Global Deemed To Be University'],
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
        'assets/images/life/01.webp',
        'assets/images/life/03.webp',
        'assets/images/life/05.webp',
        'assets/images/life/07.webp',
        'assets/images/life/09.webp',
        'assets/images/life/11.webp',
        'assets/images/life/13.webp',
        'assets/images/life/15.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     * 16.b · FACILITIES CAROUSEL (business / commerce themed)
     * ───────────────────────────────────────────────────────── */
    'facilities_carousel' => [
        ['img' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Computerized Accounting Lab'],
        ['img' => 'https://images.unsplash.com/photo-1543286386-713bdd548da4?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Financial Modelling & Excel Studio'],
        ['img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Data Analytics (SPSS) Lab'],
        ['img' => 'https://images.unsplash.com/photo-1554224154-26032cdc0f2f?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Trading Simulation Room'],
        ['img' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Smart Classroom · 4K Interactive'],
        ['img' => 'https://images.unsplash.com/photo-1497215842964-222b430dc094?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'CA Coaching Centre'],
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
            'head' => '',
            'phone' => '',
            'email' => '',
        ],
    ],

    /* Image alt text used by the page template. */
    'image_alts' => [
        'overview' => 'B.Com Professional Accounting students learning in a business-focused classroom at Rathinam Global University',
        'rgu_distinct' => 'Rathinam Global University learning environment for commerce students',
        'careers' => 'Career growth opportunities for B.Com Professional Accounting students',
        'gallery' => 'Campus gallery image for B.Com Professional Accounting at Rathinam Global University',
    ],
];
