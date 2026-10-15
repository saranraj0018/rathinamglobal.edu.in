<?php

/**
 * Event — AICTE – VAANI Scheme · Two-Day National Conference
 * ------------------------------------------------------------------
 * Bilingual content (English + Tamil), pulled verbatim from the
 * client-supplied source documents (English.docx / Tamil.pdf).
 * Nothing paraphrased or summarised — only paragraph-run artifacts
 * from the docx/pdf export (missing spaces where two runs were
 * concatenated) were corrected for readability.
 *
 * Shape: return ['en' => [...], 'ta' => [...]]
 * Each language block has the same generic 'sections' array so the
 * detail-page template (events/aicte-vaani-cybersecurity-2026.php)
 * can render both languages with one shared renderer. Re-use this
 * exact shape for every future event.
 *
 * Section types handled by the template:
 *   paragraphs  -> ['paragraphs' => [...]]
 *   list        -> ['items' => [...]]
 *   submission  -> ['paragraphs' => [...], 'link' => ['label','url'], 'deadline' => '']
 *   speakers    -> ['items' => [ ['topic','name','affiliation'] ]]
 *   registration-> ['link' => ['label','url'], 'application_no' => '', 'notes' => [...]]
 *   contact     -> ['phone' => '', 'website' => '', 'email' => '']
 */

return [

    'en' => [
        'title' => 'AICTE – VAANI Scheme',
        'subtitle' => 'Two-Day National Conference (in regional language: Tamil)',
        'theme_title' => 'Cybersecurity Risk Analysis and Protection Strategies in Mobile Gaming Platforms Among Youth',
        'sponsor_line' => 'Sponsored by AICTE – VAANI (Vibrant Advocacy for Advancement and Nurturing of Indian Languages) Scheme',
        'date_line' => '15th & 16th October 2026',
        'venue_line' => 'Rathinam Auditorium, Rathinam Techzone Campus, Eachanari, Coimbatore-21, Tamil Nadu, India',
        'call_heading' => 'Call for Papers',
        'call_note' => '(In Tamil and English Languages)',

        'sections' => [
            [
                'heading' => 'About Rathinam Global',
                'type' => 'paragraphs',
                'paragraphs' => [
                    'Rathinam Global (Deemed to be University), formerly known as Rathinam College of Arts and Science (RCAS), traces its origins to 2001 and attained the status of a Deemed to be University in 2026 under the UGC (Institutions Deemed to be Universities) Regulations. A multidisciplinary institution in Coimbatore, the University is built on over two decades of academic excellence.',
                    'Researchers, academicians, industry professionals, research scholars, and PG students are invited to submit original research papers in the Tamil or English language for presentation at the conference.',
                    'The University offers 32 undergraduate, 15 postgraduate, and 8 research programmes across 18 academic departments, supported by 400+ faculty members and 8,000+ students.',
                    'RGU has been featured in the NIRF Rankings for nine consecutive years, including the 101–150 band, reflecting its academic excellence and national recognition.',
                    'The University promotes innovation and research through its AIC RAISE – Atal Incubation Centre and a dedicated Research Centre, supported by a 4-Star IIC Rating, and ₹1.63 crore DBT Star College Scheme funding.',
                    'A key strength of RGU is its industry-integrated ecosystem. The campus houses Rathinam Techzone, featuring 40+ companies and 8,000+ professionals, providing students with internships, live projects, mentoring, and placement opportunities.',
                    'Through industry-linked education, research, innovation, and entrepreneurship, RGU develops future-ready professionals and responsible global citizens equipped for a rapidly evolving world.',
                ],
            ],
            [
                'heading' => 'About AICTE – VAANI',
                'type' => 'paragraphs',
                'paragraphs' => [
                    'The scheme provides financial assistance to AICTE approved institutions for organizing Conference/Seminar/Workshop in emerging fields of technical education in 22 Indian languages. To promote high standards in technical education in Indian languages by way of extending opportunities to the academicians and working professionals by providing a forum for sharing their knowledge, experiences, innovations and inventions in 16 emerging fields.',
                ],
            ],
            [
                'heading' => 'Key Themes',
                'type' => 'list',
                'items' => [
                    'Cybersecurity Threat Analysis in Mobile Gaming Platforms',
                    'Digital Privacy Protection for Young Users',
                    'Malware Prevention in Gaming Applications',
                    'Behavioral Risk Monitoring in Online Gaming',
                    'Intelligent Threat Detection in Mobile Platforms',
                    'Responsible Digital Gaming Practices',
                ],
            ],
            [
                'heading' => 'Paper Submission',
                'type' => 'submission',
                'paragraphs' => [
                    'Authors are requested to submit their Abstract and Full Paper in Tamil or English through the following Google Form:',
                    'Please ensure that your submission adheres to the guidelines mentioned in the form. Selected papers will be considered for publication in conference proceedings or recommended for journals (as per quality review).',
                ],
                'link' => ['label' => 'https://tinyurl.com/AICTE-VAANI-2026', 'url' => 'https://tinyurl.com/AICTE-VAANI-2026'],
                'deadline' => '30-08-2026',
                'extended_deadline' => '08-08-2026',
            ],
            [
                'heading' => 'About the Conference',
                'type' => 'paragraphs',
                'paragraphs' => [
                    'The Two-Day National Conference on "Cybersecurity Risk Analysis and Protection Strategies in Mobile Gaming Platforms among Youth" focuses on addressing the growing cybersecurity challenges emerging from the rapid expansion of mobile gaming applications among young users. As gaming ecosystems become increasingly interconnected, concerns related to data privacy breaches, cyberbullying, malware attacks, identity theft, online exploitation, behavioral manipulation, and unethical digital interactions have become significant issues. The conference aims to explore these challenges through expert discussions on cybersecurity risk assessment, secure gaming architectures, intelligent threat detection, digital forensics, and privacy-preserving technologies to create safer and more resilient gaming environments.',
                    'The conference aims to create a multidisciplinary platform for academicians, researchers, cybersecurity professionals, industry experts, policymakers, and students to exchange knowledge on emerging cyber threats, secure communication frameworks, behavioral risk mitigation strategies, youth-centric protection mechanisms, and digital governance practices associated with mobile gaming platforms. The programme promotes research collaboration, knowledge-driven discussions, skill development, and industry-academia interaction supporting secure digital ecosystems and responsible technology adoption. The event also aligns with the objectives of the Cyber Surakshit Bharat and Viksit Bharat 2047 initiatives by strengthening cybersecurity awareness, digital resilience, ethical digital engagement, and sustainable protection frameworks capable of supporting safe, secure, and technologically responsible gaming environments in contemporary society.',
                ],
            ],
            [
                'heading' => 'Topics and Speakers',
                'type' => 'speakers',
                'items' => [
                    ['topic' => 'Secure In-Game Communication Mechanisms',           'name' => 'Dr. G. Rakesh',                    'affiliation' => 'Associate Professor, PSG College of Arts and Science, Coimbatore, Tamil Nadu'],
                    ['topic' => 'Cybersecurity Threat Statistics in Mobile Game Platforms', 'name' => 'Mr. Nithish Kumar, CEO',      'affiliation' => 'Cyfotok Infosec, Coimbatore, Tamil Nadu'],
                    ['topic' => 'Parental Control and Digital Safety Systems',        'name' => 'Mr. R. J. Senthil Kumar, Director', 'affiliation' => 'Sprout Knowledge Solutions Pvt Ltd, Coimbatore, Tamil Nadu'],
                    ['topic' => 'Privacy Protection in Gaming Applications',         'name' => 'Dr. B. Narasimhan, Associate Professor', 'affiliation' => 'Sri Ramakrishna College of Arts and Science, Coimbatore, Tamil Nadu'],
                    ['topic' => 'AI-Based Threat Detection in Mobile Gaming',        'name' => 'Ms. A. Poornima, Operations Head', 'affiliation' => 'Sprout Knowledge Solutions Pvt Ltd, Coimbatore, Tamil Nadu'],
                    ['topic' => 'Behavior-Based Risk Mitigation in Gaming Usage',    'name' => 'Mr. Prashanth Raghu, CEO',         'affiliation' => 'Sudarshana Semiconductors Pvt. Ltd., Bengaluru, Karnataka'],
                    ['topic' => 'Malware Prevention in Mobile Gaming Platforms',     'name' => 'Mr. S. Kalyanaraman',              'affiliation' => 'Cloud Services Delivery, Noventiq Technologies, Bengaluru, Karnataka'],
                ],
            ],
            [
                'heading' => 'Registration Details',
                'type' => 'registration',
                'link' => ['label' => 'https://atalacademy.aicte.gov.in/login', 'url' => 'https://atalacademy.aicte.gov.in/login'],
                'application_no' => '2277957180',
                'notes' => [
                    'Who can participate – UG Students, PG Students, Research Scholars, Faculties and Industry Persons.',
                    'No Registration Fee – Kits, Refreshments and Lunch will be provided to all participants.',
                    'All participants must register through AICTE ATAL FDP portal.',
                    'Participants will be selected on a first-come-first-served basis.',
                    'Physical presence of participants is mandatory.',
                ],
            ],
            [
                'heading' => 'Chief Patrons',
                'type' => 'list',
                'items' => [
                    'Dr. Madan A. Sendhil – Chancellor – Rathinam Global (Deemed to be University); Chairman, Rathinam Group of Institutions; Chief Executive Officer – Rathinam Group.',
                    'Mrs. Shima Sendhil – Director & Trustee, Rathinam Group of Institutions.',
                    'Dr. R. Manickam – Vice Chairman, Rathinam Group of Institutions; Chief Operating Officer – Rathinam Group.',
                    'Dr. B. Nagaraj – Vice Chancellor (Officiating), Rathinam Global (Deemed to be University); Vice President – Rathinam Group of Institutions; Chief Business Officer (CBO) – Rathinam Group.',
                ],
            ],
            [
                'heading' => 'Patrons',
                'type' => 'list',
                'items' => [
                    'Dr. C. Krishnaraj – Registrar, Rathinam Global (Deemed to be University).',
                    'Dr. S. Dhinakaran – Deputy Registrar, Rathinam Global (Deemed to be University).',
                    'Dr. K. P. V. Sabareesh – Director – Research and Development.',
                ],
            ],
            [
                'heading' => 'Coordinator & Co-Coordinator',
                'type' => 'list',
                'items' => [
                    'Dr. J. Ramkumar – Associate Professor, Department of Artificial Intelligence. Mob: +91 8667352728. Email: ramkumar.cs@rathinam.in',
                    'Dr. S. Manikandan – Dean, School of Quantum Science, Computing and AI. Email: manikandan.rtc@rathinam.in',
                ],
            ],
            [
                'heading' => 'Committee Members',
                'type' => 'list',
                'items' => [
                    'Dr. K. Arun Kumar – Associate Dean, School of Quantum Science, Computing and AI.',
                    'Dr. D. Vimalkumar – Head, Department of Artificial Intelligence.',
                    'Dr. S. Raja – Head, Department of Computer Science.',
                    'Ms. R. Udaya Nirmala Mary – Head (In-charge), Department of Information Technology.',
                    'Dr. A. Uthiramoorthy – Head, Department of Rsmart Pro.',
                    'Dr. S. Karthikeyan – Head, Department of Computing and Cyber Security.',
                ],
            ],
            [
                'heading' => 'Contact Details',
                'type' => 'contact',
                'phone' => '+91 8667352728, +91 9940625080',
                'website' => 'https://rathinamglobal.edu.in',
                'email' => 'ramkumar.cs@rathinam.in',
            ],
        ],
    ],

    'ta' => [
        'title' => 'AICTE – VAANI',
        'subtitle' => 'இருநாள் தேசியக் கருத்தரங்கம் (தமிழ் மொழியில்)',
        'theme_title' => 'இளைஞர்களுக்கிடையிலான திறன்பேசி விளையாட்டுத் தளங்களில் இணையப் பாதுகாப்பு அபாய பகுப்பாய்வு மற்றும் பாதுகாப்பு உத்திகள்',
        'sponsor_line' => 'AICTE – VAANI (இந்திய மொழிகளின் முன்னேற்றம் மற்றும் வளர்ச்சிக்கான உற்சாக முன்னெடுப்புத் திட்டம்) ஏற்பாடு',
        'date_line' => '15 மற்றும் 16 அக்டோபர் 2026',
        'venue_line' => 'ரத்தினம் அரங்கம்',
        'call_heading' => 'ஆய்வுக்கட்டுரைகள் வரவேற்பு',
        'call_note' => '(தமிழ் மற்றும் ஆங்கில மொழிகளில்)',

        'sections' => [
            [
                'heading' => 'நிறுவனம் குறித்த விவரம்',
                'type' => 'paragraphs',
                'paragraphs' => [
                    'ரத்தினம் குளோபல் நிகர்நிலைப் பல்கலைக்கழகம், முன்பு ரத்தினம் கலை மற்றும் அறிவியல் கல்லூரி (Rathinam College of Arts and Science - RCAS) என அறியப்பட்டு, 2001 ஆம் ஆண்டு தனது கல்விப் பயணத்தைத் தொடங்கியது. பல்கலைக்கழக மானியக் குழு (UGC) வெளியிட்ட நிகர்நிலைப் பல்கலைக்கழகங்களுக்கான விதிமுறைகளின் அடிப்படையில், 2026 ஆம் ஆண்டு நிகர்நிலைப் பல்கலைக்கழக அந்தஸ்தைப் பெற்றது. கோயம்புத்தூரில் அமைந்துள்ள பன்முகத் துறைப் பல்கலைக்கழகம், இருபது ஆண்டுகளுக்கும் மேலான கல்விச் சிறப்பை அடிப்படையாகக் கொண்டு உயர்கல்வி, ஆராய்ச்சி மற்றும் புதுமைத் துறைகளில் சிறப்பாகச் செயல்பட்டு வருகிறது.',
                    '18 கல்வித் துறைகளின் மூலம் 32 களநிலைப் பட்டப்படிப்புகள், 15 முதுநிலைப் பட்டப்படிப்புகள் மற்றும் 8 ஆராய்ச்சிப் படிப்புகள் வழங்கப்படுகின்றன. 400-க்கும் மேற்பட்ட பேராசிரியர்கள் மற்றும் 8000-க்கும் மேற்பட்ட மாணவர்கள் கொண்ட கல்விச் சமூகத்துடன் பல்கலைக்கழகம் சிறப்பாக இயங்கி வருகிறது.',
                    'தேசிய நிறுவன தரவரிசைக் கட்டமைப்பு (NIRF) தரவரிசையில் தொடர்ந்து ஒன்பது ஆண்டுகளாக இடம்பெற்று, 101-150 இடைப்பிரிவில் இடம்பிடித்ததன் மூலம் கல்விச் சிறப்பிற்கும் தேசிய அளவிலான அங்கீகாரத்திற்கும் இப்பல்கலைக்கழகம் பெருமை சேர்த்துள்ளது.',
                    'AIC RAISE – அடல் தொழில் முனைவு வளர்ப்பு மையம் மற்றும் தனித்துவமான ஆராய்ச்சி மையம் ஆகியவற்றின் மூலம் புதுமை மற்றும் ஆராய்ச்சி நடவடிக்கைகள் ஊக்குவிக்கப்படுகின்றன. மேலும், நிறுவனப் புதுமைக் குழு (IIC) வழங்கிய 4-நட்சத்திர மதிப்பீடும், DBT Star College Scheme திட்டத்தின் கீழ் ₹1.63 கோடி நிதியுதவியும் பல்கலைக்கழகத்தின் ஆராய்ச்சி மற்றும் புதுமைச் செயல்பாடுகளுக்கு வலுசேர்க்கின்றன.',
                    'ரத்தினம் குளோபல் நிகர்நிலைப் பல்கலைக்கழகத்தின் முக்கியச் சிறப்பம்சங்களில் ஒன்று தொழில்துறையுடன் ஒருங்கிணைந்த கல்விச் சூழலாகும். வளாகத்தில் அமைந்துள்ள ரத்தினம் டெக்சோன் வளாகத்தில் 40-க்கும் மேற்பட்ட நிறுவனங்களும் 8000-க்கும் மேற்பட்ட தொழில்முறை நிபுணர்களும் செயல்பட்டு வருகின்றனர். இதன் மூலம் மாணவர்களுக்கு தொழிற்பயிற்சி, நேரடி திட்டப்பணிகள், வழிகாட்டுதல் மற்றும் வேலைவாய்ப்பு வாய்ப்புகள் வழங்கப்படுகின்றன.',
                    'தொழில்துறையுடன் இணைந்த கல்வி, ஆராய்ச்சி, புதுமை மற்றும் தொழில்முனைவு வளர்ச்சியின் மூலம் வேகமாக மாறிவரும் உலகின் தேவைகளுக்கு ஏற்ப எதிர்காலத்தை வழிநடத்தக்கூடிய திறன்மிக்க வல்லுநர்களையும் பொறுப்புணர்வுமிக்க உலகக் குடிமக்களையும் ரத்தினம் குளோபல் நிகர்நிலைப் பல்கலைக்கழகம் உருவாக்கி கொண்டு வருகின்றது.',
                ],
            ],
            [
                'heading' => 'AICTE - VAANI குறித்து',
                'type' => 'paragraphs',
                'paragraphs' => [
                    'அகில இந்திய தொழில்நுட்பக் கல்விக் கழகம் (AICTE) முன்னெடுத்து வரும் "VAANI" திட்டம், இந்திய மொழிகள் வழியாக தொழில்நுட்பக் கல்வியை மேம்படுத்தும் முக்கிய தேசிய முன்னெடுப்பாகும். இத்திட்டத்தின் மூலம், AICTE அங்கீகாரம் பெற்ற கல்வி நிறுவனங்களுக்கு 22 இந்திய மொழிகளில் வளர்ந்து வரும் தொழில்நுட்பத் துறைகளில் மாநாடுகள், கருத்தரங்குகள் மற்றும் பயிற்சி நிகழ்ச்சிகள் நடத்த நிதியுதவி வழங்கப்படுகிறது. இந்திய மொழிகளின் வழியாக உயர்தர தொழில்நுட்பக் கல்வியை ஊக்குவிப்பதுடன், கல்வியாளர்கள், ஆராய்ச்சியாளர்கள் மற்றும் தொழில்முறை நிபுணர்கள் தங்களுடைய அறிவு, அனுபவம், புதுமைகள் மற்றும் கண்டுபிடிப்புகளைப் பகிர்ந்து கொள்ளும் கல்வி மேடையையும் இத்திட்டம் உருவாக்குகிறது. மேலும், உருவெடுத்து வரும் 16 முக்கிய தொழில்நுட்பத் துறைகளில் தாய்மொழி வழித் தொழில்நுட்ப அறிவுப் பரவலை வலுப்படுத்தும் நோக்கத்தையும் VAANI திட்டம் கொண்டுள்ளது.',
                ],
            ],
            [
                'heading' => 'முக்கிய கருப்பொருள்கள்',
                'type' => 'list',
                'items' => [
                    'திறன்பேசி விளையாட்டு தளங்களிலான இணையப் பாதுகாப்பு அச்சுறுத்தல் பகுப்பாய்வு',
                    'இளைஞர் பயனாளர்களுக்கான மின்னணுதனியுரிமை பாதுகாப்பு',
                    'விளையாட்டுப் பயன்பாடுகளில் தீங்கிழைக்கும் மென்பொருள் தடுப்பு முறைகள்',
                    'இணையவழி விளையாட்டுகளில் நடத்தை சார்ந்த அபாய கண்காணிப்பு',
                    'திறன்பேசித் தளங்களிலான நுண்ணறிவு அச்சுறுத்தல் கண்டறிதல்',
                    'பொறுப்புணர்வுடன் கூடிய மின்னணுவிளையாட்டு நடைமுறைகள்',
                ],
            ],
            [
                'heading' => 'ஆய்வுக்கட்டுரை சமர்ப்பிப்பு',
                'type' => 'submission',
                'paragraphs' => [
                    '"இளைஞர்களுக்கிடையிலான மொபைல் விளையாட்டு தளங்களில் இணையப் பாதுகாப்பு அபாய பகுப்பாய்வு மற்றும் பாதுகாப்பு உத்திகள்" என்ற தலைப்பிலான தேசியக் கருத்தரங்கத்திற்காக, ஆராய்ச்சியாளர்கள், கல்வியாளர்கள், தொழில்துறை வல்லுநர்கள், ஆராய்ச்சி அறிஞர்கள் மற்றும் மாணவர்கள் ஆகியோரிடமிருந்து தமிழ் அல்லது ஆங்கில மொழிகளில் ஆய்வுக்கட்டுரைகள் வரவேற்கப்படுகின்றன. இக்கருத்தரங்கம், இளைஞர்கள் பயன்படுத்தும் திறன்பேசி விளையாட்டுத் தளங்களுடன் தொடர்புடைய இணையப் பாதுகாப்புச் சவால்கள், மின்னணு பாதுகாப்பு நடைமுறைகள், தொழில்நுட்ப புதுமைகள் மற்றும் பாதுகாப்பு சார்ந்த தீர்வுகள் குறித்த தரமான கல்வி மற்றும் ஆராய்ச்சி பங்களிப்புகளை ஊக்குவிக்கிறது.',
                    'புதுமை சார்ந்த ஆய்வுகள், தொழில்நுட்ப வழக்குக் கட்டுரைகள், பகுப்பாய்வு ஆய்வுகள், பாதுகாப்பு கட்டமைப்புகள், நடைமுறை அமலாக்கங்கள் மற்றும் இளைஞர்களுக்கான மின்னணு பாதுகாப்பு தீர்வுகள் ஆகிய துறைகளில் அமைந்த கட்டுரைகள் வரவேற்கப்படுகின்றன.',
                    'ஆசிரியர்கள் மற்றும் ஆராய்ச்சியாளர்கள் தங்களின் ஆய்வுச் சுருக்கம் மற்றும் முழு ஆய்வுக்கட்டுரைகளை தமிழ் அல்லது ஆங்கில மொழிகளில் கீழே வழங்கப்பட்டுள்ள கூகுள் படிவ இணைப்பின் மூலம் சமர்ப்பிக்குமாறு கேட்டுக்கொள்ளப்படுகின்றனர்.',
                    'படிவத்தில் குறிப்பிடப்பட்டுள்ள வழிகாட்டுதல்களை முறையாகப் பின்பற்றி ஆய்வுக்கட்டுரைகள் சமர்ப்பிக்கப்பட வேண்டும். தர மதிப்பீட்டின் அடிப்படையில் தேர்வு செய்யப்படும் கட்டுரைகள் கருத்தரங்கச் செயல்தொகுப்பில் வெளியிடப்படவோ அல்லது தரமான ஆய்விதழ்களுக்கு பரிந்துரைக்கப்படவோ செய்யப்படும்.',
                ],
                'link' => ['label' => 'https://tinyurl.com/AICTE-VAANI-2026', 'url' => 'https://tinyurl.com/AICTE-VAANI-2026'],
                'deadline' => '30-08-2026',
                'extended_deadline' => '08-08-2026',
            ],
            [
                'heading' => 'கருத்தரங்கம் குறித்த விவரம்',
                'type' => 'paragraphs',
                'paragraphs' => [
                    'இளைஞர்களுக்கிடையிலான திறன்பேசி விளையாட்டுத் தளங்களின் வேகமான வளர்ச்சியுடன் இணையப் பாதுகாப்பு அச்சுறுத்தல்கள், தரவு தனியுரிமை மீறல்கள், கணக்கு திருட்டு, தீங்கிழைக்கும் மென்பொருள் தாக்குதல்கள் மற்றும் இணையவழி மோசடிகள் போன்ற அபாயங்களும் அதிகரித்து வருகின்றன. இச்சவால்களை அறிவியல் மற்றும் தொழில்நுட்பக் கண்ணோட்டத்தில் ஆராய்ந்து, பாதுகாப்பான விளையாட்டு சூழலை உருவாக்குவதற்கான பயனுள்ள தீர்வுகளை முன்வைப்பதே இந்த தேசியக் கருத்தரங்கத்தின் முக்கிய நோக்கமாகும். AICTE-VAANI திட்டத்தின் கீழ் தமிழ் மொழியில் நடைபெறும் இந்நிகழ்வு, தாய்மொழி வழியாக இணையப் பாதுகாப்பு அறிவைப் பரப்பும் குறிப்பிடத்தக்க தேசிய முயற்சியாக அமைகிறது.',
                    'இணையப் பாதுகாப்பு அபாய பகுப்பாய்வு, இளைஞர் பயனாளர்களின் தனியுரிமை பாதுகாப்பு, தீங்கிழைக்கும் மென்பொருள் தடுப்பு, செயற்கை நுண்ணறிவு அடிப்படையிலான அச்சுறுத்தல் கண்டறிதல், நடத்தை சார்ந்த அபாயக் கண்காணிப்பு, பாதுகாப்பான தகவல் பரிமாற்றம் மற்றும் பொறுப்புணர்வுடன் கூடிய மின்னணு விளையாட்டு நடைமுறைகள் போன்ற சமகாலக் கருப்பொருள்களை மையமாகக் கொண்டு, கல்வியாளர்கள், ஆராய்ச்சியாளர்கள், தொழில்துறை வல்லுநர்கள், ஆராய்ச்சி அறிஞர்கள் மற்றும் மாணவர்கள் தங்களின் அறிவு, அனுபவம் மற்றும் புதுமையான ஆராய்ச்சி முடிவுகளைப் பகிர்ந்துகொள்ளும் வாய்ப்பை கருத்தரங்கம் வழங்குகிறது. சிறப்பு உரைகள், தொழில்நுட்ப விவாதங்கள் மற்றும் அறிவுப் பரிமாற்ற அமர்வுகள் இணையப் பாதுகாப்பு தொடர்பான புதிய அணுகுமுறைகள் மற்றும் நடைமுறைத் தீர்வுகளை வெளிப்படுத்தும் வகையில் வடிவமைக்கப்பட்டுள்ளன.',
                    'தமிழ் மற்றும் ஆங்கில மொழிகளில் ஆய்வுக்கட்டுரைகள் வரவேற்கப்படுவதுடன், புதுமை சார்ந்த ஆராய்ச்சிகள், தொழில்நுட்ப வழக்குக் கட்டுரைகள், பாதுகாப்பு கட்டமைப்புகள், பகுப்பாய்வு ஆய்வுகள் மற்றும் நடைமுறை அமலாக்கங்கள் ஆகிய துறைகளில் தரமான பங்களிப்புகள் ஊக்குவிக்கப்படுகின்றன. தர மதிப்பீட்டின் அடிப்படையில் தேர்வு செய்யப்படும் ஆய்வுக்கட்டுரைகள் கருத்தரங்கச் செயல்தொகுப்பில் வெளியிடப்படவோ அல்லது தரமான ஆய்விதழ்களுக்கு பரிந்துரைக்கப்படவோ செய்யப்படும். கல்வி, ஆராய்ச்சி மற்றும் தொழில்துறையை ஒருங்கிணைக்கும் இக்கருத்தரங்கம், இளைஞர்களுக்கான பாதுகாப்பான திறன்பேசி விளையாட்டு சூழலை உருவாக்குவதற்கான புதுமையான இணையப் பாதுகாப்புத் தீர்வுகள் மற்றும் ஆராய்ச்சி ஒத்துழைப்புகளை ஊக்குவிக்கும் வகையில் சிறப்புமிக்க அறிவியல் மேடையாக அமைகிறது.',
                ],
            ],
            [
                'heading' => 'தலைப்புகள் மற்றும் பேச்சாளர்கள்',
                'type' => 'speakers',
                'items' => [
                    ['topic' => 'மொபைல் விளையாட்டுகளுக்குள் பாதுகாப்பான தகவல் தொடர்பு அமைப்புகள்',              'name' => 'முனைவர் ஜி. ராகேஷ்',    'affiliation' => 'இணைப் பேராசிரியர், பி.எஸ்.ஜி. கலை மற்றும் அறிவியல் கல்லூரி, கோயம்புத்தூர், தமிழ்நாடு'],
                    ['topic' => 'மொபைல் விளையாட்டு தளங்களில் இணையப் பாதுகாப்பு அச்சுறுத்தல்களின் புள்ளிவிவரங்கள்', 'name' => 'திரு. நிதிஷ் குமார்',   'affiliation' => 'தலைமைச் செயல் அதிகாரி, சைஃபோடோக் இன்ஃபோசெக், கோயம்புத்தூர், தமிழ்நாடு'],
                    ['topic' => 'பெற்றோர் கட்டுப்பாடு மற்றும் மின்னணுபாதுகாப்பு அமைப்புகள்',                       'name' => 'திரு. ஆர். ஜே. செந்தில் குமார்', 'affiliation' => 'இயக்குநர், ஸ்ப்ரவுட் நாலெட்ஜ் சொல்யூஷன்ஸ் பிரைவேட் லிமிடெட், கோயம்புத்தூர், தமிழ்நாடு'],
                    ['topic' => 'விளையாட்டு பயன்பாடுகளில் தனியுரிமைப் பாதுகாப்பு',                                 'name' => 'முனைவர் பி. நரசிம்மன்', 'affiliation' => 'இணைப் பேராசிரியர், ஸ்ரீ ராமகிருஷ்ணா கலை மற்றும் அறிவியல் கல்லூரி, கோயம்புத்தூர், தமிழ்நாடு'],
                    ['topic' => 'மொபைல் விளையாட்டுகளில் செயற்கை நுண்ணறிவு அடிப்படையிலான அச்சுறுத்தல் கண்டறிதல்',   'name' => 'திருமதி ஏ. பூர்ணிமா', 'affiliation' => 'செயல்பாட்டுத் தலைவர், ஸ்ப்ரவுட் நாலெட்ஜ் சொல்யூஷன்ஸ் பிரைவேட் லிமிடெட், கோயம்புத்தூர், தமிழ்நாடு'],
                    ['topic' => 'விளையாட்டுப் பயன்பாட்டில் நடத்தை அடிப்படையிலான அபாயத் தணிப்பு',                   'name' => 'திரு. பிரஷாந்த் ரகு', 'affiliation' => 'தலைமைச் செயல்பாட்டு அதிகாரி, சுதர்ஷனா செமிகண்டக்டர்ஸ் பிரைவேட் லிமிடெட், பெங்களூரு, கர்நாடகா'],
                    ['topic' => 'மொபைல் விளையாட்டு தளங்களில் தீங்கிழைக்கும் மென்பொருள் தடுப்பு',                    'name' => 'திரு. எஸ். கல்யாணராமன்', 'affiliation' => 'உதவி மேலாளர், கிளவுட் சேவைகள் வழங்கல், நோவென்டிக் டெக்னாலஜீஸ், பெங்களூரு, கர்நாடகா'],
                ],
            ],
            [
                'heading' => 'பதிவு விவரங்கள்',
                'type' => 'registration',
                'link' => ['label' => 'https://atalacademy.aicte.gov.in/login', 'url' => 'https://atalacademy.aicte.gov.in/login'],
                'application_no' => '2277957180',
                'notes' => [
                    'இளங்கலை மாணவர்கள், முதுநிலை மாணவர்கள், ஆராய்ச்சி அறிஞர்கள், ஆசிரியர்கள் மற்றும் தொழில்துறை நிபுணர்கள் கலந்து கொள்ளலாம்.',
                    'பதிவு கட்டணம் எதுவும் இல்லை. அனைத்து பங்கேற்பாளர்களுக்கும் பங்கேற்பாளர் தொகுப்பு, சிற்றுண்டி மற்றும் மதிய உணவு வழங்கப்படும்.',
                    'அனைத்து பங்கேற்பாளர்களும் AICTE ATAL FDP இணையதளத்தின் மூலம் கட்டாயமாகப் பதிவு செய்ய வேண்டும்.',
                    'முதலில் பதிவு செய்பவர்களுக்கு முன்னுரிமை வழங்கப்படும்.',
                    'அனைத்து பங்கேற்பாளர்களுக்கும் நேரடி பங்கேற்பு கட்டாயமாகும்.',
                ],
            ],
            [
                'heading' => 'முதன்மை புரவலர்கள்',
                'type' => 'list',
                'items' => [
                    'முனைவர் மதன் ஆ. செந்தில் – வேந்தர், ரத்தினம் குளோபல் (நிகர்நிலைப் பல்கலைக்கழகம்); தலைவர், ரத்தினம் கல்விக் குழுமம்; தலைமைச் செயல்பாட்டு அதிகாரி, ரத்தினம் நிறுவனக் குழுமம்.',
                    'திருமதி ஷீமா செந்தில் – இயக்குநர் மற்றும் அறங்காவலர், ரத்தினம் கல்விக் குழுமம்.',
                    'முனைவர் ஆர். மாணிக்கம் – தலைவர், ரத்தினம் கல்விக் குழுமம்; தலைமை இயக்க அலுவலர் (COO), ரத்தினம் நிறுவனக் குழுமம்.',
                    'முனைவர் பி. நாகராஜ் – பொறுப்புத் துணைவேந்தர், ரத்தினம் குளோபல் (நிகர்நிலைப் பல்கலைக்கழகம்); துணைத் தலைவர், ரத்தினம் கல்விக் குழுமம்; தலைமை வணிக அதிகாரி (CBO), ரத்தினம் நிறுவனக் குழுமம்.',
                ],
            ],
            [
                'heading' => 'புரவலர்கள்',
                'type' => 'list',
                'items' => [
                    'முனைவர் சி. கிருஷ்ணராஜ் – பதிவாளர், ரத்தினம் குளோபல் (நிகர்நிலைப் பல்கலைக்கழகம்).',
                    'முனைவர் எஸ். தினகரன் – துணைப் பதிவாளர், ரத்தினம் குளோபல் (நிகர்நிலைப் பல்கலைக்கழகம்).',
                    'முனைவர் கே. பி. வி. சயரீஷ் – இயக்குநர் – ஆராய்ச்சி மற்றும் மேம்பாடு.',
                ],
            ],
            [
                'heading' => 'ஒருங்கிணைப்பாளர் மற்றும் இணை ஒருங்கிணைப்பாளர்',
                'type' => 'list',
                'items' => [
                    'முனைவர் ஜெ. ராம்குமார் – இணைப் பேராசிரியர், செயற்கை நுண்ணறிவு. கைபேசி: +91 8667352728. மின்னஞ்சல்: ramkumar.cs@rathinam.in',
                    'முனைவர் எஸ். மாணிகண்டன் – புல முதன்மையர், குவாண்டம் அறிவியல், கணினியியல் மற்றும் செயற்கை நுண்ணறிவுப் புலம். மின்னஞ்சல்: manikandan.rtc@rathinam.in',
                ],
            ],
            [
                'heading' => 'குழு உறுப்பினர்கள்',
                'type' => 'list',
                'items' => [
                    'முனைவர் கே. அருண் குமார் – துணைப் புல முதன்மையர், குவாண்டம் அறிவியல், கணினியியல் மற்றும் செயற்கை நுண்ணறிவுப் புலம்.',
                    'முனைவர் அ. உத்திரமூர்த்தி – தலைவர் – RSmart துறை.',
                    'முனைவர் டி. விமல்குமார் – துறைத்தலைவர், செயற்கை நுண்ணறிவுத் துறை.',
                    'முனைவர் ச. ராஜா – துறைத்தலைவர், கணினியியல் துறை.',
                    'முனைவர் எஸ். கார்த்திகேயன் – துறைத்தலைவர் – கணினி மற்றும் இணையப் பாதுகாப்புத் துறை.',
                    'ரா. உதய நிர்மலா மேரி – பொறுப்புத் துறைத்தலைவர், தகவல் தொழில்நுட்பத் துறை.',
                ],
            ],
            [
                'heading' => 'தொடர்பு',
                'type' => 'contact',
                'phone' => '+91 8667352728, +91 9940625080',
                'website' => 'https://rathinamcollege.ac.in/',
                'email' => 'ramkumar.cs@rathinam.in',
            ],
        ],
    ],

];
