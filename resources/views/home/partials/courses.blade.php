<section id="courses" class="my-10 mx-auto px-4 sm:px-6 lg:px-8">

    <div class="flex items-center gap-2 rounded-full border border-purple-700/20 bg-purple-700/10 px-[18px] py-[7px] mb-[22px] w-max mx-auto">

        <!-- Pulse Dot -->
        <span class="h-[6px] w-[6px] rounded-full bg-purple-700 animate-pulse"></span>

        <!-- Text -->
        <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-purple-700">
            Your Future Awaits
        </span>
    </div>
    <h1 class="text-4xl md:text-6xl font-extrabold text-center mb-0 md:mb-10 relative z-10">
        Courses &amp; Programs at <span class="x-xuvfsgtn">Rathinam Global University</span>
    </h1>
    <!-- Background Blobs -->
    <div class="bg-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <!-- Main Container -->
    <main class="portal-container">
        <!-- Categories Grid/Asymmetric Layout -->
        <section class="categories-layout" id="categories-container">
            <!-- Centered Search -->
            <header class="search-section">
                <div class="search-box-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" id="programme-search" placeholder="Search programmes, schools..."
                        aria-label="Search programmes">
                </div>
            </header>

            <!-- Card 1: Top Left -->
            <div class="card-wrapper x-1d9ixa3l" data-category="Quantum Science, Computing & AI">
                <article class="category-card x-1k699ech" id="card-computing">
                    <div class="card-header">
                        <div class="icon-box gradient-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/></svg>
                        </div>
                        <span class="programme-count text-white">13 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Quantum Science, Computing & AI</h3>
                    <a href="{{ route('schools.show', 'school-of-quantum-science') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">Machine Learning</span>
                    <span class="chip">Data Science</span>
                </div>
            </div>

            <!-- Card 2: Top Center -->

            <!-- Card 3: Top Right -->
            <div class="card-wrapper x-18o99bx1" data-category="Business & Commerce">
                <article class="category-card x-1xoqyzrs" id="card-business">
                    <div class="card-header">
                        <div class="icon-box gradient-green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                        </div>
                        <span class="programme-count text-white">36 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Business & Commerce</h3>
                    <a href="{{ route('schools.show', 'school-of-business-and-commerce') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">FinTech</span>
                    <span class="chip">Startups</span>
                </div>
            </div>


            <!-- Card 5: Bottom Right -->
            <div class="card-wrapper x-1dhydh11" data-category="Applied Biosciences / Food / Agritech"
               >
                <article class="category-card x-g81t23xk" id="card-bio">
                    <div class="card-header">
                        <div class="icon-box gradient-pink">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19.2 2.96a1 1 0 0 1 1.8.66 13.7 13.7 0 0 1-2.4 9.39"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg>
                        </div>
                        <span class="programme-count text-white">5 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Applied Biosciences / Food / Agritech</h3>
                    <a href="{{ route('schools.show', 'school-of-applied-biosciences') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">Genetics</span>
                    <span class="chip">AgriTech</span>
                </div>
            </div>

            <!-- Card 6: Bottom Center -->
            <div class="card-wrapper x-i5d2dwak" data-category="Liberal Arts & Science">
                <article class="category-card x-1zkpbbwy" id="card-liberal">
                    <div class="card-header">
                        <div class="icon-box gradient-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        </div>
                        <span class="programme-count text-white">11 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Liberal Arts & Science</h3>
                    <a href="{{ route('schools.show', 'school-of-liberal-arts-science') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">Psychology</span>
                    <span class="chip">Philosophy</span>
                    <span class="chip">Physics</span>
                </div>
            </div>

            <!-- Card 7: Bottom Left -->
            <div class="card-wrapper x-djq6h1nb" data-category="Media & Performing Arts">
                <article class="category-card x-24hzjgfv" id="card-design">
                    <div class="card-header">
                        <div class="icon-box gradient-pink">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                        </div>
                        <span class="programme-count text-white">4 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Media & Performing Arts</h3>
                    <a href="{{ route('schools.show', 'school-of-media-and-performing-arts') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">UI/UX</span>
                    <span class="chip">Animation</span>
                </div>
            </div>

            <!-- Card 8: Left -->
            <div class="card-wrapper x-1vj1toh3" data-category="Fashion Design">
                <article class="category-card x-xpkhw3hi" id="card-health">
                    <div class="card-header">
                        <div class="icon-box gradient-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.5.5 0 0 1-.96 0L9.24 2.18a.5.5 0 0 0-.96 0l-2.35 8.36A2 2 0 0 1 4 12H2"/></svg>
                        </div>
                        <span class="programme-count text-white">5 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Fashion Design</h3>
                    <a href="{{ route('schools.show', 'school-of-fashion-design') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">Medicine</span>
                    <span class="chip">Neuro</span>
                </div>
            </div>
            <!-- Card 9: Sports & Health Sciences -->
            <div class="card-wrapper x-1c39x7tl" data-category="Sports & Health Sciences">
                <article class="category-card x-1aqjxdaw" id="card-sports">
                    <div class="card-header">
                        <div class="icon-box gradient-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.5.5 0 0 1-.96 0L9.24 2.18a.5.5 0 0 0-.96 0l-2.35 8.36A2 2 0 0 1 4 12H2"/></svg>
                        </div>
                        <span class="programme-count text-white">4 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Sports & Health Sciences</h3>
                    <a href="{{ route('schools.show', 'school-of-sports-and-health-sciences') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">Psychology</span>
                    <span class="chip">Clinical</span>
                </div>
            </div>

            <!-- Card 10: Sustainability & Climate Studies -->
            <div class="card-wrapper x-102hinc8" data-category="Sustainability & Climate Studies">
                <article class="category-card x-1bizzp2h" id="card-sustainability">
                    <div class="card-header">
                        <div class="icon-box gradient-cyan">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19.2 2.96a1 1 0 0 1 1.8.66 13.7 13.7 0 0 1-2.4 9.39"/><path d="M2 21c0-3 1.85-5.36 5.08-6"/></svg>
                        </div>
                        <span class="programme-count text-white">2 Programmes</span>
                    </div>
                    <h3 class="card-title text-white">Sustainability & Climate Studies</h3>
                    <a href="{{ route('schools.show', 'school-of-sustainability-and-climate-studies') }}"
                       class="more-details inline-flex items-center gap-1 mt-1 text-[11px] font-semibold text-white/80 hover:text-white transition"
                       onclick="event.stopPropagation()">
                        More Details &#x2192;
                    </a>
                </article>
                <div class="chips-container">
                    <span class="chip">Environment</span>
                    <span class="chip">Climate Policy</span>
                </div>
            </div>
        </section>

        <!-- Course Details Showcase -->
        <section class="course-details-section" id="course-details-section">
            <h3 class="related-title">Course Showcase</h3>
            <div class="details-grid" id="details-grid">
                <article class="course-detail-panel" data-category="Quantum Science, Computing & AI">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Artificial Intelligence and Machine Learning</li>
                                <li>B.Sc Computer Science</li>
                                <li>B.Sc Computer Science (AI & Data Science)</li>
                                <li>B.Sc Computer Science (Artificial Intelligence)</li>
                                <li>B.Sc Computer Science (Cyber Security)</li>
                                <li>B.Sc Computer Technology (Generative AI)</li>
                                <li>B.Sc Digital and Cyber Forensics Science</li>
                                <li>B.Sc Information Technology</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>BCA PROGRAMMES</h4>
                            <ul>
                                <li>BCA</li>
                                <li>BCA (Artificial Intelligence)</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">3</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.Sc Artificial Intelligence and Data Science</li>
                                <li>M.Sc Computer Science</li>
                                <li>M.Sc Data Science and Business Analytics</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Engineering & Emerging Technologies">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>UNDERGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>B.E Computer Science Engineering</li>
                                <li>B.E CSE Artificial Intelligence and Machine Learning</li>
                                <li>B.E CSE Cyber Security</li>
                                <li>B.E CSE Regional Language</li>
                                <li>B.E ECE</li>
                                <li>B.E Mech</li>
                                <li>B.E Mechatronics</li>
                                <li>B.Tech AIDS</li>
                                <li>B.Tech BioTechnology</li>
                                <li>B.Tech Information Technology</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Business & Commerce">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>BBA PROGRAMMES</h4>
                            <ul>
                                <li>BBA General</li>
                                <li>BBA Aviation Management</li>
                                <li>BBA Computer Applications</li>
                                <li>BBA Logistics</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>B.COM PROGRAMMES</h4>
                            <ul>
                                <li>B.Com Accounting & Finance</li>
                                <li>B.Com Banking & Insurance</li>
                                <li>B.Com Business Process Services</li>
                                <li>B.Com Corporate Secretorship</li>
                                <li>B.Com Financial Services</li>
                                <li>B.Com Information Technology</li>
                                <li>B.Com International Business</li>
                                <li>B.Com Professional Accounting</li>
                                <li>B.Com Professional Accounting (CA Training)</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">3</div>
                            <h4>B.COM — AI & PROFESSIONAL SPECIALIZATIONS</h4>
                            <ul>
                                <li>B.Com Computer Applications (Business Intelligence & AI)</li>
                                <li>B.Com Computer Applications (AI-Ready Accountant)</li>
                                <li>B.Com Financial Services (AI-Ready Account Analyst)</li>
                                <li>B.Com Financial Services (Public Accountant)</li>
                                <li>B.Com IT (Accounting Analytics)</li>
                                <li>B.Com International Business (AI-Ready Business Analyst)</li>
                                <li>B.Com Professional Accounting (Chartered Accountant)</li>
                                <li>B.Com (AI-Ready Accountant)</li>
                                <li>B.Com (ACCA)</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">4</div>
                            <h4>M.COM PROGRAMMES</h4>
                            <ul>
                                <li>M.Com Computer Applications (AI-Ready Accountant)</li>
                                <li>M.Com General (Guaranteed Internship)</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">5</div>
                            <h4>MBA PROGRAMMES</h4>
                            <ul>
                                <li>MBA General</li>
                                <li>MBA in Business Analytics and Artificial Intelligence</li>
                                <li>MBA in Marketing</li>
                                <li>MBA in Finance</li>
                                <li>MBA in Human Resource</li>
                                <li>MBA in Supply Chain and Logistics</li>
                                <li>MBA in Sustainability Management</li>
                                <li>MBA in AI Product Management</li>
                                <li>MBA in Entrepreneurship 5.0</li>
                                <li>MBA in Media & Entertainment Management</li>
                                <li>MBA in Sports Management</li>
                                <li>MBA Hospitality</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Applied Biosciences / Food / Agritech">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.TECH PROGRAMMES</h4>
                            <ul>
                                <li>B.Tech BioTechnology</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Biotechnology</li>
                                <li>B.Sc Microbiology</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">3</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.Sc Microbiology</li>
                                <li>M.Sc BioTechnology</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Liberal Arts & Science">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Mathematics</li>
                                <li>B.Sc Physics</li>
                                <li>B.Sc Psychology</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>B.A PROGRAMMES</h4>
                            <ul>
                                <li>B.A English Literature</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">3</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.A English Literature</li>
                                <li>M.A Public Administration</li>
                                <li>M.Sc Mathematics</li>
                                <li>M.Sc Applied Psychology</li>
                                <li>M.Sc Clinical Psychology</li>
                                <li>M.Sc Counselling Psychology</li>
                                <li>Post Graduate Diploma in Counselling</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Media & Performing Arts">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Visual Communication (AI-Ready Animation & VFX Design)</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>B.A PROGRAMMES</h4>
                            <ul>
                                <li>B.A Journalism & Mass Communication</li>
                                <li>B.A Theatre & Performing Arts</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">3</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.A Journalism and Mass Communication</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Fashion Design">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.TECH PROGRAMMES</h4>
                            <ul>
                                <li>B.Tech Fashion Technology</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Fashion Design</li>
                                <li>B.Sc Costume Design & Fashion</li>
                                <li>B.Sc Textile Design & Merchandising</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">3</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.Sc Fashion Design & Retail Management</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Sports & Health Sciences">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Psychology</li>
                                <li>B.Sc MicroBiology with GIP</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.Sc Applied Psychology</li>
                                <li>M.Sc Clinical Psychology</li>
                            </ul>
                        </div>
                    </div>
                </article>
                <article class="course-detail-panel" data-category="Sustainability & Climate Studies">
                    <div class="details-columns">
                        <div class="details-column">
                            <div class="detail-number">1</div>
                            <h4>B.SC PROGRAMMES</h4>
                            <ul>
                                <li>B.Sc Environmental Science & Sustainability</li>
                            </ul>
                        </div>
                        <div class="details-column">
                            <div class="detail-number">2</div>
                            <h4>POSTGRADUATE PROGRAMMES</h4>
                            <ul>
                                <li>M.Sc Climate Change & Policy</li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <!-- Particles Container -->
    <div class="particles" id="particles-container"></div>

    <script>
        // Lucide icons are now inlined as SVGs above — no runtime needed.

        // Background particles: skip on small screens and when user prefers reduced motion.
        // Also defer to idle time so it never blocks the main thread during page load.
        (function () {
          var container = document.getElementById('particles-container');
          if (!container) return;
          if (window.innerWidth < 768) return;
          if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
          var run = function () {
            for (var i = 0; i < 20; i++) {
              var p = document.createElement('div');
              p.className = 'particle';
              p.style.left = Math.random() * 100 + '%';
              p.style.top = Math.random() * 100 + '%';
              var size = Math.random() * 6 + 2 + 'px';
              p.style.width = size; p.style.height = size;
              p.style.animationDelay = Math.random() * 15 + 's';
              p.style.animationDuration = Math.random() * 10 + 10 + 's';
              container.appendChild(p);
            }
          };
          if ('requestIdleCallback' in window) requestIdleCallback(run, { timeout: 2000 });
          else setTimeout(run, 1500);
        })();
    </script>

</section>