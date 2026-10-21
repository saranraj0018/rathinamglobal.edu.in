<?php

/**
 * Voice assistant knowledge base — Rathinam Global University
 * -----------------------------------------------------------
 * Approved content the website assistant may answer from, on top of the FAQ
 * (resources/data/faqs.php) and the school pages (resources/data/schools/*.php),
 * which App\Services\VoiceAssistant\KnowledgeBase indexes automatically.
 *
 * Only add facts that are already published on the website. The assistant is
 * instructed never to answer beyond this material.
 *
 * contact  — the enquiry channel offered whenever an answer is not available
 * schools  — display names for resources/data/schools/{slug}.php
 * facts    — extra entries: id, category, title, question, answer, route (named route) or url
 * aliases  — search synonyms: a visitor word (or Tamil word stem) => English terms in this content
 * phrases  — degrees spelled letter by letter ("பி எஸ் சி", dots ignored) => English terms
 * personas — the "AI team" a visitor picks from: name, role, voice (female|male), image (under public/),
 *            focus (steers the AI's emphasis, never its rules), greeting and suggestions per language.
 *            To use real photos, replace the image files (square, at least 240px) and keep the keys.
 * apply    — where a visitor who wants to apply is sent. When they ask to apply / join / enrol, the
 *            assistant says so and opens the matching link: the AI picks it when a provider is
 *            set, otherwise the visitor's words are matched against each link's keywords (and the
 *            programme names of its schools). Add a link by copying an entry under "links";
 *            "default" is used when the programme isn't clear. Keys are lowercase letters only.
 * messages — fixed replies in each supported language (":label" is replaced in "redirect")
 */
return [

    'contact' => [
        'phone' => '+91 84484 48909',
        'email' => 'admission@rathinam.in',
        'admissions_url' => 'https://admissions.rathinamcollege.edu.in/',
    ],

    'schools' => [
        'school-of-applied-biosciences' => 'School of Applied Biosciences, Food & Agritech',
        'school-of-business-and-commerce' => 'School of Business & Commerce',
        'school-of-engineering-emerging-technologies' => 'School of Engineering & Emerging Technologies',
        'school-of-fashion-design' => 'School of Fashion Design',
        'school-of-liberal-arts-science' => 'School of Liberal Arts & Science',
        'school-of-media-and-performing-arts' => 'School of Media & Performing Arts',
        'school-of-quantum-science' => 'School of Quantum Science, Computing & AI',
        'school-of-sports-and-health-sciences' => 'School of Sports & Health Sciences',
        'school-of-sustainability-and-climate-studies' => 'School of Sustainability & Climate Studies',
    ],

    'facts' => [
        [
            'id' => 'about',
            'category' => 'About',
            'title' => 'About Rathinam Global University',
            'question' => 'What is Rathinam Global University?',
            'answer' => 'Rathinam Global University is a higher education institution in Eachanari, Coimbatore, Tamil Nadu, India, offering undergraduate, postgraduate and research programmes across engineering, computing, artificial intelligence, business, commerce, biosciences, liberal arts, media, fashion, health sciences and sustainability.',
            'route' => 'home',
        ],
        [
            'id' => 'address',
            'category' => 'Contact',
            'title' => 'Campus address and location',
            'question' => 'Where is the campus located? What is the address?',
            'answer' => 'The university is located at Rathinam Techzone Campus, Eachanari, Coimbatore, Tamil Nadu - 641021, India.',
            'route' => 'home',
        ],
        [
            'id' => 'contact',
            'category' => 'Contact',
            'title' => 'Contact and admission enquiries',
            'question' => 'How can I contact the university or the admissions office? What is the phone number and email?',
            'answer' => 'You can call +91 84484 48909 or email admission@rathinam.in. Online applications are made through the admissions portal at admissions.rathinamcollege.edu.in.',
            'route' => 'home',
        ],
        [
            'id' => 'schools',
            'category' => 'Academics',
            'title' => 'Schools of the university',
            'question' => 'Which schools, departments and programmes does the university have?',
            'answer' => 'The university has the School of Quantum Science, Computing & AI; Engineering & Emerging Technologies; Business & Commerce; Applied Biosciences, Food & Agritech; Liberal Arts & Science; Media & Performing Arts; Fashion Design; Sports & Health Sciences; and Sustainability & Climate Studies.',
            'route' => 'home',
        ],
        [
            'id' => 'research',
            'category' => 'Research',
            'title' => 'Research and Ph.D.',
            'question' => 'Does the university offer research and Ph.D. opportunities?',
            'answer' => 'Yes. The Research and Development pages cover research programmes, Ph.D. opportunities, publications, patents, grants and innovation activities.',
            'route' => 'research.index',
        ],
        [
            'id' => 'global-affairs',
            'category' => 'International',
            'title' => 'Office of Global Affairs',
            'question' => 'Are there international partnerships and student exchange programmes?',
            'answer' => 'The Office of Global Affairs handles international partnerships, student mobility, global immersion and academic collaborations.',
            'route' => 'global-affairs',
        ],
    ],

    'aliases' => [
        // English synonyms
        'programs' => ['programs', 'programmes'],
        'programmes' => ['programs', 'programmes'],
        'course' => ['programs', 'programmes'],
        'courses' => ['programs', 'programmes'],
        'degree' => ['programs', 'programmes'],
        'job' => ['placement', 'placements'],
        'jobs' => ['placement', 'placements'],
        'salary' => ['package', 'salary'],
        'accommodation' => ['hostel'],
        'stay' => ['hostel'],
        'phone' => ['contact', 'phone'],
        'call' => ['contact', 'phone'],
        'mail' => ['email'],
        'location' => ['address', 'located'],
        'where' => ['address', 'located'],
        'apply' => ['admission', 'admissions'],
        'join' => ['admission', 'admissions'],
        'cost' => ['fees'],
        'phd' => ['phd', 'research'],
        'abroad' => ['international'],
        'foreign' => ['international'],

        // Tamil word stems (matched as prefixes, so inflected forms also match)
        'சேர்க்கை' => ['admission', 'admissions'],
        'விண்ணப்ப' => ['apply', 'admission'],
        'கட்டண' => ['fees'],
        'உதவித்தொகை' => ['scholarships'],
        'விடுதி' => ['hostel'],
        'தங்குமிட' => ['hostel'],
        'வசதி' => ['facility', 'facilities'],
        'வேலைவாய்ப்பு' => ['placement', 'placements'],
        'வேலை' => ['placement', 'careers'],
        'சம்பள' => ['salary', 'package'],
        'வளாக' => ['campus'],
        'முகவரி' => ['address'],
        'எங்கே' => ['address', 'located'],
        'எங்கு' => ['address', 'located'],
        'தொடர்பு' => ['contact'],
        'தொலைபேசி' => ['phone', 'contact'],
        'மின்னஞ்சல்' => ['email'],
        'படிப்பு' => ['programs', 'programmes'],
        'பாடநெறி' => ['programs', 'programmes'],
        'துறை' => ['departments', 'schools'],
        'பள்ளி' => ['school'],
        'பொறியியல்' => ['engineering'],
        'மேலாண்மை' => ['management', 'mba'],
        'வணிக' => ['business', 'commerce'],
        'ஆராய்ச்சி' => ['research'],
        'காப்புரிமை' => ['patents'],
        'சர்வதேச' => ['international'],
        'வெளிநாட்டு' => ['international'],
        'நூலக' => ['library'],
        'தரவரிசை' => ['ranking', 'nirf'],
        'அங்கீகார' => ['accreditation', 'naac', 'nba'],
        'பெற்றோர்' => ['parents'],
        'இன்டர்ன்ஷிப்' => ['internship', 'internships'],
        'பயிற்சி' => ['training', 'internship'],
        'கணினி' => ['computer'],
        'செயற்கை' => ['artificial', 'intelligence'],
        'பேருந்து' => ['bus'],
        'பட்டியல்' => ['list'],

        // English words as Tamil speech recognition writes them ("பிஎஸ்சி ப்ரோக்ராம்ஸ் லிஸ்ட்")
        'பிஎஸ்சி' => ['bsc'],
        'எம்எஸ்சி' => ['msc'],
        'பிடெக்' => ['btech'],
        'பிகாம்' => ['bcom'],
        'எம்காம்' => ['mcom'],
        'பிபிஏ' => ['bba'],
        'எம்பிஏ' => ['mba'],
        'பிசிஏ' => ['bca'],
        'எம்சிஏ' => ['mca'],
        'பிஏ' => ['ba'],
        'எம்ஏ' => ['ma'],
        'பிஹெச்டி' => ['phd', 'research'],
        'ப்ரோக்ராம' => ['programs', 'programmes'],
        'புரோகிராம' => ['programs', 'programmes'],
        'புரோக்ராம' => ['programs', 'programmes'],
        'கோர்ஸ' => ['programs', 'programmes'],
        'கோர்ச' => ['programs', 'programmes'],
        'டிகிரி' => ['programs', 'programmes'],
        'லிஸ்ட' => ['list'],
        'ஃபீஸ' => ['fees'],
        'பீஸ' => ['fees'],
        'அட்மிஷன' => ['admission', 'admissions'],
        'ஹாஸ்டல' => ['hostel'],
        'பிளேஸ்மென்ட' => ['placement', 'placements'],
        'ஸ்காலர்ஷிப' => ['scholarships'],
        'இன்ஜினியரிங' => ['engineering'],
        'இஞ்சினியரிங' => ['engineering'],
        'கம்ப்யூட்டர' => ['computer'],
    ],

    'phrases' => [
        'பி எஸ் சி' => ['bsc'],
        'எம் எஸ் சி' => ['msc'],
        'பி இ' => ['be'],
        'பி டெக்' => ['btech'],
        'பி காம்' => ['bcom'],
        'எம் காம்' => ['mcom'],
        'பி பி ஏ' => ['bba'],
        'எம் பி ஏ' => ['mba'],
        'பி சி ஏ' => ['bca'],
        'எம் சி ஏ' => ['mca'],
        'பி ஏ' => ['ba'],
        'எம் ஏ' => ['ma'],
    ],

    'personas' => [
        'admissions' => [
            'name' => ['en' => 'Priya', 'ta' => 'பிரியா'],
            'role' => ['en' => 'Admissions Counsellor', 'ta' => 'சேர்க்கை ஆலோசகர்'],
            'voice' => 'female',
            'image' => 'images/voice-assistant/admissions.svg',
            'focus' => 'admissions: eligibility, how to apply, important steps and who to contact',
            'greeting' => [
                'en' => 'Hi, I’m Priya, your admissions counsellor. What would you like to know about joining Rathinam?',
                'ta' => 'வணக்கம், நான் பிரியா, உங்கள் சேர்க்கை ஆலோசகர். ரத்தினத்தில் சேருவது பற்றி என்ன தெரிந்துகொள்ள விரும்புகிறீர்கள்?',
            ],
            'suggestions' => [
                'en' => ['How do I apply for admission?', 'Are admissions open now?', 'How can I contact the admissions office?'],
                'ta' => ['சேர்க்கைக்கு எப்படி விண்ணப்பிப்பது?', 'சேர்க்கை இப்போது நடக்கிறதா?', 'சேர்க்கை அலுவலகத்தை எப்படித் தொடர்பு கொள்வது?'],
            ],
        ],
        'programmes' => [
            'name' => ['en' => 'Arjun', 'ta' => 'அர்ஜுன்'],
            'role' => ['en' => 'Programme Advisor', 'ta' => 'படிப்பு ஆலோசகர்'],
            'voice' => 'male',
            'image' => 'images/voice-assistant/programmes.svg',
            'focus' => 'programmes: the schools, degrees, specialisations and research options',
            'greeting' => [
                'en' => 'Hello, I’m Arjun, the programme advisor. Tell me what you’re interested in and I’ll help you find the right course.',
                'ta' => 'வணக்கம், நான் அர்ஜுன், படிப்பு ஆலோசகர். உங்களுக்கு எதில் ஆர்வம் என்று சொல்லுங்கள், சரியான படிப்பைக் கண்டறிய உதவுகிறேன்.',
            ],
            'suggestions' => [
                'en' => ['Which programmes are offered?', 'What engineering courses are there?', 'Can I do a Ph.D. here?'],
                'ta' => ['என்னென்ன படிப்புகள் உள்ளன?', 'பொறியியல் படிப்புகள் என்ன உள்ளன?', 'இங்கு Ph.D. படிக்க முடியுமா?'],
            ],
        ],
        'campus' => [
            'name' => ['en' => 'Kavya', 'ta' => 'காவ்யா'],
            'role' => ['en' => 'Campus Life Guide', 'ta' => 'வளாக வழிகாட்டி'],
            'voice' => 'female',
            'image' => 'images/voice-assistant/campus.svg',
            'focus' => 'campus life: location, hostel, transport, facilities, clubs and student support',
            'greeting' => [
                'en' => 'Hey, I’m Kavya, your campus life guide. Ask me anything about the campus, hostels or student life.',
                'ta' => 'வணக்கம், நான் காவ்யா, உங்கள் வளாக வழிகாட்டி. வளாகம், விடுதி அல்லது மாணவர் வாழ்க்கை பற்றி எதுவும் கேளுங்கள்.',
            ],
            'suggestions' => [
                'en' => ['Is hostel accommodation available?', 'Where is the campus?', 'Is there college transport?'],
                'ta' => ['விடுதி வசதி உள்ளதா?', 'வளாகம் எங்கே உள்ளது?', 'கல்லூரிப் பேருந்து வசதி உள்ளதா?'],
            ],
        ],
        'careers' => [
            'name' => ['en' => 'Karthik', 'ta' => 'கார்த்திக்'],
            'role' => ['en' => 'Careers & Placements', 'ta' => 'வேலைவாய்ப்பு ஆலோசகர்'],
            'voice' => 'male',
            'image' => 'images/voice-assistant/careers.svg',
            'focus' => 'careers: placements, internships, industry links and international opportunities',
            'greeting' => [
                'en' => 'Hi, I’m Karthik from careers and placements. Want to know where Rathinam can take you?',
                'ta' => 'வணக்கம், நான் கார்த்திக், வேலைவாய்ப்புப் பிரிவிலிருந்து. ரத்தினம் உங்களை எங்கே கொண்டு செல்லும் என்று தெரிந்துகொள்ள வேண்டுமா?',
            ],
            'suggestions' => [
                'en' => ['What placement support is available?', 'Are there internships?', 'Are there international opportunities?'],
                'ta' => ['வேலைவாய்ப்பு உதவி என்ன உள்ளது?', 'இன்டர்ன்ஷிப் வாய்ப்புகள் உள்ளதா?', 'வெளிநாட்டு வாய்ப்புகள் உள்ளதா?'],
            ],
        ],
    ],

    'apply' => [
        // Words that mean "I want to apply" (Tamil entries are matched as stems).
        'intent' => [
            'apply', 'applying', 'application', 'application form', 'admission form', 'enrol', 'enroll', 'enrolment',
            'enrollment', 'register for admission', 'join', 'joining', 'get admission', 'take admission', 'book a seat',
            'விண்ணப்ப', 'சேர விரும்', 'சேர வேண்டும்', 'சேரணும்', 'சேரலாம்', 'அப்ளை',
        ],

        'default' => [
            'label' => ['en' => 'admissions', 'ta' => 'சேர்க்கை'],
            'url' => 'https://admissions.rathinamcollege.edu.in/',
        ],

        // On a tie, the link listed first wins.
        'links' => [
            'engineering' => [
                'label' => ['en' => 'engineering admissions', 'ta' => 'பொறியியல் சேர்க்கை'],
                'url' => 'https://admissions.rathinamcollege.edu.in/engineering',
                'description' => 'B.E. and B.Tech engineering programmes',
                'schools' => ['school-of-engineering-emerging-technologies'],
                'keywords' => [
                    'engineering', 'engineer', 'b.e', 'b.tech', 'btech', 'b tech', 'cse', 'ece', 'eee',
                    'information technology', 'mechanical', 'mechatronics', 'civil', 'electrical', 'electronics',
                    'robotics', 'cyber security', 'cybersecurity', 'aiml', 'ai and ml', 'ai ml', 'ai & ds', 'ai and data science',
                    'computer science engineering', 'computer science and engineering',
                    'பொறியியல்', 'இன்ஜினியரிங்', 'எஞ்சினியரிங்',
                ],
            ],
            'arts' => [
                'label' => ['en' => 'arts and science admissions', 'ta' => 'கலை மற்றும் அறிவியல் சேர்க்கை'],
                'url' => 'https://admissions.rathinamcollege.edu.in/arts',
                'description' => 'arts, science, commerce, management, computing, media, fashion, biosciences, sports and other non-engineering programmes',
                'schools' => [
                    'school-of-applied-biosciences', 'school-of-business-and-commerce', 'school-of-fashion-design',
                    'school-of-liberal-arts-science', 'school-of-media-and-performing-arts', 'school-of-quantum-science',
                    'school-of-sports-and-health-sciences', 'school-of-sustainability-and-climate-studies',
                ],
                'keywords' => [
                    'arts', 'arts and science', 'science', 'b.sc', 'bsc', 'm.sc', 'msc', 'b.com', 'bcom', 'm.com', 'mcom',
                    'commerce', 'bba', 'mba', 'bca', 'mca', 'b.a', 'm.a', 'english', 'tamil literature', 'psychology',
                    'management', 'business', 'computer science', 'computer applications', 'data science', 'fashion',
                    'costume', 'design', 'media', 'visual communication', 'viscom', 'journalism', 'biotechnology',
                    'microbiology', 'food', 'agriculture', 'nutrition', 'sports', 'physical education', 'sustainability',
                    'கலை', 'அறிவியல்', 'வணிக', 'மேலாண்மை',
                ],
            ],
        ],
    ],

    'messages' => [
        'en' => [
            'unknown' => 'I don’t have verified information about that yet. Please contact the admissions team on +91 84484 48909 or at admission@rathinam.in.',
            'english_only' => '',
            'redirect' => 'I’m opening the :label page for you now.',
        ],
        'ta' => [
            'unknown' => 'அதைப் பற்றிய சரிபார்க்கப்பட்ட தகவல் என்னிடம் இப்போது இல்லை. சேர்க்கைக் குழுவை +91 84484 48909 என்ற எண்ணில் அல்லது admission@rathinam.in என்ற மின்னஞ்சலில் தொடர்பு கொள்ளவும்.',
            'english_only' => 'இந்தத் தகவல் தற்போது ஆங்கிலத்தில் மட்டுமே உள்ளது:',
            'redirect' => ':label பக்கத்தை இப்போது உங்களுக்காகத் திறக்கிறேன்.',
        ],
    ],

];
