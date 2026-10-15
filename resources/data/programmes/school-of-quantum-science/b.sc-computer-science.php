<?php

/**
 * Centralised program data — B.Sc Computer Science
 * --------------------------------------------------------------
 * This file is the SINGLE source of truth for everything shown on
 * the program landing page. The UI template (../b.sc-computer-science.php)
 * pulls every label, list, table and section from this array.
 *
 *  - Empty strings / arrays are KEPT as-is (faculty will fill later).
 *  - Same shape will be reused for the other 89 program LPs — just
 *    copy this file, rename, and swap the values.
 *  - Keep this file PURE DATA — no HTML, no styling, no logic.
 */

return [

    /* ─────────────────────────────────────────────────────────
     *  1 · BASIC IDENTITY
     * ───────────────────────────────────────────────────────── */
    'meta' => [
        'department_name' => 'B.Sc Computer Science',
        'program_name' => '',                                       // (blank — faculty)
        'school' => 'School of Quantum Science, Computing & AI',
        'campus' => 'Rathinam Global Deemed To Be University',
        'academic_year' => '2026-27',
        'prepared_by' => '',                                       // (blank — faculty)
        'duration_label' => '3 Years · 6 Semesters · Full Time',
        'mode' => 'Full Time',
        'level' => 'Under-Graduate',
        'school_slug' => 'school-of-quantum-science',
        'program_slug' => 'b.sc-computer-science',
        'apply_url' => 'https://admissions.rathinamcollege.edu.in/?utm_source=program-lp&utm_medium=apply-cta&utm_campaign=bsc-cs',
        'brochure_url' => '#',                                      // (replace when uploaded)
        'curriculum_pdf' => '#',
        'prospectus_pdf' => '#',
    ],

    /* ─────────────────────────────────────────────────────────
     *  2 · HERO  (top banner)
     * ───────────────────────────────────────────────────────── */
    'hero' => [
        'eyebrow' => 'School of Quantum Science, Computing & AI',
        'title' => 'B.Sc Computer Science',
        'subtitle' => 'Bachelor of Science in Computer Science with AI, Generative AI, LLMOps & Cloud',
        'tagline' => 'Bridge Fundamental Computing with Futuristic Technology',
        // Hero — students with laptops in the CS study room (drop the file at
        // assets/images/programs/bsc-cs-hero.jpg; the URL below resolves from the LP path)
        'image' => 'courses/programmes/school-of-quantum-science/herosection_bsc_cs.webp',
    ],

    /* ─────────────────────────────────────────────────────────
     *  3 · OVERVIEW  (Section 1 of docx)
     * ───────────────────────────────────────────────────────── */
    'overview' => [
        'headline' => 'Bridge Fundamental Computing with Futuristic Technology',
        'paragraphs' => [
            'Bachelor of Science (B.Sc.) in Computer Science is an undergraduate degree program that focuses on the study of computers, software development, programming, data structures, databases, networking, artificial intelligence, and emerging technologies. The program equips students with strong theoretical foundations and hands-on practical skills required to design, develop, and implement modern computing solutions.',
            'The department aims to prepare students for careers in the IT industry, software development, data analytics, cybersecurity, and research while fostering problem-solving, innovation, and technical expertise in the field of computing.',
        ],
        // Overview — student writing code on laptop
        'image' => 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     *  4 · WHY CHOOSE THIS PROGRAM  (4 highlight cards)
     *  Sourced from PEO/PSO summary + RGU advantages.
     * ───────────────────────────────────────────────────────── */
    'why_choose' => [
        [
            'icon' => 'cpu',
            'title' => 'Strong Foundation in Core Computing',
            'color' => 'emerald',
            'points' => [
                'Programming & Algorithms',
                'Data Structures',
                'Database Management',
                'Computer Networks',
                'Software Engineering',
            ],
            'note' => 'A rigorous core gives every graduate solid analytical confidence and clarity.',
        ],
        [
            'icon' => 'sparkles',
            'title' => 'AI, Generative AI & LLMOps Specialisation',
            'color' => 'indigo',
            'points' => [
                'Machine Learning',
                'Deep Learning · NLP · CV',
                'Generative AI in Python',
                'LLMOps & RAG',
                'Agentic AI Immersion',
            ],
            'note' => 'Hands-on with the technologies driving the next generation of products.',
        ],
        [
            'icon' => 'flask-conical',
            'title' => 'Hands-On Learning & Lab Exposure',
            'color' => 'amber',
            'points' => [
                'Lab-backed every semester',
                'ITR — Industry Tutored Research',
                'Mini-projects each year',
                '1-month Internship in S8',
                'NASA-aligned EXT modules',
            ],
            'note' => 'Students build strong analytical skills, precision, and shipping habits.',
        ],
        [
            'icon' => 'graduation-cap',
            'title' => 'Research & Higher Studies Orientation',
            'color' => 'rose',
            'points' => [
                'Mathematical Reasoning',
                'Experimental Methods',
                'Capstone Project',
                'M.Sc · MCA · MBA pathways',
                'Research publication support',
            ],
            'note' => 'Graduates are equally prepared for industry and post-graduate study.',
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     *  5 · WHAT MAKES RGU DISTINCT (bullet block)
     * ───────────────────────────────────────────────────────── */
    'rgu_distinct' => [
        // What Makes RGU Distinct — students collaborating
        'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1400&h=900&q=80',
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
     *  6 · ADMISSION & ELIGIBILITY  (Section 3 of docx)
     * ───────────────────────────────────────────────────────── */
    'eligibility' => [
        ['field' => 'Educational Qualification',                     'value' => '12th Pass'],
        ['field' => 'Rathinam Qualification',                        'value' => ''],   // (blank)
        ['field' => 'Minimum Marks Required in 10th Standard',       'value' => ''],   // (blank)
        ['field' => 'Minimum Marks Required in 12th Standard',       'value' => ''],   // (blank)
        ['field' => 'Additional Eligibility / Admission Notes',      'value' => ''],   // (blank)
    ],

    /* ─────────────────────────────────────────────────────────
     *  7 · FEE STRUCTURE  (Section 5 of docx) — blank accordion
     * ───────────────────────────────────────────────────────── */
    'fees' => [
        ['heading' => 'Tuition Fees',                       'body' => ''],
        ['heading' => 'Hostel Fee Structure (new admissions)', 'body' => ''],
        ['heading' => 'Other Fees',                         'body' => ''],
    ],

    /* ─────────────────────────────────────────────────────────
     *  8 · FACILITIES (Section 6 of docx) — blank for now
     * ───────────────────────────────────────────────────────── */
    'facilities' => [
        // Faculty will supply: laboratories, software, equipment,
        // classrooms, learning resources, etc.
        // Example shape:
        // ['name' => 'AI & GenAI Lab', 'desc' => '60-seat NVIDIA GPU cluster…'],
    ],

    /* ─────────────────────────────────────────────────────────
     *  9 · CURRICULUM  —  Section 2 of docx
     *  One semester per tab, list of courses, total credits/hours.
     *  Fields kept exactly as in docx (CAT and LTPC blank where docx blank).
     * ───────────────────────────────────────────────────────── */
    'curriculum' => [
        [
            'sem' => 'Semester 1',
            'total_hours' => '375',
            'total_credits' => '23',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Language - I',                                              'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'English - I',                                               'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Problem solving techniques in Python Programming',          'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Fundamentals of computer Hardware and Networking',          'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Database Management Systems',                               'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Mathematics for Computer Science',                          'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Problem solving techniques in Python Programming Lab',      'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'ITR - 1',                                                   'ltpc' => '', 'credit' => '01', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'AEC - I',                                                   'ltpc' => '', 'credit' => '02', 'eval' => ''],
            ],
        ],
        [
            'sem' => 'Semester 2',
            'total_hours' => '435',
            'total_credits' => '26',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Language – II',                                             'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'English – II',                                              'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Object-Oriented Programming in Python',                     'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Data Handling and Preprocessing Technique',                 'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'DSA Problem Solving Practice',                              'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Discrete Mathematics',                                      'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Object-Oriented Programming in Python Lab',                 'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'ITR – 2',                                                   'ltpc' => '', 'credit' => '01', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'AEC II',                                                    'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'VAC 1',                                                     'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'EXT 1 (NASA)',                                              'ltpc' => '', 'credit' => '01', 'eval' => ''],
            ],
        ],
        [
            'sem' => 'Semester 3',
            'total_hours' => '435',
            'total_credits' => '27',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Language - III',                                            'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'English – III',                                             'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Machine Learning',                                          'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Web Application Development',                               'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Distributed Computing',                                     'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'FullStack with GenAI',                                      'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Machine Learning Lab',                                      'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'ITR-3',                                                     'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Agentic AI Immersion',                                      'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'AEC III',                                                   'ltpc' => '', 'credit' => '02', 'eval' => ''],
            ],
        ],
        [
            'sem' => 'Semester 4',
            'total_hours' => '495',
            'total_credits' => '30',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Language – IV',                                             'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'English – IV',                                              'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Deep Learning with NLP and Computer Vision',                'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Software Engineering',                                      'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Generative AI using Python',                                'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Deep Learning with NLP and Computer Vision Lab',            'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Full Stack for DevOps',                                     'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'ITR-4',                                                     'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Cloud Computing and Networks',                              'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'AEC IV',                                                    'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'VAC 2',                                                     'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'EXT- 2 (NASA)',                                             'ltpc' => '', 'credit' => '01', 'eval' => ''],
            ],
        ],
        [
            'sem' => 'Semester 5',
            'total_hours' => '330',
            'total_credits' => '17',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Data Analytics and Business Intelligence',                  'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Generative AI and Prompt Engineering',                      'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'AI Application Development and Deployment',                 'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Generative AI using Python Lab',                            'ltpc' => '', 'credit' => '02', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'PRJ',                                                       'ltpc' => '', 'credit' => '04', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'ITR-5',                                                     'ltpc' => '', 'credit' => '02', 'eval' => ''],
            ],
        ],
        [
            'sem' => 'Semester 6',
            'total_hours' => '300',
            'total_credits' => '15',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'LLMOps and Retrieval Augmented Generation (RAG)',           'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Software Testing and Quality Assurance',                    'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'AI Product Development and Deployment',                     'ltpc' => '', 'credit' => '03', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'PRJ',                                                       'ltpc' => '', 'credit' => '04', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'VAC 3',                                                     'ltpc' => '', 'credit' => '02', 'eval' => ''],
            ],
        ],

        [
            'sem' => 'Project & Internship Semester',
            'total_hours' => '600',
            'total_credits' => '40',
            'courses' => [
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'PRJ',                       'ltpc' => '', 'credit' => '12', 'eval' => ''],
                ['cat' => '', 'code' => 'CXXXX', 'title' => 'Internship (1 month)',      'ltpc' => '', 'credit' => '04', 'eval' => ''],
            ],
        ],
        [
            'sem' => 'Elective Bucket',
            'total_hours' => '',
            'total_credits' => '',
            'courses' => [
                // Faculty will fill 8 electives — keep visible blank rows.
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
                ['cat' => '', 'code' => '', 'title' => '', 'ltpc' => '', 'credit' => '', 'eval' => ''],
            ],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 10 · PROGRAM OUTCOMES — PEO / PSO / PO  (Section 4)
     * ───────────────────────────────────────────────────────── */
    'outcomes' => [
        'peo' => [
            ['no' => 'PEO1', 'title' => 'Strong Foundations',           'desc' => 'Develop strong foundations in computer science, programming, databases, networking, artificial intelligence, and emerging technologies to solve real-world problems effectively.'],
            ['no' => 'PEO2', 'title' => 'Practical Skills',             'desc' => 'Equip students with practical skills in software development, machine learning, cloud computing, Generative AI, and data analytics to meet industry requirements.'],
            ['no' => 'PEO3', 'title' => 'Innovation & Ethics',          'desc' => 'Foster innovation, critical thinking, ethical responsibility, teamwork, and lifelong learning for professional growth and research excellence.'],
            ['no' => 'PEO4', 'title' => 'Career & Higher Studies',      'desc' => 'Prepare graduates for successful careers, entrepreneurship, higher education, and research in computing and emerging technology domains.'],
        ],
        'pso' => [
            ['no' => 'PSO1', 'title' => 'Computing Solutions',          'desc' => 'Apply programming, algorithms, databases, and software engineering principles to develop efficient computing solutions.'],
            ['no' => 'PSO2', 'title' => 'Intelligent Systems',          'desc' => 'Design and implement intelligent systems using Machine Learning, Deep Learning, Generative AI, LLMOps, and Data Analytics technologies.'],
            ['no' => 'PSO3', 'title' => 'Scalable Applications',        'desc' => 'Utilize modern computing tools, cloud platforms, full-stack technologies, and industry practices to develop scalable applications and products.'],
        ],
        'po' => [
            ['no' => 'PO1', 'title' => 'Course Knowledge',                          'desc' => 'Apply knowledge of computer science fundamentals, mathematics, and emerging technologies.'],
            ['no' => 'PO2', 'title' => 'Problem Analysis',                          'desc' => 'Identify, analyze, and solve complex computing problems using logical and analytical approaches.'],
            ['no' => 'PO3', 'title' => 'Design and Development of Solutions',       'desc' => 'Design software systems and applications that meet user and industry requirements.'],
            ['no' => 'PO4', 'title' => 'Conduct Investigations of Complex Problems', 'desc' => 'Conduct experiments, analyze data, and derive meaningful conclusions.'],
            ['no' => 'PO5', 'title' => 'Modern Tool Usage',                         'desc' => 'Use modern software development tools, AI frameworks, cloud platforms, and computing technologies.'],
            ['no' => 'PO6', 'title' => 'The Engineer and Society',                  'desc' => 'Apply ethical principles and professional responsibilities in computing practices.'],
            ['no' => 'PO7', 'title' => 'Environment and Sustainability',            'desc' => 'Understand the impact of computing solutions on society and sustainable development.'],
            ['no' => 'PO8', 'title' => 'Ethics',                                    'desc' => 'Apply ethical principles, professional responsibilities, integrity, and legal standards in the development and use of computing technologies, Artificial Intelligence, data management, and digital systems while considering societal impact and sustainability.'],
            ['no' => 'PO9', 'title' => 'Individual and Team Work',                  'desc' => 'Function effectively as an individual and as a member or leader of multidisciplinary teams.'],
            ['no' => 'PO10', 'title' => 'Communication',                             'desc' => 'Communicate effectively with technical and non-technical stakeholders.'],
            ['no' => 'PO11', 'title' => 'Project Management and Finance',            'desc' => 'Apply project management principles in software and technology projects.'],
            ['no' => 'PO12', 'title' => 'Life-long Learning',                        'desc' => 'Recognize the need for continuous learning and adaptation to emerging technologies.'],
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
     * 12 · WHY RGU  (Section 7)
     * ───────────────────────────────────────────────────────── */
    'why_rgu' => [
        'headline' => 'Why RGU for B.Sc Computer Science?',
        'body' => 'The B.Sc. Computer Science program at Rathinam Global University offers a future-focused curriculum that integrates core computer science concepts with emerging technologies such as Artificial Intelligence, Machine Learning, Deep Learning, Generative AI, LLMOps, Cloud Computing, Data Analytics, and Full-Stack development. Students benefit from industry-co-designed modules, NASA-aligned EXT exposure, mandatory ITR research blocks every semester, and a final capstone project + internship, ensuring placement readiness in software, AI, and product engineering roles.',
        'stats' => [
            ['value' => '6',    'label' => 'Semesters'],
            ['value' => '218+', 'label' => 'Total Credits'],
            ['value' => '40+',  'label' => 'Industry Partners'],
            ['value' => '100%', 'label' => 'Placement Support'],
        ],
    ],

    /* ─────────────────────────────────────────────────────────
     * 13 · CAREER PATHWAYS  (Amrita-style bullets)
     * ───────────────────────────────────────────────────────── */
    'careers' => [
        'roles' => [
            'Software Developer',
            'AI / ML Engineer',
            'Generative AI Engineer',
            'Data Scientist · Data Analyst',
            'Full-Stack Developer',
            'Cloud Engineer / DevOps',
            'Cyber Security Analyst',
            'Mobile App Developer',
            'Research Associate',
            'Academic Instructor',
        ],
        'higher_studies' => [
            'M.Sc Computer Science',
            'M.Sc AI & Data Science',
            'MCA',
            'M.Tech (lateral)',
            'MBA (Technology Management)',
        ],
        // Careers — software engineer at workstation
        'image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=1400&h=900&q=80',
    ],

    /* ─────────────────────────────────────────────────────────
     * 14 · DETAILED COURSE TEMPLATE  (Section 2.1 — repeats per course)
     *  This is the per-course template referenced in the docx.
     *  Faculty will duplicate this for every course title later.
     *  We render ONE empty instance as a preview / placeholder.
     * ───────────────────────────────────────────────────────── */
    'course_template' => [
        'details' => [
            ['field' => 'Course Name',  'value' => ''],
            ['field' => 'Course Code',  'value' => ''],
            ['field' => 'Program',      'value' => 'B.Sc Computer Science'],
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
            // Columns: PO1..PO12, PSO1..PSO3.   Values: 1 / 2 / 3 / '' (blank)
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
        'textbooks' => '',   // (blank)
        'references' => '',   // (blank)
    ],

    /* ─────────────────────────────────────────────────────────
     * 15 · DOWNLOADS (the 3-card row from Amrita layout)
     * ───────────────────────────────────────────────────────── */
    'downloads' => [
        ['title' => 'Admission Handbook 2026', 'url' => '#'],
        ['title' => 'Curriculum 2026',         'url' => '#'],
        ['title' => 'Prospectus 2026',         'url' => '#'],
    ],

    /* ─────────────────────────────────────────────────────────
     * 16 · GALLERY (interactive image slider)
     * ───────────────────────────────────────────────────────── */
    // Campus / student-life images — pulled from assets/images/life/
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
     * 16.b · FACILITIES CAROUSEL (lab-themed moving slider)
     * ───────────────────────────────────────────────────────── */
    'facilities_carousel' => [
        ['img' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&h=800&q=80',  'label' => 'AI & Machine Learning Lab'],          // code on screen
        ['img' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=1200&h=800&q=80',  'label' => 'High-Performance Computing Centre'],  // server room
        ['img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&h=800&q=80',  'label' => 'Cyber Security Lab'],                 // cyber / hooded screen
        ['img' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&h=800&q=80',  'label' => 'Software Engineering Studio'],        // programmer at desk
        ['img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&h=800&q=80',  'label' => 'Data Analytics & BI Lab'],            // dashboards
        ['img' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Generative AI Studio'],              // AI / neural
        ['img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Quantum Computing Centre of Excellence'], // circuit board
        ['img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&h=800&q=80', 'label' => 'Smart Classroom · 4K Interactive'],  // classroom / notes
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
            'head' => '',          // (blank)
            'phone' => '',          // (blank)
            'email' => '',          // (blank)
        ],
    ],

    /* Image alt text used by the page template. */
    'image_alts' => [
        'overview' => 'B.Sc Computer Science students in a modern computing lab at Rathinam Global University',
        'rgu_distinct' => 'Rathinam Global University computing excellence and innovation ecosystem',
        'careers' => 'Career opportunities for B.Sc Computer Science graduates',
        'gallery' => 'Campus gallery image for B.Sc Computer Science at Rathinam Global University',
    ],
];
