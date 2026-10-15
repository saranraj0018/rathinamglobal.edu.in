@extends('layouts.app')

@section('title', 'IQAC | RGU')

@push('head')

    <style>body{margin:0!important;padding:0!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ versioned_asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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
                radial-gradient(circle at 80% 70%, rgba(126, 34, 206, 0.18), transparent 50%);
            pointer-events: none;
        }

        .hero-title {
            font-weight: 700;
            text-shadow: 0 0 22px rgba(255, 255, 255, 0.35);
        }

        .iqac-section {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.07);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .iqac-title {
            background: linear-gradient(90deg, #7e22ce 0%, #0284c7 100%);
            color: #fff;
            border-radius: 14px 14px 0 0;
            padding: 1.1rem 1.5rem;
            font-weight: 700;
            letter-spacing: .3px;
            font-size: 1.15rem;
        }

        .iqac-body {
            padding: 1.5rem 1.75rem;
        }

        .iqac-body p {
            color: #334155;
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .iqac-body ul.points {
            list-style: none;
            padding: 0;
            margin: .5rem 0 0;
        }

        .iqac-body ul.points li {
            position: relative;
            padding: .55rem 0 .55rem 1.75rem;
            color: #334155;
            line-height: 1.7;
            border-bottom: 1px dashed #e2e8f0;
        }

        .iqac-body ul.points li:last-child {
            border-bottom: none;
        }

        .iqac-body ul.points li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 1rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7e22ce, #0284c7);
            box-shadow: 0 0 10px rgba(126, 34, 206, 0.4);
        }

        .intro-block {
            border-left: 4px solid #7e22ce;
            background: #f8f2fe;
            padding: 1.25rem 1.5rem;
            border-radius: 0 10px 10px 0;
        }
    </style>
@endpush

@section('content')

    <!-- ===== HERO ===== -->
    <section class="page-hero px-4 md:px-10 py-14 md:py-20 text-center">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="uppercase tracking-[0.3em] text-purple-300 text-xs md:text-sm mb-3">Rathinam Global (Deemed to be University)</p>
            <h1 class="hero-title text-3xl md:text-5xl lg:text-6xl">Internal Quality Assurance Cell</h1>
            <p class="mt-4 md:mt-6 text-gray-300 text-sm md:text-base max-w-3xl mx-auto">
                Driving conscious, consistent, and catalytic improvement in the overall performance of the institution.
            </p>
        </div>
    </section>

    <!-- ===== CONTENT ===== -->
    <main class="max-w-6xl mx-auto px-4 md:px-6 py-10 md:py-16 space-y-10">

        <!-- About IQAC -->
        <section class="iqac-section">
            <div class="iqac-title">About IQAC</div>
            <div class="iqac-body">
                <div class="intro-block">
                    <p class="mb-0">In pursuance of its Action Plan for performance evaluation, assessment and accreditation and quality up-gradation of institutions of higher education, the National Assessment and Accreditation Council (NAAC), Bangalore propose that every accredited institution should establish an Internal Quality Assurance Cell (IQAC) as a post-accreditation quality sustenance measure. Since quality enhancement is a continuous process, the IQAC will become a part of the institution&rsquo;s system and work towards the realization of the goals of quality enhancement and sustenance. The prime task of the IQAC is to develop a system for conscious, consistent, and catalytic improvement in the overall performance of institutions. For this, during the post-accreditation period, it will channelize all efforts and measures of the institution towards promoting its holistic academic excellence.</p>
                </div>
            </div>
        </section>

        <!-- Objective -->
        <section class="iqac-section">
            <div class="iqac-title">Objective</div>
            <div class="iqac-body">
                <p>The primary aim of IQAC is</p>
                <ul class="points">
                    <li>To develop a system for conscious, consistent, and catalytic action to improve the academic and administrative performance of the institution.</li>
                    <li>To promote measures for institutional functioning towards quality enhancement through internalization of quality culture and institutionalization of best practices.</li>
                </ul>
            </div>
        </section>

        <!-- Strategies -->
        <section class="iqac-section">
            <div class="iqac-title">Strategies</div>
            <div class="iqac-body">
                <p>IQAC shall evolve mechanisms and procedures for</p>
                <ul class="points">
                    <li>Ensuring timely, efficient, and progressive performance of academic, administrative, and financial tasks;</li>
                    <li>The relevance and quality of academic and research programs;</li>
                    <li>Equitable access to and affordability of academic programs for various sections of society;</li>
                    <li>Optimization and integration of modern methods of teaching and learning;</li>
                    <li>The credibility of evaluation procedures;</li>
                    <li>Ensuring the adequacy, maintenance, and proper allocation of support structure and services;</li>
                    <li>Sharing of research findings and networking with other institutions in India and abroad.</li>
                </ul>
            </div>
        </section>

        <!-- Functions -->
        <section class="iqac-section">
            <div class="iqac-title">Functions</div>
            <div class="iqac-body">
                <p>Some of the functions expected of the IQAC are:</p>
                <ul class="points">
                    <li>Development and application of quality benchmarks/parameters for various academic and administrative activities of the institution;</li>
                    <li>Facilitating the creation of a learner-centric environment conducive to quality education and faculty maturation to adopt the required knowledge and technology for participatory teaching and learning process;</li>
                    <li>Arrangement for feedback response from students, parents, and other stakeholders on quality-related institutional processes;</li>
                    <li>Dissemination of information on various quality parameters of higher education;</li>
                    <li>Organization of inter and intra institutional workshops, seminars on quality related themes and promotion of quality circles;</li>
                    <li>Documentation of the various programs/activities leading to quality improvement;</li>
                    <li>Acting as a nodal agency of the Institution for coordinating quality-related activities, including adoption and dissemination of best practices;</li>
                    <li>Development and maintenance of institutional database through MIS for the purpose of maintaining /enhancing the institutional quality;</li>
                    <li>Development of Quality Culture in the institution;</li>
                    <li>Preparation of the Annual Quality Assurance Report (AQAR) as per guidelines and parameters of NAAC, to be submitted to NAAC.</li>
                </ul>
            </div>
        </section>

        <!-- Benefits -->
        <section class="iqac-section">
            <div class="iqac-title">Benefits</div>
            <div class="iqac-body">
                <p>IQAC will facilitate / contribute</p>
                <ul class="points">
                    <li>Ensure heightened level of clarity and focus in institutional functioning towards quality enhancement;</li>
                    <li>Ensure internalization of the quality culture; Ensure enhancement and coordination among various activities of the institution and institutionalize all good practices;</li>
                    <li>Provide a sound basis for decision-making to improve institutional functioning;</li>
                    <li>Act as a dynamic system for quality changes in HEIs;</li>
                    <li>Build an organized methodology of documentation and internal communication.</li>
                </ul>
            </div>
        </section>

    </main>
@endsection
