@extends('layouts.app')

@section('title', 'Non Statutory Committees | RGU')

@push('head')

    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --rgu-deep: #050b1f;
            --rgu-blue: #0b1538;
            --rgu-accent: #4f7cff;
        }

        body {
            font-family: 'Outfit', 'Sora', sans-serif;
            background: #ffffff;
            color: #1e293b;
        }

        .page-hero {
            background: radial-gradient(ellipse at top, #0e1d4a 0%, #050b1f 60%, #02050f 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.08), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(79, 124, 255, 0.15), transparent 50%);
            pointer-events: none;
        }

        .hero-title {
            font-weight: 700;
            text-shadow: 0 0 22px rgba(255, 255, 255, 0.35);
        }

        .committee-section {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.07);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .committee-title {
            background: linear-gradient(90deg, #7e22ce 0%, #0284c7 100%);
            color: #fff;
            border-radius: 14px 14px 0 0;
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .committee-body {
            padding: 1.5rem;
        }

        .committee-body p {
            color: #334155;
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        table.rgu-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        table.rgu-table thead tr {
            background: linear-gradient(90deg, #7e22ce 0%, #0284c7 100%);
        }

        table.rgu-table thead th {
            background: transparent;
            color: #fff;
            text-align: left;
            padding: .85rem 1rem;
            font-weight: 600;
            font-size: .9rem;
            letter-spacing: .3px;
        }

        table.rgu-table tbody td {
            padding: .8rem 1rem;
            border-top: 1px solid #e2e8f0;
            color: #1e293b;
        }

        table.rgu-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        table.rgu-table tbody tr:hover {
            background: #f8f2fe;
        }

        .note-box {
            background: #f8f2fe;
            border-left: 4px solid #7e22ce;
            padding: 1rem 1.25rem;
            border-radius: 0 8px 8px 0;
            margin-top: 1rem;
            color: #334155;
        }

        .note-box strong {
            color: #7e22ce;
        }

        .contact-list {
            margin-top: .75rem;
        }

        .contact-list li {
            padding: .35rem 0;
            color: #334155;
        }

        a.link {
            color: #7e22ce;
            text-decoration: underline;
        }

        .nav-bar {
            background: rgba(5, 11, 31, 0.95);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 50;
        }
    </style>
@endpush

@section('content')

    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="uppercase tracking-[0.3em] text-blue-300 text-xs md:text-sm mb-3">Rathinam Global (Deemed to be University)</p>
            <h1 class="hero-title text-3xl md:text-5xl lg:text-6xl">Non Statutory Committees</h1>
            <p class="mt-4 md:mt-6 text-gray-300 text-sm md:text-base max-w-3xl mx-auto">
                Committees constituted to strengthen quality, innovation, welfare, communication and student support across the University.
            </p>
        </div>
    </section>

    <!-- ===== CONTENT ===== -->
    <main class="max-w-6xl mx-auto px-4 md:px-6 py-10 md:py-16 space-y-10">

        <!-- 1. IPR Cell -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Intellectual Property Rights (IPR) Cell</div>
            <div class="committee-body">
                <p>The Intellectual Property Rights (IPR) Cell of Rathinam Global (Deemed to be University) is established to promote awareness, protection, management, and commercialization of intellectual property generated through research, innovation, creativity, and academic activities within the University.</p>
                <p>The institution shall constitute an Intellectual Property Rights Cell with the following members:</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S. No.</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1.</td><td>Dr. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2.</td><td>Dr. K P V. Sabareesh</td><td>Director of Research &amp; Development</td><td>Convener</td></tr>
                            <tr><td>3.</td><td>Dr. S. Karthikeyan</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>4.</td><td>Dr. G. Arutgeevitha</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>5.</td><td>Ms. B. Mohanapriya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>6.</td><td>Ms. V. Parimala Devi</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>7.</td><td>Ms. G. Gayathiri</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>8.</td><td>Ms. M. Agnes Monisha</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>9.</td><td>Mr. S. Ramesh</td><td>Assistant Professor</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 2. IEDC -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Innovation and Entrepreneurship Development Cell (IEDC)</div>
            <div class="committee-body">
                <p>The Innovation and Entrepreneurship Development Cell (IEDC) of Rathinam Global (Deemed to be University) is established to promote innovation, creativity, entrepreneurial thinking, and sustainable development among students and faculty members. The cell serves as a platform to nurture innovative ideas, encourage startup culture, strengthen industry interaction, and develop problem-solving abilities through experiential learning activities.</p>
                <p>The institution shall constitute an IEDC with the following members:</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S. No.</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Dr. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2</td><td>Mr. R. Anjit Raja</td><td>Director of Innovation and Entrepreneurship</td><td>Convener</td></tr>
                            <tr><td>3</td><td>Mr. Sobin Sebastian</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>4</td><td>Dr. J. John Manohar</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>5</td><td>Dr. R. Manimegalai</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>6</td><td>Dr. C. Kanagaraj</td><td>Associate Dean</td><td>Member</td></tr>
                            <tr><td>7</td><td>Mr. R. Sathish Kumar</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>8</td><td>Mr. Bayas Ahamed</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>9</td><td>Ms. T. B. Stelcy Mariya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>10</td><td>Dr. S. Joicsy</td><td>Assistant Professor</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 3. Media and Public Relations Cell -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Media and Public Relations Cell</div>
            <div class="committee-body">
                <p>The Media and Public Relations Cell of &ldquo;Rathinam Global (Deemed to be University)&rdquo; plays a vital role in establishing and strengthening the institution&rsquo;s public image, communication network, and media presence. In today&rsquo;s digital and information-driven environment, educational institutions require an effective communication system to disseminate achievements, events, research activities, student accomplishments, and institutional developments to stakeholders and society.</p>
                <p>The institution shall constitute with the following members:</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S No</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Dr. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2</td><td>Mr. V. Sathishanandan</td><td>Director of Events and Promotions</td><td>Convener</td></tr>
                            <tr><td>3</td><td>Dr. T. J. Raju</td><td>Associate Dean</td><td>Member</td></tr>
                            <tr><td>4</td><td>Mr. Bayas Ahamed Sulaiman</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>5</td><td>Ms. G. Gayathiri</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>6</td><td>Ms. A. Divya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>7</td><td>Mr. K. Athreya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>8</td><td>Mr. Kailash Tharayil</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>9</td><td>Mr. S. Saravanan</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>10</td><td>Ms. R. D. Sri JayaDurga</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>11</td><td>Mr. M. Vignesh</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>12</td><td>Ms. A. Hemalatha</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>13</td><td>Dr. K. Prabhakaran</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>14</td><td>Dr. S. Latha</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>15</td><td>Dr. R. Saradha</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>16</td><td>Ms. Sandhya</td><td>Assistant Professor</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 4. Anti-Ragging Committee -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Anti-Ragging Committee</div>
            <div class="committee-body">
                <p>As per the directions of the University Grants Commission (UGC) and in compliance with the Ragging Prohibition Act 2011, Rathinam Global (Deemed to be University) has a Zero Tolerance Policy towards ragging. &ldquo;Ragging&rdquo; includes physical, mental, or psychological harassment of students. It is a criminal offense and strictly prohibited.</p>
                <p>The anti-ragging Committee for the academic year 2026-27 is revised with the following members.</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S No</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Dr. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2</td><td>Dr Saravanakumar A</td><td>Assistant Professor &amp; HoD</td><td>Convener</td></tr>
                            <tr><td>3</td><td>Dr. T. Velumani</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>4</td><td>Dr. V. T. Dhanaraj</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>5</td><td>Dr. T. Pratheep</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>6</td><td>Dr. K. Sankar</td><td>Assistant Professor &amp; HoD</td><td>Member</td></tr>
                            <tr><td>7</td><td>Dr. T. J. Raju</td><td>Associate Dean</td><td>Member</td></tr>
                            <tr><td>8</td><td>Dr. S. Aruna</td><td>Associate Dean</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="note-box">
                    <strong>Consequences of Ragging:</strong>
                    <ul class="list-disc pl-5 mt-2">
                        <li>Strict disciplinary action, including suspension or expulsion.</li>
                        <li>Legal action as per Section 4 of the Anti-Ragging Act.</li>
                    </ul>
                </div>

                <div class="note-box">
                    <strong>Report Ragging:</strong>
                    <p class="mt-2 mb-0">Students are encouraged to report any ragging incidents to the Anti-Ragging Committee through the following channels:</p>
                    <ul class="contact-list list-disc pl-5">
                        <li><strong>Helpline Number:</strong> 0422-4040900</li>
                        <li><strong>Email:</strong> helpdesk@rathinam.in</li>
                        <li><strong>Complaint Box:</strong> Located at the Admin Office</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 5. Grievance Redressal Committee -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Grievance Redressal Committee</div>
            <div class="committee-body">
                <p>The Online Grievance Redressal Committee is revised for the academic year 2026-27 and the following faculty are the members of the committee.</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S No</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Dr. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2</td><td>Dr T M Hemalatha</td><td>Dean- School of Commerce</td><td>Convener</td></tr>
                            <tr><td>3</td><td>Mr. M. Saravanakumar</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>4</td><td>Dr. M. Rajalakshmi</td><td>Associate Professor &amp; HoD</td><td>Member</td></tr>
                            <tr><td>5</td><td>Dr. Gnanasekar</td><td>Assistant Professor &amp; HoD</td><td>Member</td></tr>
                            <tr><td>6</td><td>Mr. K. Athreya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>7</td><td>Ms. A. Sandhya</td><td>Assistant Professor</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="note-box">
                    <strong>Role:</strong>
                    <p class="mt-2 mb-0">The Online Grievance Redressal Committee is to take care of the overall welfare of the student in terms of student development program, student publication, counselling of the students, co-curricular activities etc. as well as to address online and offline grievances raised by students related to general administration, and any other problems related to day-to-day functioning.</p>
                    <p class="mt-2 mb-0">Students shall represent the grievance through the online portal available in the College website:
                        <a class="link" href="https://rathinamcollege.ac.in/grievance-redressal/" target="_blank">https://rathinamcollege.ac.in/grievance-redressal/</a>
                    </p>
                </div>
            </div>
        </section>

        <!-- 6. Internal Complaints Committee -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Internal Complaints Committee</div>
            <div class="committee-body">
                <p>The Internal Complaints Committee for the academic year 2026-27 is revised with the following members:</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S No</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Dr N Parameswari</td><td>Assistant Professor &amp; HoD</td><td>Presiding Officer</td></tr>
                            <tr><td>2</td><td>Dr. M. Ramaraj</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>3</td><td>Dr. N. Rajendran</td><td>Associate Professor &amp; HoD</td><td>Member</td></tr>
                            <tr><td>4</td><td>Ms. K. V. Hridhya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>5</td><td>Dr. A. Seethalakshmy</td><td>Associate Dean</td><td>Member</td></tr>
                            <tr><td>6</td><td>Mr. Kailash Tharayil</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>7</td><td>Mr. R. Yuvaraj</td><td>Assistant Professor</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="note-box">
                    <p class="mt-0 mb-1">Complaint box located at Chanakya Block, Ground Floor</p>
                    <p class="mt-0 mb-1"><strong>Mobile:</strong> +91 &ndash; 95977 93123</p>
                </div>

                <div class="note-box">
                    <strong>Guidelines for Raising Complaints</strong>
                    <p class="mt-2 mb-1"><strong>Confidentiality Assured:</strong> All complaints will be handled with the utmost discretion.</p>
                    <p class="mt-2 mb-1"><strong>How to Lodge a Complaint:</strong></p>
                    <ul class="list-disc pl-5">
                        <li>Write to: <a class="link" href="mailto:icc@rathinam.in">icc@rathinam.in</a></li>
                        <li>Visit the ICC Office: Ground Floor &ndash; Information Centre</li>
                        <li>Use the suggestion box</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 7. SC/ST Committee -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">SC/ST Committee</div>
            <div class="committee-body">
                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S No</th><th>Name</th><th>Designation</th><th>Position</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Dr. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2</td><td>Dr. N. Parameshwari</td><td>HoD Tamil</td><td>Convener</td></tr>
                            <tr><td>3</td><td>Ms. M. Suriya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>4</td><td>Dr. M. Kousalya Devi</td><td>Associate Professor &amp; HoD</td><td>Member</td></tr>
                            <tr><td>5</td><td>Ms. R. Kavya</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>6</td><td>Ms. D. Jeyanthi Prasanna</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>7</td><td>Mr. S. Saravanan</td><td>Assistant Professor</td><td>Member</td></tr>
                            <tr><td>8</td><td>Mr. R. Yuvaraj</td><td>Assistant Professor</td><td>Member</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 8. IQAC -->
        <section class="committee-section">
            <div class="committee-title text-lg md:text-xl">Internal Quality Assurance Cell (IQAC)</div>
            <div class="committee-body">
                <p>The Internal Quality Assurance Cell (IQAC) of the University is constituted for the Academic Year 2026-27 with the following members to develop a system for conscious, consistent, and catalytic improvement in the overall performance of the institution and to promote quality enhancement initiatives.</p>

                <div class="overflow-x-auto">
                    <table class="rgu-table">
                        <thead>
                            <tr><th>S. No.</th><th>Name of the Member</th><th>Designation/Position</th><th>Role in IQAC</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>1.</td><td>Dr. C. Krishnaraj</td><td>Registrar</td><td>Chairperson</td></tr>
                            <tr><td>2.</td><td>Dr. R. Manickam</td><td>CEO</td><td>Management Representative</td></tr>
                            <tr><td>3.</td><td>Dr. S. Dhinakaran</td><td>Deputy Registrar</td><td>Senior Administrative Member</td></tr>
                            <tr><td>4.</td><td>Dr. S. Balasubramanian</td><td>Director &ndash; Research Programmes</td><td>Member</td></tr>
                            <tr><td>5.</td><td>Dr. KPV Sabareesh</td><td>Director &ndash; Research and Development</td><td>Member</td></tr>
                            <tr><td>6.</td><td>Dr. S. N. Suresh</td><td>Director &ndash; Ranking and Accreditation</td><td>Member</td></tr>
                            <tr><td>7.</td><td>Dr. B. Leena</td><td>Director &ndash; Academics</td><td>Member</td></tr>
                            <tr><td>8.</td><td>Dr. S. Sivasubramaniam</td><td>Director &ndash; Training and Placements</td><td>Member</td></tr>
                            <tr><td>9.</td><td>Dr. T. M. Hemalatha</td><td>Dean, School of Business and Commerce</td><td>Member</td></tr>
                            <tr><td>10.</td><td>Dr. S. Manikandan</td><td>Dean, School of Quantum Science, Computing and AI</td><td>Member</td></tr>
                            <tr><td>11.</td><td>Dr. V. Rajalakshmi</td><td>Dean, School of Fashion, Media and Performing Arts</td><td>Member</td></tr>
                            <tr><td>12.</td><td>Dr. Palanivel Rajan</td><td>Dean, School of Engineering and Emerging Technology</td><td>Member</td></tr>
                            <tr><td>13.</td><td>Dr. M. S. Pradeep Raj</td><td>Dean, School of Sustainability and Climate Studies</td><td>Member</td></tr>
                            <tr><td>14.</td><td>Dr. S. Krishnaprakash</td><td>Dean- School of Liberal Arts &amp; Science</td><td>Member</td></tr>
                            <tr><td>15.</td><td>Dr. S. Joicsy</td><td>Dean, School of Sports and Health Sciences</td><td>Member</td></tr>
                            <tr><td>16.</td><td>Mrs. Saranya Maheswari</td><td>Assistant Professor-Management UG</td><td>Member</td></tr>
                            <tr><td>17.</td><td>Dr. R. Saradha</td><td>Assistant Professor-English</td><td>Member</td></tr>
                            <tr><td>18.</td><td>Mr. G. Nandhakumar</td><td>Assistant Professor &ndash; English</td><td>Member</td></tr>
                            <tr><td>19.</td><td>Dr. M. Rajalakshmi</td><td>HoD-Microbiology</td><td>Member</td></tr>
                            <tr><td>20.</td><td>Mr. K. Rajagopal</td><td>Entrepreneur, Bangalore</td><td>Member, Industry</td></tr>
                            <tr><td>21.</td><td>Mr. R. Sundar</td><td>Retired DM &ndash; L&amp;T, Coimbatore</td><td>Member, Industry</td></tr>
                            <tr><td>22.</td><td>Mr. R. Rethina Rajan</td><td>Ex-Student President / I M.Sc Microbiology</td><td>Member, Student</td></tr>
                            <tr><td>23.</td><td>Mr Ananth Kumar A</td><td>III BBA Logistics</td><td>Member, Student</td></tr>
                            <tr><td>24.</td><td>Ms. S. Sruthi</td><td>Nimble Wireless Ltd (Alumni)</td><td>Member, Alumni</td></tr>
                            <tr><td>25.</td><td>Mr. Senthil</td><td>HR, Molecular Connections</td><td>Member, Employer</td></tr>
                            <tr><td>26.</td><td>Dr. P. Srinivasan</td><td>Director, IQAC</td><td>Member Secretary</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>
@endsection
