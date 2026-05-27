<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calculate your exact age in years, days, hours, minutes, and seconds.">
    <title>Exact Age Calculator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'card': '0 0 0 1px rgba(0,0,0,0.03), 0 2px 4px rgba(0,0,0,0.02), 0 12px 24px rgba(0,0,0,0.06)',
                        'glow': '0 0 40px -10px rgba(37, 99, 235, 0.35)',
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.5s ease-out forwards',
                        'fade-in': 'fadeIn 0.35s ease-out forwards',
                        'scale-in': 'scaleIn 0.4s ease-out forwards',
                        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.6' },
                        },
                    },
                },
            },
        };
    </script>
    <style>
        .bg-mesh {
            background-color: #f8fafc;
            background-image:
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(37, 99, 235, 0.06) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(99, 102, 241, 0.06) 0px, transparent 50%);
        }
        .stat-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px -8px rgba(37, 99, 235, 0.2);
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.2s;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
        .results-visible {
            overflow: hidden;
        }
        .seconds-ring {
            transition: stroke-dashoffset 0.3s linear;
        }
        .seconds-tick {
            animation: secondTick 0.4s ease-out;
        }
        @keyframes secondTick {
            0% { transform: scale(1); filter: brightness(1); }
            15% { transform: scale(1.015); filter: brightness(1.25); }
            100% { transform: scale(1); filter: brightness(1); }
        }
        .seconds-glow {
            background: radial-gradient(ellipse at center, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-mesh">

    <!-- Decorative blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-brand-400/10 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-indigo-400/10 blur-3xl"></div>
    </div>

    <!-- Centered layout -->
    <div id="calculator-view" class="relative min-h-full flex flex-col items-center justify-center px-4 py-10 sm:py-14">

        <!-- Main card -->
        <div class="w-full max-w-xl animate-fade-up">

            <!-- Header -->
            <header class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 text-white shadow-glow mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                    Exact Age Calculator
                </h1>
                <p class="mt-3 text-slate-500 text-sm sm:text-base leading-relaxed max-w-sm mx-auto">
                    Discover your precise age in years, days, hours, minutes &amp; seconds — updated live.
                </p>
            </header>

            <!-- Unified card container -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-card border border-white/80 overflow-hidden">

                <!-- Input section -->
                <section class="p-6 sm:p-8" aria-labelledby="input-heading">
                    <h2 id="input-heading" class="text-xs font-semibold uppercase tracking-widest text-brand-600 mb-5">
                        Date of Birth
                    </h2>

                    <form id="age-form" novalidate>
                        <div class="space-y-5">
                            <div>
                                <label for="dob" class="block text-sm font-semibold text-slate-700 mb-2.5">
                                    Enter Your Date of Birth
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="date"
                                        id="dob"
                                        name="dob"
                                        required
                                        aria-required="true"
                                        aria-describedby="dob-hint error-message"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-12 pr-4 py-3.5 text-slate-900
                                               focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10
                                               transition-all duration-200 text-base font-medium"
                                    >
                                </div>
                                <p id="dob-hint" class="mt-2 text-xs text-slate-400">
                                    Select your birth date using the calendar picker.
                                </p>
                            </div>

                            <div
                                id="error-message"
                                class="hidden flex items-start gap-2.5 rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-600"
                                role="alert"
                                aria-live="polite"
                                aria-hidden="true"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="error-text"></span>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 pt-1">
                                <button
                                    type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2.5 rounded-xl
                                           bg-gradient-to-r from-brand-600 to-brand-700 px-6 py-3.5
                                           text-sm font-bold text-white shadow-soft
                                           hover:from-brand-700 hover:to-brand-800 hover:shadow-glow
                                           focus:outline-none focus:ring-4 focus:ring-brand-500/20
                                           active:scale-[0.98] transition-all duration-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Calculate My Age
                                </button>
                                <button
                                    type="button"
                                    id="clear-btn"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-slate-200 bg-white px-6 py-3.5
                                           text-sm font-semibold text-slate-600
                                           hover:border-slate-300 hover:bg-slate-50
                                           focus:outline-none focus:ring-4 focus:ring-slate-200
                                           active:scale-[0.98] transition-all duration-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Clear
                                </button>
                            </div>
                        </div>
                    </form>
                </section>

            </div>

            <!-- Footer -->
            <footer class="mt-8 text-center">
                <p class="text-xs text-slate-400">
                    &copy; <?php echo date('Y'); ?> Exact Age Calculator.
                </p>
            </footer>

        </div>
    </div>

    <!-- Full-screen results overlay -->
    <section
        id="results"
        class="hidden fixed inset-0 z-50 flex flex-col bg-slate-950 animate-fade-in"
        aria-labelledby="results-heading"
        aria-hidden="true"
        aria-live="polite"
    >
        <!-- Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] rounded-full bg-brand-600/20 blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 w-[600px] h-[600px] rounded-full bg-indigo-600/15 blur-[100px]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_transparent_0%,_rgba(2,6,23,0.4)_100%)]"></div>
        </div>

        <!-- Top bar -->
        <header class="relative z-10 flex items-center justify-between px-5 sm:px-10 py-5 sm:py-6 border-b border-white/10">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h2 id="results-heading" class="text-lg sm:text-2xl font-extrabold text-white tracking-tight">Your Exact Age</h2>
                    <p class="text-xs sm:text-sm text-slate-400">Based on your local time zone</p>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-white/10 px-3 py-1.5 text-[11px] font-semibold text-brand-300 uppercase tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-400 animate-pulse-soft"></span>
                    Real-time
                </span>
                <button
                    type="button"
                    id="back-btn"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/10 border border-white/10 px-4 py-2.5
                           text-sm font-semibold text-white hover:bg-white/20
                           focus:outline-none focus:ring-2 focus:ring-white/30 transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back</span>
                </button>
            </div>
        </header>

        <!-- Stats grid - fills remaining screen -->
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center p-5 sm:p-10 lg:p-14 gap-5 sm:gap-6 lg:gap-8">
            <dl class="w-full max-w-6xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 animate-scale-in">

                <!-- Years - hero stat -->
                <div class="stat-item sm:col-span-2 lg:col-span-1 lg:row-span-2 rounded-3xl bg-gradient-to-br from-brand-500 via-brand-600 to-brand-800 p-8 sm:p-10 lg:p-12 text-center shadow-2xl shadow-brand-900/50 flex flex-col items-center justify-center min-h-[200px] lg:min-h-0">
                    <dt class="text-sm sm:text-base font-bold uppercase tracking-[0.2em] text-brand-200 mb-3">Years</dt>
                    <dd id="value-years" class="text-6xl sm:text-7xl lg:text-8xl font-extrabold text-white tabular-nums leading-none">0</dd>
                    <p class="mt-4 text-brand-200/70 text-sm">Full years lived</p>
                </div>

                <div class="stat-item rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 p-8 sm:p-10 text-center flex flex-col items-center justify-center min-h-[160px]">
                    <dt class="text-xs sm:text-sm font-bold uppercase tracking-[0.15em] text-slate-400 mb-3">Months</dt>
                    <dd id="value-months" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tabular-nums leading-none">0</dd>
                </div>

                <div class="stat-item rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 p-8 sm:p-10 text-center flex flex-col items-center justify-center min-h-[160px]">
                    <dt class="text-xs sm:text-sm font-bold uppercase tracking-[0.15em] text-slate-400 mb-3">Days</dt>
                    <dd id="value-days" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tabular-nums leading-none">0</dd>
                </div>

                <div class="stat-item rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 p-8 sm:p-10 text-center flex flex-col items-center justify-center min-h-[160px]">
                    <dt class="text-xs sm:text-sm font-bold uppercase tracking-[0.15em] text-slate-400 mb-3">Hours</dt>
                    <dd id="value-hours" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tabular-nums leading-none">0</dd>
                </div>

                <div class="stat-item rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 p-8 sm:p-10 text-center flex flex-col items-center justify-center min-h-[160px]">
                    <dt class="text-xs sm:text-sm font-bold uppercase tracking-[0.15em] text-slate-400 mb-3">Minutes</dt>
                    <dd id="value-minutes" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tabular-nums leading-none">0</dd>
                </div>

            </dl>

            <!-- Seconds - developed live counter -->
            <div id="seconds-panel" class="w-full max-w-6xl animate-scale-in">
                <div class="relative rounded-3xl border border-indigo-400/30 bg-gradient-to-r from-indigo-950/80 via-purple-950/60 to-indigo-950/80 backdrop-blur-md overflow-hidden shadow-2xl shadow-indigo-900/40">

                    <!-- Ambient glow -->
                    <div class="absolute inset-0 seconds-glow pointer-events-none" aria-hidden="true"></div>
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-indigo-400/60 to-transparent" aria-hidden="true"></div>

                    <div class="relative p-6 sm:p-8 lg:p-10">
                        <div class="flex flex-col lg:flex-row items-center gap-6 lg:gap-10">

                            <!-- Progress ring + current second -->
                            <div class="relative shrink-0 w-28 h-28 sm:w-32 sm:h-32">
                                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120" aria-hidden="true">
                                    <circle cx="60" cy="60" r="52" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="8"/>
                                    <circle id="seconds-ring" class="seconds-ring" cx="60" cy="60" r="52" fill="none"
                                            stroke="url(#ringGradient)" stroke-width="8" stroke-linecap="round"
                                            stroke-dasharray="326.73" stroke-dashoffset="326.73"/>
                                    <defs>
                                        <linearGradient id="ringGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#818cf8"/>
                                            <stop offset="100%" stop-color="#c084fc"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span id="value-current-second" class="text-3xl sm:text-4xl font-extrabold text-white tabular-nums leading-none">00</span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-300/80 mt-1">sec</span>
                                </div>
                            </div>

                            <!-- Main seconds display -->
                            <div class="flex-1 text-center lg:text-left min-w-0">
                                <div class="flex items-center justify-center lg:justify-start gap-2.5 mb-3">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-500/30 border border-indigo-400/30 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-indigo-200">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-400"></span>
                                        </span>
                                        Live Counter
                                    </span>
                                </div>
                                <dt class="text-xs sm:text-sm font-bold uppercase tracking-[0.2em] text-indigo-300/90 mb-2">Total Seconds Alive</dt>
                                <dd id="value-seconds" class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tabular-nums leading-none tracking-tight break-all">0</dd>
                                <p class="mt-3 text-sm text-indigo-300/60">Every second counts — updating in real time</p>
                            </div>

                            <!-- Live clock -->
                            <div class="shrink-0 w-full lg:w-auto rounded-2xl bg-white/5 border border-white/10 px-6 py-4 text-center lg:text-right min-w-[180px]">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Current Time</p>
                                <p id="live-clock" class="text-2xl sm:text-3xl font-extrabold text-white tabular-nums tracking-wide">00:00:00</p>
                                <p id="live-date" class="text-xs text-slate-400 mt-1 tabular-nums">—</p>
                            </div>

                        </div>

                        <!-- Second progress bar (within minute) -->
                        <div class="mt-6 sm:mt-8">
                            <div class="flex items-center justify-between text-[10px] font-semibold uppercase tracking-widest text-indigo-400/70 mb-2">
                                <span>Second progress</span>
                                <span id="seconds-fraction">0 / 60</span>
                            </div>
                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                <div id="seconds-bar" class="h-full rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-400 transition-all duration-300 ease-linear" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom bar -->
        <footer class="relative z-10 px-5 sm:px-10 py-4 sm:py-5 border-t border-white/10 text-center">
            <p class="text-xs text-slate-500">
                &copy; <?php echo date('Y'); ?> Exact Age Calculator.
            </p>
        </footer>
    </section>

    <script src="assets/js/app.js"></script>
</body>
</html>
