<?php

return [

    'hero_slides' => [
        [
            'eyebrow' => 'School of',
            'h_pre' => 'Best ',
            'h_mark' => 'Quantum, Computing &amp; AI',
            'h_post' => 'School in Coimbatore, India',
            'p' => 'Rathinam Global University is renowned for outcome-based programmes, world-class AI labs, and rewarding placement opportunities with global tech giants.',
            'pkg1' => '1.7 CR',  'pkg1_l' => 'Highest Package',
            'pkg2' => '100%',    'pkg2_l' => 'Placement Support',
        ],
        [
            'eyebrow' => 'Top Ranked',
            'h_pre' => 'Ranked ',
            'h_mark' => "Among India's Top",
            'h_post' => 'AI &amp; Computing Schools',
            'p' => 'NBA-aligned, NAAC A++ accredited and globally recognised — programmes co-designed with IBM, AWS, Microsoft and Google Cloud.',
            'pkg1' => '31st',    'pkg1_l' => 'NIRF Rank · Tech',
            'pkg2' => 'A++',     'pkg2_l' => 'NAAC Accredited',
        ],
        [
            'eyebrow' => 'Industry Edge',
            'h_pre' => 'Learn from ',
            'h_mark' => 'Industry &amp; Research',
            'h_post' => 'Leaders Worldwide',
            'p' => '40% of the curriculum is delivered by industry experts. A mandatory internship, capstone projects and hands-on labs keep you industry-ready from day one.',
            'pkg1' => '40%',     'pkg1_l' => 'Industry Curriculum',
            'pkg2' => '45-Day',  'pkg2_l' => 'Mandatory Internship',
        ],
        [
            'eyebrow' => 'Global Exposure',
            'h_pre' => 'Study with ',
            'h_mark' => '65+ Countries',
            'h_post' => 'Under One Campus',
            'p' => 'Partnerships with 100+ universities across 60+ countries — semester exchanges, transfer programmes and international research internships.',
            'pkg1' => '100+',    'pkg1_l' => 'Global Partners',
            'pkg2' => '60+',     'pkg2_l' => 'Countries',
        ],
    ],

    'recruiters' => ['Google', 'Microsoft', 'Amazon', 'IBM', 'Dell', 'Infosys', 'TCS', 'Wipro', 'Accenture', 'Cognizant', 'Capgemini', 'HCL'],

    'edge' => [
        ['t' => 'NBA-Aligned AI Programmes',        'd' => 'NBA-coded curriculum for management of programmes ensuring quality, standards, academic excellence and national recognition.'],
        ['t' => 'Specialised AI Flagship Tracks',   'd' => 'AI Flagship programmes with a distinctive dual specialisation edge, offering the flexibility to choose specialisations in areas like ML, NLP, Computer Vision, and Generative AI.'],
        ['t' => 'Industry-Focused Specialisations', 'd' => 'Programmes enable development of industry-ready expertise with specialisations in AI, Cyber Security, Data Engineering, Cloud and more.'],
        ['t' => 'Curriculum Delivery by Industry Experts', 'd' => '40% of masterclasses and curriculum delivered by industry experts to provide direct exposure to real-world technology insights.'],
        ['t' => 'Global Partnerships with IBM / AWS / MS', 'd' => 'Collaborations with global giants such as IBM, AWS, Microsoft, and Google Cloud provide opportunities to learn from corporate leaders and participate in workshops and strategic forums.'],
        ['t' => '40% Applied Learning',             'd' => 'Hands-on exposure through lab work, live projects, capstone projects, internships, case studies and business simulations ensure preparation for dynamic industry environments.'],
        ['t' => 'Mandatory Internships for Holistic Exposure', 'd' => 'A 45-day social internship along with a separate industry internship provides professional competence and holistic exposure.'],
        ['t' => 'Globally Recognised Certifications', 'd' => 'Opportunities to earn industry certifications and value-added courses in AI, Data Science, Cloud, and Cyber Security throughout the degree.'],
        ['t' => 'Industry Case-Based Pedagogy', 'd' => 'Immersive learning across 95+ disciplines with case study chapters from leading global publishers and tech industry leaders.'],
        ['t' => 'Advanced Infrastructure for AI Practice', 'd' => 'Quantum lab, GPU clusters, IoT smart lab, Centre of Excellence — innovation hub provides hands-on experience with professional tools.'],
        ['t' => 'Startup Incubator with Seed Funding', 'd' => 'The Technology Business Incubator supports student-led startups, providing seed funding and access to industry networks to foster entrepreneurial initiatives.'],
        ['t' => '100+ University Partnerships in 60+ Countries', 'd' => 'Partnerships with top international universities across 60+ countries provide students global exposure, internship opportunities, international internships, student-exchange and more, building a cross-cultural mindset.'],
    ],

    /* Course name => programme page slug (courses/programmes/school-of-quantum-science/{slug}). */
    'program_links' => [
        'B.Sc Computer Science' => 'b.sc-computer-science',
    ],

    'groups' => [
        'bsc' => [
            'label' => 'B.Sc Programmes',
            'icon' => 'graduation-cap',
            'color' => 'text-purple-600',
            'courses' => [
                'B.Sc Artificial Intelligence and Machine Learning',
                'B.Sc Computer Science',
                'B.Sc Computer Science (AI &amp; Data Science)',
                'B.Sc Computer Science (Artificial Intelligence)',
                'B.Sc Computer Science (Cyber Security)',
                'B.Sc Computer Technology (Generative AI)',
                'B.Sc Digital and Cyber Forensics Science',
                'B.Sc Information Technology',
            ],
        ],
        'bca' => [
            'label' => 'BCA Programmes',
            'icon' => 'code-2',
            'color' => 'text-violet-600',
            'courses' => [
                'BCA',
                'BCA (Artificial Intelligence)',
            ],
        ],
        'pg' => [
            'label' => 'Postgraduate Programmes',
            'icon' => 'book-open',
            'color' => 'text-sky-600',
            'courses' => [
                'M.Sc Artificial Intelligence and Data Science',
                'M.Sc Computer Science',
                'M.Sc Data Science and Business Analytics',
            ],
        ],
    ],

    'skills' => [
        ['icon' => 'cpu',      'title' => 'Artificial Intelligence', 'desc' => 'Deep learning, neural networks, NLP, computer vision, and intelligent system design.',       'bg' => 'bg-purple-50',  'ibg' => 'bg-purple-100',  'ic' => 'text-purple-700'],
        ['icon' => 'database', 'title' => 'Data Science',            'desc' => 'Statistical modelling, big data analytics, data visualisation, and business intelligence.', 'bg' => 'bg-violet-50',  'ibg' => 'bg-violet-100',  'ic' => 'text-violet-700'],
        ['icon' => 'shield',   'title' => 'Cyber Security',          'desc' => 'Ethical hacking, digital forensics, penetration testing, and network security frameworks.', 'bg' => 'bg-blue-50',    'ibg' => 'bg-blue-100',    'ic' => 'text-blue-700'],
        ['icon' => 'code-2',   'title' => 'Software Engineering',    'desc' => 'Full-stack development, cloud-native architecture, DevOps pipelines, and agile practices.',  'bg' => 'bg-indigo-50',  'ibg' => 'bg-indigo-100',  'ic' => 'text-indigo-700'],
        ['icon' => 'zap',      'title' => 'Machine Learning',        'desc' => 'Supervised &amp; unsupervised learning, model training, evaluation, and MLOps pipelines.',  'bg' => 'bg-sky-50',     'ibg' => 'bg-sky-100',     'ic' => 'text-sky-700'],
        ['icon' => 'sparkles', 'title' => 'Generative AI',           'desc' => 'LLMs, prompt engineering, RAG systems, AI product development, and fine-tuning workflows.', 'bg' => 'bg-fuchsia-50', 'ibg' => 'bg-fuchsia-100', 'ic' => 'text-fuchsia-700'],
    ],

    'faculty' => [
        ['name' => '[Faculty Name 1]', 'role' => 'Professor &middot; School of Quantum, Computing &amp; AI', 'stat' => '45+ Articles'],
        ['name' => '[Faculty Name 2]', 'role' => 'Associate Professor &middot; AI &amp; Data Science', 'stat' => '240+ Research Articles'],
        ['name' => '[Faculty Name 3]', 'role' => 'Associate Professor &middot; Cyber Security', 'stat' => '70+ Research Publications'],
        ['name' => '[Faculty Name 4]', 'role' => 'Assistant Professor &middot; Machine Learning', 'stat' => '40+ Research Publications'],
    ],

    'intl' => [
        ['t' => 'International Transfer Program',      'd' => 'Experience cultural diversity with students from 65+ countries, all 28 Indian states, and 8 Union territories.', 'img' => 'assets/images/life/05.jpg'],
        ['t' => 'Semester Exchange Program',           'd' => 'Spend a semester at one of our 100+ partner universities across 60+ countries and earn credits that count toward your RGU degree.', 'img' => 'assets/images/life/06.jpg'],
        ['t' => 'Executive Leadership Program',        'd' => 'Industry-immersive leadership program crafted with global business leaders for executives and high-potential graduates.', 'img' => 'assets/images/life/07.jpg'],
        ['t' => 'Project Semester Program',            'd' => 'Work on a full semester-long live project with an international partner organisation as part of your degree.', 'img' => 'assets/images/life/08.jpg'],
        ['t' => 'International Research Internship',   'd' => 'Pursue research internships at globally ranked institutions and CoE labs with mentor-guided publishing opportunities.', 'img' => 'assets/images/life/09.jpg'],
    ],

    'voices' => [
        ['q' => '[Industry quote — please supply]', 'n' => '[Name]', 'r' => '[Designation, Company]'],
        ['q' => '[Industry quote — please supply]', 'n' => '[Name]', 'r' => '[Designation, Company]'],
        ['q' => '[Industry quote — please supply]', 'n' => '[Name]', 'r' => '[Designation, Company]'],
        ['q' => '[Industry quote — please supply]', 'n' => '[Name]', 'r' => '[Designation, Company]'],
    ],

    'labs' => [
        ['t' => 'Quantum Computing Centre of Excellence', 'img' => 'assets/images/life/06.jpg'],
        ['t' => 'AI &amp; Generative AI Lab',              'img' => 'assets/images/life/07.jpg'],
        ['t' => 'Cyber Forensics &amp; Security Lab',      'img' => 'assets/images/life/08.jpg'],
    ],

    'stories' => [
        ['q' => '[Entrepreneur testimonial — please supply]', 'n' => '[Founder Name]', 'c' => '[Company]'],
        ['q' => '[Entrepreneur testimonial — please supply]', 'n' => '[Founder Name]', 'c' => '[Company]'],
    ],

    'careers' => [
        ['role' => 'AI / ML Engineer',         'companies' => 'Google &middot; OpenAI &middot; Meta',       'emoji' => '&#x1F916;'],
        ['role' => 'Data Scientist',            'companies' => 'Amazon &middot; Microsoft &middot; IBM',     'emoji' => '&#x1F4CA;'],
        ['role' => 'Cyber Security Analyst',    'companies' => 'CERT-In &middot; Deloitte &middot; KPMG',    'emoji' => '&#x1F512;'],
        ['role' => 'Full Stack Developer',      'companies' => 'Infosys &middot; TCS &middot; Zoho',         'emoji' => '&#x1F4BB;'],
        ['role' => 'Cloud Architect',           'companies' => 'AWS &middot; Azure &middot; GCP',            'emoji' => '&#x2601;&#xFE0F;'],
        ['role' => 'Research Scientist',        'companies' => 'IISc &middot; IIT Labs &middot; ISRO',       'emoji' => '&#x1F52C;'],
        ['role' => 'Product Manager',           'companies' => 'Startups &middot; MNCs &middot; SaaS',       'emoji' => '&#x1F680;'],
        ['role' => 'Digital Forensics Expert',  'companies' => 'Law Enforcement &middot; Banks',             'emoji' => '&#x1F575;&#xFE0F;'],
    ],

    'students' => [
        ['q' => '[Student testimonial — please supply]', 'n' => '[Student Name]', 'r' => '[Programme, Year]'],
        ['q' => '[Student testimonial — please supply]', 'n' => '[Student Name]', 'r' => '[Programme, Year]'],
    ],

    'apply_steps' => [
        [
            'n' => 'Signup',
            'h' => 'Step 1 — Signup',
            'img' => 'assets/images/life/03.jpg',
            'd' => 'Sign up or register for the RGU Common Entrance Test with basic details (Name, Email ID, Mobile No., State, Gender and Password). Your Email ID will act as your Username for the portal which the password will be set by you upon registration. On successful registration, you will receive a confirmation message on your registered contact number and email.',
        ],
        [
            'n' => 'Apply for RGU Test',
            'h' => 'Step 2 — Apply for RGU Test',
            'img' => 'assets/images/life/09.jpg',
            'd' => 'After successfully creating your candidate profile for the RGU Common Entrance Test, you can proceed with choosing the Date for your examination. Following your attempt at the RGU Test, you may shortly be intimated about the merit basis on which you can submit your application for admission and avail merit-based scholarship.',
        ],
        [
            'n' => 'Admission',
            'h' => 'Step 3 — Admission',
            'img' => 'assets/images/life/10.jpg',
            'd' => 'You become eligible for admission into Rathinam Global University after clearing the RGU Common Entrance Test examination. Following your attempt at the RGU Test, you will shortly be intimated based on which you can submit your application for admission and avail merit-based scholarship.',
        ],
    ],

];
