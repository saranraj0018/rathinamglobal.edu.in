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

        // 'also_asked' lists other ways visitors ask the same question (English, Tanglish, Tamil). The
        // AI sees them when choosing an entry; they never change the answer.
        // Hostel & transport facts. 'answer' is English (used for search and as AI
        // reference text, which the AI already translates per its 'Reply in {language}'
        // rule). 'answer_ta' is a human Tamil translation, shown as-is to a Tamil
        // visitor when no AI provider is configured, so Tamil replies are pure Tamil
        // instead of the English text with a disclaimer.
        [
            'id' => 'hostel-facility',
            'category' => 'Hostel',
            'title' => 'Hostel facilities',
            'question' => 'Does Rathinam provide hostel facilities?',
            'also_asked' => [
                'Is there a hostel for students?',
                'hostel facility irukka',
                'ஹாஸ்டல் வசதி இருக்கா?',
            ],
            'answer' => 'Yes. Separate hostel facilities for boys and girls are provided within or very close to the campus.',
            'answer_ta' => 'இருக்கு. பசங்களுக்கும் பொண்ணுங்களுக்கும் தனித்தனி ஹாஸ்டல் இருக்கு, கேம்பஸ் உள்ளேயே இல்லனா ரொம்ப பக்கத்துலயே இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-location',
            'category' => 'Hostel',
            'title' => 'Hostel location',
            'question' => 'Where are the hostels located?',
            'also_asked' => [
                'How far is the hostel from the campus?',
                'hostel enga irukku, campus pakkathula irukka',
                'ஹாஸ்டல் எங்க இருக்கு, கேம்பஸ் பக்கத்துலயா?',
            ],
            'answer' => 'Hostels are located within the campus or very close to the campus for easy academic access.',
            'answer_ta' => 'ஹாஸ்டல் கேம்பஸ் உள்ளேயே இல்லனா ரொம்ப பக்கத்துலயே இருக்கு, அதனால கிளாஸுக்கு சீக்கிரம் போயிடலாம்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-separate-boys-girls',
            'category' => 'Hostel',
            'title' => 'Separate hostels for boys and girls',
            'question' => 'Are hostels separate for boys and girls?',
            'also_asked' => [
                'Is there a separate hostel for girls?',
                'boys girls ku separate hostel irukka',
                'பசங்களுக்கும் பொண்ணுங்களுக்கும் தனி ஹாஸ்டல் இருக்கா?',
            ],
            'answer' => 'Yes. Separate hostels are available for boys and girls with dedicated wardens.',
            'answer_ta' => 'இருக்கு. பசங்களுக்கும் பொண்ணுங்களுக்கும் தனித்தனி ஹாஸ்டல் இருக்கு, ஒவ்வொன்னுக்கும் தனி வார்டன் இருக்காங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-room-types',
            'category' => 'Hostel',
            'title' => 'Hostel room types',
            'question' => 'What types of hostel rooms are available?',
            'also_asked' => [
                'How many students share a room? Sharing options?',
                'hostel la enna room type irukku, 2 sharing 4 sharing irukka',
                'ஹாஸ்டல்ல என்னென்ன ரூம் வகை இருக்கு?',
            ],
            'answer' => '2-sharing, 4-sharing, 6-sharing, 8-sharing, and dormitory rooms are available.',
            'answer_ta' => '2, 4, 6, 8 பேர் தங்குற ரூம்களும் டார்மிட்டரி ரூம்களும் இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-room-capacity',
            'category' => 'Hostel',
            'title' => 'Hostel room capacity',
            'question' => 'How many students can stay in one hostel room?',
            'also_asked' => [
                'How many students share one room?',
                'oru room la ethana peru thangalam',
                'ஒரு ரூம்ல எத்தனை பேர் தங்கலாம்?',
            ],
            'answer' => 'Depending on the category, 2 to 8 students can stay in one room.',
            'answer_ta' => 'ரூம் வகையைப் பொறுத்து, ஒரு ரூம்ல 2 பேர்ல இருந்து 8 பேர் வரை தங்கலாம்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-furniture',
            'category' => 'Hostel',
            'title' => 'Hostel room furniture',
            'question' => 'What furniture is provided in hostel rooms?',
            'also_asked' => [
                'Do hostel rooms have cots, tables and cupboards?',
                'room la cot table cupboard irukka',
                'ரூம்ல கட்டில், டேபிள், அலமாரி இருக்கா?',
            ],
            'answer' => 'Beds, study tables, chairs, and cupboards or luggage storage are provided.',
            'answer_ta' => 'கட்டில், படிக்கிற டேபிள், நாற்காலி, அலமாரி எல்லாம் குடுப்பாங்க, பொருட்கள் வைக்கவும் இடம் இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-wifi',
            'category' => 'Hostel',
            'title' => 'Hostel Wi-Fi',
            'question' => 'Is Wi-Fi available in the hostel?',
            'also_asked' => [
                'Is there internet in the hostel?',
                'hostel la wifi irukka',
                'ஹாஸ்டல்ல வைஃபை இருக்கா?',
            ],
            'answer' => 'Yes. Wi-Fi connectivity is available throughout the hostel premises.',
            'answer_ta' => 'இருக்கு, ஹாஸ்டல் முழுக்க வைஃபை இருக்கு, நீங்க தாராளமா யூஸ் பண்ணிக்கலாம்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-hot-water',
            'category' => 'Hostel',
            'title' => 'Hostel hot water facility',
            'question' => 'Is hot water facility available?',
            'also_asked' => [
                'Is hot water available for bathing?',
                'hostel la hot water irukka',
                'ஹாஸ்டல்ல வெந்நீர் வசதி இருக்கா?',
            ],
            'answer' => 'Yes. Hot water facility is provided for hostel students.',
            'answer_ta' => 'இருக்கு, ஹாஸ்டல்ல இருக்குறவங்களுக்கு வெந்நீர் வசதி இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-bathrooms',
            'category' => 'Hostel',
            'title' => 'Hostel bathrooms',
            'question' => 'Are attached bathrooms available?',
            'also_asked' => [
                'Is there an attached bathroom in the room?',
                'room kooda attached bathroom irukka',
                'ரூமோட சேர்ந்த பாத்ரூம் இருக்கா?',
            ],
            'answer' => 'Attached or common bathrooms are available based on the selected room category.',
            'answer_ta' => 'நீங்க எடுக்குற ரூம் வகையைப் பொறுத்து, ரூமோட சேர்ந்த பாத்ரூம் இல்லனா பொதுவான பாத்ரூம் இருக்கும்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-food',
            'category' => 'Hostel',
            'title' => 'Hostel food',
            'question' => 'Is food provided in the hostel?',
            'also_asked' => [
                'Is veg and non-veg food served in the mess?',
                'hostel la veg non veg saapadu irukka',
                'ஹாஸ்டல்ல வெஜ் நான்-வெஜ் சாப்பாடு இருக்கா?',
            ],
            'answer' => 'Yes. Both vegetarian and non-vegetarian food is provided.',
            'answer_ta' => 'இருக்கு, வெஜ், நான்-வெஜ் ரெண்டு வகை சாப்பாடும் குடுப்பாங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-food-quality',
            'category' => 'Hostel',
            'title' => 'Hostel food quality monitoring',
            'question' => 'How is food quality monitored?',
            'also_asked' => [
                'How good is the hostel mess food? Who checks hygiene?',
                'mess food quality epdi check pannuvanga',
                'மெஸ் சாப்பாட்டு தரத்தை எப்படி கவனிக்கிறாங்க?',
            ],
            'answer' => 'Food quality is monitored through hygiene checks, inspections, and student feedback.',
            'answer_ta' => 'ஹெல்த் செக்கப், ஆய்வுகள், மாணவர்கள் சொல்ற கருத்துகள் மூலமா சாப்பாட்டோட தரத்தை கவனிச்சுக்கிறாங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-laundry',
            'category' => 'Hostel',
            'title' => 'Hostel laundry services',
            'question' => 'Are laundry services available?',
            'also_asked' => [
                'Can students get their clothes washed in the hostel?',
                'hostel la dhobi laundry vasathi irukka',
                'துணி துவைக்கிற வசதி ஹாஸ்டல்ல இருக்கா?',
            ],
            'answer' => 'Yes. Laundry services are available for hostel students.',
            'answer_ta' => 'இருக்கு, ஹாஸ்டல் மாணவர்களுக்கு துணி துவைக்கிற வசதி இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-housekeeping',
            'category' => 'Hostel',
            'title' => 'Hostel housekeeping',
            'question' => 'Is housekeeping provided?',
            'also_asked' => [
                'Who cleans the hostel rooms?',
                'room clean pannuvangala housekeeping irukka',
                'ரூமை சுத்தம் பண்ணி தருவாங்களா?',
            ],
            'answer' => 'Yes. Regular housekeeping services are provided.',
            'answer_ta' => 'இருக்கு, ரூமை தொடர்ந்து சுத்தம் பண்ணிக் குடுப்பாங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-study-hours',
            'category' => 'Hostel',
            'title' => 'Hostel study hours',
            'question' => 'Are there fixed study hours in the hostel?',
            'also_asked' => [
                'Is there a compulsory study time in the hostel?',
                'hostel la study time irukka',
                'ஹாஸ்டல்ல ஸ்டடி டைம் இருக்கா?',
            ],
            'answer' => 'Yes. Dedicated study hours are maintained to support academics.',
            'answer_ta' => 'இருக்கு, படிக்கிறதுக்குன்னே தனி ஸ்டடி டைம் வெச்சிருக்காங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-timings',
            'category' => 'Hostel',
            'title' => 'Hostel in-time and out-time rules',
            'question' => 'What are the hostel in-time and out-time rules?',
            'also_asked' => [
                'What time must students return to the hostel?',
                'hostel in time out time enna',
                'ஹாஸ்டல் இன் டைம், அவுட் டைம் என்ன?',
            ],
            'answer' => 'Clearly defined in-time and out-time rules are followed for boys and girls.',
            'answer_ta' => 'பசங்களுக்கும் பொண்ணுங்களுக்கும் ஹாஸ்டலுக்குள்ள வர்ற, வெளிய போற நேரம் தெளிவா வரையறுக்கப்பட்டிருக்கு, அத ஃபாலோ பண்ணணும்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-weekend-visits',
            'category' => 'Hostel',
            'title' => 'Hostel weekend home visits',
            'question' => 'Are students allowed to go home on weekends?',
            'also_asked' => [
                'Can hostel students go out on Sunday or visit home?',
                'weekend la veetuku pogalama',
                'வீக்எண்ட்ல வீட்டுக்கு போகலாமா?',
            ],
            'answer' => 'Yes. Weekend home visits and Sunday outings are allowed with parental consent.',
            'answer_ta' => 'இருக்கு, பெற்றோரோட சம்மதம் இருந்தா வீக்எண்ட்ல ஊருக்கு போகலாம், ஞாயிற்றுக்கிழமை வெளிய போகவும் அனுமதி உண்டு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-parent-visits',
            'category' => 'Hostel',
            'title' => 'Parents visiting the hostel',
            'question' => 'Can parents visit the hostel?',
            'also_asked' => [
                'Can parents meet their children in the hostel?',
                'parents hostel ku vandhu paakalama',
                'பெற்றோர் ஹாஸ்டலுக்கு வந்து பார்க்கலாமா?',
            ],
            'answer' => 'Yes. Parents can visit during specified visiting hours.',
            'answer_ta' => 'இருக்கு, சொல்லியிருக்குற சந்திப்பு நேரங்கள்ல பெற்றோர் ஹாஸ்டலுக்கு வந்து பார்க்கலாம்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-safety',
            'category' => 'Hostel',
            'title' => 'Hostel safety measures',
            'question' => 'What safety measures are available in the hostel?',
            'also_asked' => [
                'Is the hostel safe? Is there CCTV and security?',
                'hostel safe ah irukka, cctv irukka',
                'ஹாஸ்டல் பாதுகாப்பா இருக்கா, சிசிடிவி இருக்கா?',
            ],
            'answer' => 'CCTV surveillance, 24/7 security, controlled entry, and wardens ensure safety.',
            'answer_ta' => 'சிசிடிவி கேமரா, 24 மணி நேர பாதுகாப்பு, கட்டுப்பாடான நுழைவு, வார்டன்கள்னு எல்லாமே இருக்கு, அதனால பாதுகாப்பா இருக்கலாம்.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-attendance',
            'category' => 'Hostel',
            'title' => 'Hostel attendance monitoring',
            'question' => 'Is attendance monitored in the hostel?',
            'also_asked' => [
                'Is hostel attendance taken?',
                'hostel la attendance edukkuvangala',
                'ஹாஸ்டல்ல அட்டெண்டன்ஸ் எடுப்பாங்களா?',
            ],
            'answer' => 'Yes. Student attendance is monitored regularly.',
            'answer_ta' => 'இருக்கு, மாணவர்கள் வருகையை எப்பவும் கவனிச்சுக்கிட்டே இருப்பாங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-absenteeism',
            'category' => 'Hostel',
            'title' => 'Hostel absenteeism notification',
            'question' => 'Will parents be informed about absenteeism?',
            'also_asked' => [
                'Are parents told if a student is absent?',
                'student absent na parents ku solluvangala',
                'மாணவர் வரலனா பெற்றோருக்கு சொல்லுவாங்களா?',
            ],
            'answer' => 'Yes. Parents are informed immediately in case of absenteeism.',
            'answer_ta' => 'இருக்கு, மாணவர் வரலனா உடனே பெற்றோருக்கு தகவல் சொல்லிடுவாங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-medical',
            'category' => 'Hostel',
            'title' => 'Hostel medical support',
            'question' => 'Is medical support available for hostel students?',
            'also_asked' => [
                'What happens if a hostel student falls sick?',
                'hostel la doctor first aid irukka',
                'ஹாஸ்டல்ல உடம்பு சரியில்லனா மருத்துவ வசதி இருக்கா?',
            ],
            'answer' => 'Yes. First-aid facilities, hospital tie-ups, and emergency transport are available.',
            'answer_ta' => 'இருக்கு, முதலுதவி வசதி, மருத்துவமனை தொடர்பு, அவசரத்துக்கு வண்டி வசதி எல்லாம் இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-outside-food',
            'category' => 'Hostel',
            'title' => 'Outside food in the hostel',
            'question' => 'Is outside food allowed in the hostel?',
            'also_asked' => [
                'Can students order food from outside like Swiggy or Zomato?',
                'veliya irundhu food order pannalama',
                'வெளிய இருந்து சாப்பாடு ஆர்டர் பண்ணலாமா?',
            ],
            'answer' => 'Outside food delivery is regulated as per hostel rules.',
            'answer_ta' => 'வெளிய இருந்து சாப்பாடு ஆர்டர் பண்றதுக்கு ஹாஸ்டல் விதிமுறைப்படி கட்டுப்பாடு இருக்கு.',
            'route' => 'home',
        ],
        [
            'id' => 'hostel-roommate',
            'category' => 'Hostel',
            'title' => 'Choosing hostel roommates',
            'question' => 'Can students choose their roommates?',
            'also_asked' => [
                'Can I stay with my friend in the same room?',
                'roommate nanga choose pannalama',
                'ரூம்மேட்டை நாங்களே தேர்வு பண்ணலாமா?',
            ],
            'answer' => 'Roommate preferences are considered subject to availability and policies.',
            'answer_ta' => 'இடம் இருக்கிறத பொறுத்தும் விதிமுறைகளுக்கு உட்பட்டும், உங்க ரூம்மேட் விருப்பத்தையும் பார்ப்பாங்க.',
            'route' => 'home',
        ],
        [
            'id' => 'transport-availability',
            'category' => 'Transport',
            'title' => 'College transport facilities',
            'question' => 'Does Rathinam provide transport facilities?',
            'also_asked' => [
                'Is there a college bus?',
                'college bus irukka',
                'காலேஜ் பஸ் வசதி இருக்கா?',
            ],
            'answer' => 'Yes. College transport facilities are available across major routes.',
            'answer_ta' => 'இருக்கு, முக்கியமான வழித்தடங்கள்ல காலேஜ் பஸ் வசதி இருக்கு.',
            'route' => 'bus-registration.create',
        ],
        [
            'id' => 'transport-coverage',
            'category' => 'Transport',
            'title' => 'Transport route coverage',
            'question' => 'Which areas are covered under transport facilities?',
            'also_asked' => [
                'Does the bus come to my area or town?',
                'bus enga enga varum, en area ku varuma',
                'பஸ் எந்தெந்த ஏரியாவுக்கு வரும்?',
            ],
            'answer' => 'Major towns, residential locations, and student-dense areas are covered.',
            'answer_ta' => 'முக்கியமான நகரங்கள், குடியிருப்பு பகுதிகள், மாணவர்கள் நிறைய இருக்குற இடங்கள் எல்லாம் கவர் ஆகுது.',
            'route' => 'bus-registration.create',
        ],
        [
            'id' => 'transport-pickup',
            'category' => 'Transport',
            'title' => 'Morning pickup timings',
            'question' => 'What are the morning pickup timings?',
            'also_asked' => [
                'What time does the bus pick up students in the morning?',
                'morning bus epo varum, pickup time enna',
                'காலை பஸ் எப்போ வரும், பிக்கப் டைம் என்ன?',
            ],
            'answer' => 'Pickup timings range between 6:45 AM and 8:05 AM depending on the route.',
            'answer_ta' => 'நீங்க வர்ற ரூட்டைப் பொறுத்து, காலை 6:45 முதல் 8:05 மணிக்குள்ள பஸ் உங்கள ஏத்திக்கும்.',
            'route' => 'bus-registration.create',
        ],
        [
            'id' => 'transport-arrival',
            'category' => 'Transport',
            'title' => 'Bus arrival time at campus',
            'question' => 'What time do buses reach the campus?',
            'also_asked' => [
                'When does the bus reach college?',
                'bus epo campus varum',
                'பஸ் எப்போ கேம்பஸ் வரும்?',
            ],
            'answer' => 'All buses reach the campus by 8:45 AM.',
            'answer_ta' => 'எல்லா பஸ்ஸும் காலை 8:45 மணிக்குள்ள கேம்பஸ் வந்துடும்.',
            'route' => 'bus-registration.create',
        ],
        [
            'id' => 'transport-drop',
            'category' => 'Transport',
            'title' => 'Evening drop timings',
            'question' => 'What are the evening drop timings?',
            'also_asked' => [
                'What time does the bus leave college in the evening?',
                'evening bus epo kelambum, drop time enna',
                'சாயங்காலம் பஸ் எப்போ கிளம்பும், டிராப் டைம் என்ன?',
            ],
            'answer' => 'Evening drop timings are between 4:45 PM and 5:00 PM.',
            'answer_ta' => 'சாயங்காலம் 4:45 முதல் 5:00 மணிக்குள்ள மாணவர்களை இறக்கி விடுவாங்க.',
            'route' => 'bus-registration.create',
        ],
        [
            'id' => 'transport-bus-pass',
            'category' => 'Transport',
            'title' => 'Bus pass for transport users',
            'question' => 'Is a bus pass issued to transport users?',
            'also_asked' => [
                'Do I need a bus pass or ID for the bus?',
                'bus pass kudupangala',
                'பஸ் பாஸ் குடுப்பாங்களா?',
            ],
            'answer' => 'Yes. Students using transport are issued an official bus pass.',
            'answer_ta' => 'இருக்கு, பஸ் யூஸ் பண்றவங்களுக்கு அதிகாரப்பூர்வ பஸ் பாஸ் குடுப்பாங்க.',
            'route' => 'bus-registration.create',
        ],
        [
            'id' => 'transport-safety',
            'category' => 'Transport',
            'title' => 'College bus safety features',
            'question' => 'What safety features are available in college buses?',
            'also_asked' => [
                'Is the college bus safe? Is there GPS and CCTV?',
                'bus safe ah irukka, gps cctv irukka',
                'காலேஜ் பஸ் பாதுகாப்பா இருக்கா, ஜிபிஎஸ் இருக்கா?',
            ],
            'answer' => 'GPS tracking, CCTV cameras, first-aid kits, fire extinguishers, and trained drivers are provided.',
            'answer_ta' => 'ஜிபிஎஸ் டிராக்கிங், சிசிடிவி கேமரா, முதலுதவி பெட்டி, தீயணைப்பான், பயிற்சி பெற்ற டிரைவர்கள்னு எல்லாம் இருக்கு.',
            'route' => 'bus-registration.create',
        ],
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
