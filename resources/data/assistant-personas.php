<?php

/**
 * The "AI team" shown in the floating assistant: name, role, voice (female|male), image (under public/),
 * greeting and suggestions per language. Presentation only; answers come from the admin-managed knowledge.
 */
return [
    'admissions' => [
        'name' => [
            'en' => 'Priya',
            'ta' => 'பிரியா',
        ],
        'role' => [
            'en' => 'Admissions Counsellor',
            'ta' => 'சேர்க்கை ஆலோசகர்',
        ],
        'voice' => 'female',
        'image' => 'images/voice-assistant/admissions.svg',
        'focus' => 'admissions: eligibility, how to apply, important steps and who to contact',
        'greeting' => [
            'en' => 'Hi, I’m Priya, your admissions counsellor. What would you like to know about joining Rathinam?',
            'ta' => 'வணக்கம், நான் பிரியா, உங்கள் சேர்க்கை ஆலோசகர். ரத்தினத்தில் சேருவது பற்றி என்ன தெரிந்துகொள்ள விரும்புகிறீர்கள்?',
        ],
        'suggestions' => [
            'en' => [
                0 => 'How do I apply for admission?',
                1 => 'Are admissions open now?',
                2 => 'How can I contact the admissions office?',
            ],
            'ta' => [
                0 => 'சேர்க்கைக்கு எப்படி விண்ணப்பிப்பது?',
                1 => 'சேர்க்கை இப்போது நடக்கிறதா?',
                2 => 'சேர்க்கை அலுவலகத்தை எப்படித் தொடர்பு கொள்வது?',
            ],
        ],
    ],
    'programmes' => [
        'name' => [
            'en' => 'Arjun',
            'ta' => 'அர்ஜுன்',
        ],
        'role' => [
            'en' => 'Programme Advisor',
            'ta' => 'படிப்பு ஆலோசகர்',
        ],
        'voice' => 'male',
        'image' => 'images/voice-assistant/programmes.svg',
        'focus' => 'programmes: the schools, degrees, specialisations and research options',
        'greeting' => [
            'en' => 'Hello, I’m Arjun, the programme advisor. Tell me what you’re interested in and I’ll help you find the right course.',
            'ta' => 'வணக்கம், நான் அர்ஜுன், படிப்பு ஆலோசகர். உங்களுக்கு எதில் ஆர்வம் என்று சொல்லுங்கள், சரியான படிப்பைக் கண்டறிய உதவுகிறேன்.',
        ],
        'suggestions' => [
            'en' => [
                0 => 'Which programmes are offered?',
                1 => 'What engineering courses are there?',
                2 => 'Can I do a Ph.D. here?',
            ],
            'ta' => [
                0 => 'என்னென்ன படிப்புகள் உள்ளன?',
                1 => 'பொறியியல் படிப்புகள் என்ன உள்ளன?',
                2 => 'இங்கு Ph.D. படிக்க முடியுமா?',
            ],
        ],
    ],
    'campus' => [
        'name' => [
            'en' => 'Kavya',
            'ta' => 'காவ்யா',
        ],
        'role' => [
            'en' => 'Campus Life Guide',
            'ta' => 'வளாக வழிகாட்டி',
        ],
        'voice' => 'female',
        'image' => 'images/voice-assistant/campus.svg',
        'focus' => 'campus life: location, hostel, transport, facilities, clubs and student support',
        'greeting' => [
            'en' => 'Hey, I’m Kavya, your campus life guide. Ask me anything about the campus, hostels or student life.',
            'ta' => 'வணக்கம், நான் காவ்யா, உங்கள் வளாக வழிகாட்டி. வளாகம், விடுதி அல்லது மாணவர் வாழ்க்கை பற்றி எதுவும் கேளுங்கள்.',
        ],
        'suggestions' => [
            'en' => [
                0 => 'Is hostel accommodation available?',
                1 => 'Where is the campus?',
                2 => 'Is there college transport?',
            ],
            'ta' => [
                0 => 'விடுதி வசதி உள்ளதா?',
                1 => 'வளாகம் எங்கே உள்ளது?',
                2 => 'கல்லூரிப் பேருந்து வசதி உள்ளதா?',
            ],
        ],
    ],
    'careers' => [
        'name' => [
            'en' => 'Karthik',
            'ta' => 'கார்த்திக்',
        ],
        'role' => [
            'en' => 'Careers & Placements',
            'ta' => 'வேலைவாய்ப்பு ஆலோசகர்',
        ],
        'voice' => 'male',
        'image' => 'images/voice-assistant/careers.svg',
        'focus' => 'careers: placements, internships, industry links and international opportunities',
        'greeting' => [
            'en' => 'Hi, I’m Karthik from careers and placements. Want to know where Rathinam can take you?',
            'ta' => 'வணக்கம், நான் கார்த்திக், வேலைவாய்ப்புப் பிரிவிலிருந்து. ரத்தினம் உங்களை எங்கே கொண்டு செல்லும் என்று தெரிந்துகொள்ள வேண்டுமா?',
        ],
        'suggestions' => [
            'en' => [
                0 => 'What placement support is available?',
                1 => 'Are there internships?',
                2 => 'Are there international opportunities?',
            ],
            'ta' => [
                0 => 'வேலைவாய்ப்பு உதவி என்ன உள்ளது?',
                1 => 'இன்டர்ன்ஷிப் வாய்ப்புகள் உள்ளதா?',
                2 => 'வெளிநாட்டு வாய்ப்புகள் உள்ளதா?',
            ],
        ],
    ],
];
