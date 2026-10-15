<?php

/**
 * Directorate of Research — Dr. S. Balasubramanian (Director, Ph.D Programmes).
 * Values may contain HTML entities.
 */
return [

    /* [value, label, lucide icon] */
    'stats' => [
        ['13', 'Total publications', 'file-text'],
        ['40', 'Cumulative impact factor', 'flame'],
        ['685', 'Total citations', 'quote'],
        ['9', 'h-index', 'trending-up'],
        ['9', 'i10-index', 'bar-chart-3'],
    ],

    /* Each row: [type, number, funding agencies, amount (₹)] */
    'grant_tables' => [
        [
            'title' => 'Grants Summary — As Principal',
            'rows' => [
                ['Workshops / Seminars / Conferences', '15', 'ICSSR, TNSCST, ICPR, AICTE, CCT, BIS, MoIB-GoI', '15,36,000'],
                ['Start-up (Student)', '1', 'MSME', '11,50,000'],
                ['Research Projects (Student)', '7', 'TNSCST', '52,500'],
                ['DBT-Star College Scheme (2024–27)', '1', 'DBT', '1,61,00,000'],
                ['Ph.D. Scholars – Fellowship', '1', 'TN-ADWD', '2,00,000'],
            ],
            'total' => '1,90,38,500',
        ],
        [
            'title' => 'Grants Summary — As Dean R&amp;D (Dr. N.G.P. Arts and Science College)',
            'rows' => [
                ['Workshops / Seminars / Conferences', '17', 'SERB, ICSSR, ICMR, TNSCST, CSIR, DBT, ICPR, NHRC', '12,63,000'],
                ['Research Projects (Faculty)', '9', 'ICSSR', '32,89,350'],
                ['Research Projects (Students)', '17', 'TNSCST', '1,27,500'],
                ['DBT-Star College Scheme (2018–26)', '1', 'DBT', '2,65,00,000'],
                ['Ph.D. Scholars – UGC Fellowship', '5', 'UGC', '75,00,000'],
                ['Ph.D. Scholars – State Fellowship', '3', 'TN-ADWD', '6,00,000'],
                ['INSPIRE Internship Science Camp', '1', 'DST', '11,00,000'],
            ],
            'total' => '4,03,79,850',
        ],
    ],

    /* [count, label] */
    'guidance' => [['04', 'Enrolled for Ph.D.'], ['03', 'Pursuing Ph.D.'], ['01', 'Completed Ph.D.']],

    /* [degree, branch, university, year] */
    'qualifications' => [
        ['Ph.D.', 'Cell Biology', 'University of Basel, Switzerland', '2008'],
        ['M.Sc.', 'Biochemistry', 'University of Madras, Chennai', '1999'],
        ['B.Sc.', 'Biochemistry', 'University of Madras, Chennai', '1997'],
    ],

    /* [award, agency, years] */
    'awards' => [
        ['Postdoctoral Fellowship', 'Department of Atomic Energy, USA', '2011–2014'],
        ['Postdoctoral Fellowship', 'Swiss National Science Foundation', '2009–2011'],
        ['Ph.D. Scholarship', 'Swiss National Science Foundation', '2005–2008'],
        ['Ph.D. Scholarship', 'Swiss Neuroscience Society', '2003–2005'],
    ],

    'as_principal' => [
        'Deemed-to-be University (DTBU) – Application &amp; Committee Visit',
        'Autonomous Status (Extension)',
        'DBT-Star College Scheme (2024–27)',
        'Institution&rsquo;s Innovation Council (IIC): 4.0/5.0 Stars (2023 &amp; 2024)',
        'ERP &amp; LMS Implementation',
        'Industry-embedded &amp; immersed degree programmes',
        'Government &amp; private rankings and recognitions',
        'Hackathons and student start-ups',
    ],

    'as_dean' => [
        'DBT-Star College Status',
        'NAAC A++ (3.64 CGPA / 4.0; 3rd Cycle)',
        'Institution&rsquo;s Innovation Council (IIC): 3.5/5.0 (2021) &amp; 3.0/5.0 (2020)',
        'Annual Research &amp; Innovation Day (2019–2022)',
        'UGC-NSQF &amp; DSIR Certification',
        'DST-FIST &amp; R&amp;D Policy',
    ],

    /* [count, label] */
    'dean_outcomes' => [['159', 'Ph.D. Admissions'], ['56', 'Ph.D. Completed'], ['708', 'Publications']],

];
