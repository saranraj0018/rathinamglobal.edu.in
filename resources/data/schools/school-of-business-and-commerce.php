<?php

return [

    'skills' => [
        ['icon' => 'bar-chart-2', 'title' => 'Business Analytics', 'desc' => 'Data-driven decision making, BI tools, market research, and strategic business analysis with AI.', 'bg' => 'bg-green-50', 'ibg' => 'bg-green-100', 'ic' => 'text-green-700'],
        ['icon' => 'trending-up', 'title' => 'Financial Management', 'desc' => 'Corporate finance, investment banking, taxation, auditing, and CA/CMA examination preparation.', 'bg' => 'bg-lime-50', 'ibg' => 'bg-lime-100', 'ic' => 'text-lime-700'],
        ['icon' => 'megaphone', 'title' => 'Marketing & Branding', 'desc' => 'Digital marketing, consumer behaviour, brand strategy, growth hacking, and go-to-market planning.', 'bg' => 'bg-emerald-50', 'ibg' => 'bg-emerald-100', 'ic' => 'text-emerald-700'],
        ['icon' => 'rocket', 'title' => 'Entrepreneurship', 'desc' => 'Startup ecosystems, business modelling, venture capital, pitching, and 5.0 entrepreneurship frameworks.', 'bg' => 'bg-teal-50', 'ibg' => 'bg-teal-100', 'ic' => 'text-teal-700'],
        ['icon' => 'globe', 'title' => 'International Business', 'desc' => 'Global trade regulations, export management, WTO frameworks, and cross-cultural management.', 'bg' => 'bg-sky-50', 'ibg' => 'bg-sky-100', 'ic' => 'text-sky-700'],
        ['icon' => 'users', 'title' => 'Human Resource Management', 'desc' => 'Talent acquisition, OD, labour law, HR analytics, diversity management, and workforce planning.', 'bg' => 'bg-cyan-50', 'ibg' => 'bg-cyan-100', 'ic' => 'text-cyan-700'],
    ],

    /* Course name => programme page slug (courses/programmes/school-of-business-and-commerce/{slug}). */
    'program_links' => [
        // B.Com PA family
        'B.Com Professional Accounting' => 'b.com-pa-and-b.com-pa-with-ca',
        'B.Com Professional Accounting (CA Training)' => 'b.com-pa-and-b.com-pa-with-ca',
        'B.Com Professional Accounting (Chartered Accountant)' => 'b.com-pa-and-b.com-pa-with-ca',

        // B.Com CA (Computer Applications) family
        'B.Com Computer Applications (Business Intelligence & AI)' => 'b.com-ca',
        'B.Com Computer Applications (AI-Ready Accountant)' => 'b.com-ca',

        // M.Com CA (Computer Applications)
        'M.Com Computer Applications (AI-Ready Accountant)' => 'm.com-ca',
    ],

    'groups' => [
        ['num' => '1', 'g' => 'from-green-600 to-lime-500', 'sh' => 'shadow-green-500/30', 'title' => 'BBA Programmes', 'sub' => '3 Years &middot; Undergraduate &middot; Full Time', 'hc' => 'hover:border-green-200', 'nc' => 'bg-green-50 border-green-200 text-green-700', 'ht' => 'group-hover:text-green-700', 'bc' => 'bg-green-50 text-green-600 border-green-100', 'courses' => ['BBA General', 'BBA Aviation Management', 'BBA Computer Applications', 'BBA Logistics & Supply Chain']],
        ['num' => '2', 'g' => 'from-emerald-600 to-teal-500', 'sh' => 'shadow-emerald-500/30', 'title' => 'B.Com Programmes', 'sub' => '3 Years &middot; Undergraduate &middot; Full Time', 'hc' => 'hover:border-emerald-200', 'nc' => 'bg-emerald-50 border-emerald-200 text-emerald-700', 'ht' => 'group-hover:text-emerald-700', 'bc' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 'courses' => ['B.Com Accounting & Finance', 'B.Com Banking & Insurance', 'B.Com Business Process Services', 'B.Com Corporate Secretorship', 'B.Com Financial Services', 'B.Com Information Technology', 'B.Com International Business', 'B.Com Professional Accounting', 'B.Com Professional Accounting (CA Training)']],
        ['num' => '3', 'g' => 'from-lime-600 to-green-500', 'sh' => 'shadow-lime-500/30', 'title' => 'B.Com — AI & Professional Specialisations', 'sub' => '3 Years &middot; Undergraduate &middot; Full Time', 'hc' => 'hover:border-lime-200', 'nc' => 'bg-lime-50 border-lime-200 text-lime-700', 'ht' => 'group-hover:text-lime-700', 'bc' => 'bg-lime-50 text-lime-600 border-lime-100', 'courses' => ['B.Com Computer Applications (Business Intelligence & AI)', 'B.Com Computer Applications (AI-Ready Accountant)', 'B.Com Financial Services (AI-Ready Account Analyst)', 'B.Com Financial Services (Public Accountant)', 'B.Com IT (Accounting Analytics)', 'B.Com International Business (AI-Ready Business Analyst)', 'B.Com Professional Accounting (Chartered Accountant)', 'B.Com (AI-Ready Accountant)', 'B.Com (ACCA)']],
        ['num' => '4', 'g' => 'from-teal-500 to-cyan-500', 'sh' => 'shadow-teal-500/30', 'title' => 'M.Com Programmes', 'sub' => '2 Years &middot; Postgraduate &middot; Full Time', 'hc' => 'hover:border-teal-200', 'nc' => 'bg-teal-50 border-teal-200 text-teal-700', 'ht' => 'group-hover:text-teal-700', 'bc' => 'bg-teal-50 text-teal-600 border-teal-100', 'courses' => ['M.Com Computer Applications (AI-Ready Accountant)', 'M.Com General (Guaranteed Internship)']],
        ['num' => '5', 'g' => 'from-sky-600 to-blue-600', 'sh' => 'shadow-sky-500/30', 'title' => 'MBA Programmes', 'sub' => '2 Years &middot; Postgraduate &middot; Full Time', 'hc' => 'hover:border-sky-200', 'nc' => 'bg-sky-50 border-sky-200 text-sky-700', 'ht' => 'group-hover:text-sky-700', 'bc' => 'bg-sky-50 text-sky-600 border-sky-100', 'courses' => ['MBA General', 'MBA in Business Analytics and Artificial Intelligence', 'MBA in Marketing', 'MBA in Finance', 'MBA in Human Resource', 'MBA in Supply Chain and Logistics', 'MBA in Sustainability Management', 'MBA in AI Product Management', 'MBA in Entrepreneurship 5.0', 'MBA in Media & Entertainment Management', 'MBA in Sports Management', 'MBA Hospitality']],
    ],

    'careers' => [
        ['role' => 'Business Analyst', 'companies' => 'McKinsey &middot; BCG &middot; KPMG', 'emoji' => '&#x1F4CA;'],
        ['role' => 'Chartered Accountant', 'companies' => 'EY &middot; Deloitte &middot; PwC', 'emoji' => '&#x1F4B0;'],
        ['role' => 'Investment Banker', 'companies' => 'Goldman Sachs &middot; JP Morgan &middot; HDFC', 'emoji' => '&#x1F4C8;'],
        ['role' => 'Entrepreneur', 'companies' => 'Own Ventures &middot; VC-Backed Startups', 'emoji' => '&#x1F680;'],
        ['role' => 'International Trade Manager', 'companies' => 'Export Firms &middot; MNCs &middot; WTO', 'emoji' => '&#x1F30D;'],
        ['role' => 'Marketing Manager', 'companies' => 'P&G &middot; Unilever &middot; Nestl&eacute;', 'emoji' => '&#x1F4E3;'],
        ['role' => 'HR Manager', 'companies' => 'Google &middot; Infosys &middot; Wipro', 'emoji' => '&#x1F465;'],
        ['role' => 'Aviation Manager', 'companies' => 'IndiGo &middot; Air India &middot; SpiceJet', 'emoji' => '&#x2708;&#xFE0F;'],
    ],

    'hero_stats' => [['val' => '30+', 'label' => 'Specialisations'], ['val' => '1000+', 'label' => 'Placements / Year'], ['val' => '60+', 'label' => 'Corporate Partners'], ['val' => 'NAAC A++', 'label' => 'Accredited University']],

];
