<?php

/**
 * DSACB 2027 conference content.
 * Text is carried over verbatim from the original lp/index.html.
 */

return [

    'description' => 'DSACB 2027 — First Multidisciplinary International Conference on Driving Sustainability through AI, Climate Resilience and Behavioural Sciences. 15–16 February 2027, Rathinam Global University, Coimbatore.',

    /**
     * In-page nav. [label, section id] — every id must exist in index.php, since
     * the nav both scrolls to it and highlights it while it is on screen.
     */
    'nav' => [
        ['About',       'about'],
        ['Scope',       'scope'],
        ['Tracks',      'tracks'],
        ['Committee',   'committee'],
        ['Dates',       'dates'],
        ['Fees',        'registration'],
        ['Payment',     'payment'],
        ['Publication', 'publication'],
        ['Agenda',      'agenda'],
    ],

    'tracks' => [
        ['Track A — AI and Digital Transformation for Sustainability', 'violet', [
            'AI-driven models for climate prediction and environmental monitoring',
            'Machine learning for optimizing energy systems and smart grids',
            'Digital twins for sustainable urban planning',
            'AI in precision agriculture and sustainable food systems',
            'Big data analytics for carbon footprint tracking and ESG reporting',
            'Blockchain for transparent and sustainable supply chains',
            'Ethical AI and responsible innovation for sustainable development',
            'IoT and sensor networks for resource conservation',
            'AI-powered decision support systems for policy-making',
        ]],
        ['Track B — Climate Resilience and Adaptation', 'blue', [
            'Climate risk assessment and vulnerability mapping',
            'Disaster preparedness and early warning systems',
            'Nature-based solutions for climate adaptation',
            'Resilient infrastructure and urban design',
            'Water resource management under climate stress',
            'Coastal and ecosystem resilience strategies',
            'Community-based adaptation practices',
            'Climate migration and displacement challenges',
            'Agricultural resilience and climate-smart farming',
        ]],
        ['Track C — Behavioural Foundations for Sustainability', 'lime', [
            'Psychology of pro-environmental behaviour change',
            'Nudging strategies for sustainable consumption',
            'Cognitive biases in climate decision-making',
            'Social norms and collective action for sustainability',
            'Behavioural economics of green choices',
            'Motivation and habit formation for eco-friendly practices',
            'Role of emotions (eco-anxiety, hope) in climate engagement',
            'Cross-cultural perspectives on sustainable behaviour',
            'Organizational behaviour and workplace sustainability culture',
        ]],
        ['Track D — Health, Wellbeing, and Environmental Justice', 'teal', [
            'Mental health impacts of climate change and eco-anxiety',
            'Environmental determinants of physical health',
            'Equity and justice in climate policy and resource distribution',
            'Occupational health in vulnerable and informal sectors',
            'Air, water, and soil pollution and public health outcomes',
            'Health system resilience to climate-related disasters',
            'Indigenous and marginalized community health and environmental rights',
            'One Health approaches linking human, animal, and ecosystem wellbeing',
            'Urban green spaces and wellbeing',
        ]],
        ['Track E — Education, Capacity-Building, and Public Engagement', 'orange', [
            'Integrating sustainability into curricula (K-12 to higher education)',
            'Teacher training and capacity-building for climate education',
            'Community outreach and grassroots sustainability campaigns',
            'Science communication and public awareness strategies',
            'Youth leadership and student-led sustainability initiatives',
            'Indigenous knowledge systems in sustainability education',
            'Lifelong learning and professional upskilling for green careers',
            'Role of media and storytelling in shaping public perception',
            'University-industry-community partnerships for capacity-building',
        ]],
        ['Track F — Sustainable Business and Green Economy', 'pink', [
            'ESG (Environmental, Social, Governance) integration in corporate strategy',
            'Circular economy models and sustainable supply chains',
            'Green entrepreneurship and startup innovation',
            'Sustainable finance, green bonds, and impact investing',
            'Renewable energy transitions and business models',
            'Corporate social responsibility and stakeholder engagement',
            'Sustainable tourism and hospitality practices',
            'Green marketing and consumer behaviour',
            'Policy and regulatory frameworks for a green economy',
        ]],
    ],

    'scope' => [
        'The role of AI and emerging digital technologies in accelerating sustainable transformation across sectors',
        'Strategies for building climate resilience and adaptive capacity in vulnerable communities and ecosystems',
        'Behavioural and psychological foundations that drive (or hinder) sustainable action at individual, organizational, and societal levels',
        'The intersection of environmental change with public health, wellbeing, and environmental justice',
        'Innovative approaches to sustainability education, capacity-building, and public engagement',
        'Emerging models of sustainable business, green economy, and responsible enterprise',
    ],

    'committee' => [
        ['Chief Patrons', 'Dr. Madan A Senthil, Smt. Shima Senthil', 'violet'],
        ['Patrons', 'Dr. Manickam, Dr. Nagaraj', 'blue'],
        ['Co-Patrons', 'Dr. Krishnaraj', 'lime'],
        ['Organizing Chair', 'dept', 'teal'],
        ['General Chair', 'mani, arun, pradeep', 'orange'],
        ['International Advisory Committee', 'Dr.', 'pink'],
        ['National Advisory Committee', '', 'amber'],
    ],

    'dates' => [
        ['Full Paper Submission Date', '20th November 2026', false],
        ['Notification of Acceptance Date', '30th December 2026', false],
        ['Early Bird Registration Date', '10th January 2027', false],
        ['Late Bird Registration Date', '31st January 2027', false],
        ['Dates of Conference', '15th–16th February 2027', true],
    ],

    'fees' => [
        ['UG/PG Students / Research Scholars', '₹1500', ''],
        ['Academicians', '₹2000', ''],
        ['Industrialists', '₹2500', ''],
        ['Co-Author / Attendee', '₹500', ''],
    ],

    'publishers' => [
        ['Springer', '', 'No APC (No Open Access; conference proceedings only)', 'Yes — Scopus Indexed (LNCS/LNECS series)', '40–80 papers (Publisher selects best papers)', '6–8 months',
            '<span class="lp-hl">NO PUBLICATION CHARGE</span> for first-time conference contract. Springer publishes 40–80 selected papers. Agreement subject to quality review and approval.'],
        ['Taylor &amp; Francis', '(T&amp;F India — Open Access Division)', 'Open Access Available (see cost slabs)', 'Yes — Scopus Indexed', '50–80 papers (350–500 pages) OR 100–120 papers (600–750 pages)', '6–8 months',
            'Without OA: 3,500 OMR (350–500 pp) / 4,500 OMR (600–750 pp). With OA: USD 12,500 + GST per volume (~450–500 pp); 1,000 pages requires 2 volumes (~USD 25,000 + GST).'],
        ['E3S Web of Conferences', '(EDP Sciences)', 'Full Open Access (APC per paper)', 'Yes — Scopus &amp; Web of Science Indexed', '50–80 papers', '6–8 months',
            'Approx. APC: OMR 2,500 (total volume). Fully OA proceedings series for Environment, Energy &amp; Earth Sciences. Scopus eligibility check required before contract.'],
        ['ACM Digital Library', '', 'Hybrid / OA options available', 'Scopus Indexed (verify per event)', 'Subject to ACM review', '6–8 months',
            'Must apply to ACM; eligibility and Scopus indexing verification required before contract. Publication charges vary by agreement.'],
        ['AIP Conference Proceedings', '', 'Hybrid / OA options available', 'Yes — Scopus Indexed (most series)', 'Subject to AIP review', '6–8 months',
            'Must apply to AIP Publishing. Scopus indexing and other formalities to be verified before contract. Publication charges vary by volume agreement.'],
        ['IOP Conference Series', '', 'Full Open Access', 'Yes — Scopus Indexed', 'Subject to IOP review', '6–8 months',
            'Must apply to IOP Publishing. Scopus indexing and other formalities to be verified before contract. Publication charges vary by agreement.'],
        ['EAI Proceedings', '', 'Open Access Option Available', 'Scopus Indexed (verify per series)', 'Subject to EAI review', '6–8 months',
            'Must apply to EAI. Scopus indexing verification and other formalities required before contract. Publication charges vary by agreement.'],
    ],

    'notes' => [
        ['Springer:', 'No publication charge applies for the first-time conference contract. Springer selects and publishes 40–80 papers. Contract is subject to Springer&rsquo;s quality review and editorial approval process.'],
        ['Taylor &amp; Francis (T&amp;F India):', 'Two pricing models available — (a) Without Open Access: ₹7.5 Lakh for 350–500 pages / ₹10.6 Lakh for 600–750 pages; (b) With Open Access: USD 12,500 + GST per volume (~450–500 pages). For 1,000 pages, two volumes are required.'],
        ['E3S Web of Conferences:', 'Fully Open Access series. Approximate APC ≈ OMR 2,500 (total volume). Application required; Scopus indexing and eligibility must be confirmed before agreement.'],
        ['ACM / AIP / IOP / EAI:', 'All these publishers require a formal application. Scopus indexing status and other formalities must be verified before any contract is signed. Costs are indicative and subject to negotiation.'],
        ['Publication Duration:', 'Estimated 6–8 months across all publishers from submission of final manuscripts to online publication.'],
        ['Conversions:', 'OMR / INR / USD conversions are approximate. Final invoicing will be in the publisher&rsquo;s preferred currency at prevailing exchange rates.'],
        ['Note:', 'This proposal is for planning purposes only. All figures are subject to change pending formal publisher quotations and contract agreements.'],
    ],

    'budget' => [
        ['1. Event Arrangements — General Arrangements', 'Rs. 75,000', false],
        ['2. Keynote Speakers — Travel, Accommodation &amp; Hospitality', 'Rs. 1,00,000', false],
        ['3. Catering (2 Days) — Breakfast, Lunch &amp; Refreshments', 'Rs. 50,000', false],
        ['4. Miscellaneous Expenses', 'Rs. 25,000', false],
        ['5. Publication Cost', 'Rs. 1,50,000', false],
        ['6. Best Paper Awards &amp; Event Prizes', 'Rs. 15,000', false],
        ['ESTIMATED GRAND TOTAL', 'Rs. 4,15,000', true],
    ],

    'agenda_day1' => [
        ['Registration', 'Main Auditorium', '9:00 AM – 10:00 AM'],
        ['Inaugural &amp; Opening Ceremony', 'Main Auditorium', '10:00 AM – 10:30 AM'],
        ['Keynote Address I', 'Main Auditorium', '10:30 AM – 11:00 AM'],
        ['Keynote Address II', 'Main Auditorium', '11:00 AM – 11:30 AM'],
        ['Tea Break', 'Foyer', '11:30 AM – 11:45 AM'],
        ['Paper Presentation — Track 1', 'Main Auditorium', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 2', 'Seminar Hall 1', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 3', 'Seminar Hall 2', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 4', 'Seminar Hall 3', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 5', 'Seminar Hall 4', '11:50 AM – 1:00 PM'],
        ['Lunch Break', 'Cafeteria', '1:00 PM – 1:45 PM'],
        ['Keynote Address III', 'Main Auditorium', '1:50 PM – 2:20 PM'],
        ['Paper Presentation — Track 1', 'Main Auditorium', '2:25 PM – 3:35 PM'],
        ['Paper Presentation — Track 2', 'Seminar Hall 1', '2:25 PM – 3:35 PM'],
        ['Paper Presentation — Track 3', 'Seminar Hall 2', '2:25 PM – 3:35 PM'],
        ['Paper Presentation — Track 4', 'Seminar Hall 3', '2:25 PM – 3:35 PM'],
        ['Paper Presentation — Track 5', 'Seminar Hall 4', '2:25 PM – 3:35 PM'],
        ['Tea Break', 'Foyer', '3:35 PM – 3:45 PM'],
    ],

    'agenda_day2' => [
        ['Registration', 'Main Auditorium', '9:00 AM – 10:00 AM'],
        ['Keynote Address IV', 'Main Auditorium', '10:00 AM – 10:45 AM'],
        ['Keynote Address V', 'Main Auditorium', '10:45 AM – 11:30 AM'],
        ['Tea Break', 'Foyer', '11:30 AM – 11:45 AM'],
        ['Paper Presentation — Track 1', 'Main Auditorium', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 2', 'Seminar Hall 1', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 3', 'Seminar Hall 2', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 4', 'Seminar Hall 3', '11:50 AM – 1:00 PM'],
        ['Paper Presentation — Track 5', 'Seminar Hall 4', '11:50 AM – 1:00 PM'],
        ['Lunch Break', 'Cafeteria', '1:00 PM – 1:45 PM'],
        ['Paper Presentation — Track 1', 'Main Auditorium', '1:50 PM – 3:00 PM'],
        ['Paper Presentation — Track 2', 'Seminar Hall 1', '1:50 PM – 3:00 PM'],
        ['Paper Presentation — Track 3', 'Seminar Hall 2', '1:50 PM – 3:00 PM'],
        ['Paper Presentation — Track 4', 'Seminar Hall 3', '1:50 PM – 3:00 PM'],
        ['Paper Presentation — Track 5', 'Seminar Hall 4', '1:50 PM – 3:00 PM'],
        ['Tea Break', 'Foyer', '3:00 PM – 3:15 PM'],
        ['Best Paper Award Ceremony', 'Main Auditorium', '3:20 PM – 4:45 PM'],
        ['Valedictory Function', 'Main Auditorium', '4:45 PM – 5:00 PM'],
    ],

];
