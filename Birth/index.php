<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calculate your exact age in years, days, hours, minutes, and seconds.">
    <title>Exact Age Calculator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef9ff',
                            100: '#d9f1ff',
                            200: '#bce7ff',
                            300: '#8ed8ff',
                            400: '#59c0ff',
                            500: '#33a6ff',
                            600: '#1a88f5',
                            700: '#1370e1',
                            800: '#175ab6',
                            900: '#194d8f',
                            950: '#143057',
                        },
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                },
            },
        };
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
        }
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(26, 136, 245, 0.15);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="h-full font-sans antialiased bg-gradient-to-br from-slate-50 via-brand-50 to-indigo-100 text-slate-800">

    <div class="min-h-full flex flex-col">
        <!-- Header -->
        <header class="pt-10 pb-6 px-4 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-brand-600 text-white shadow-lg shadow-brand-600/30 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
                Exact Age Calculator
            </h1>
            <p class="mt-2 text-slate-600 max-w-md mx-auto text-sm sm:text-base">
                Discover your age in years, days, hours, minutes, and seconds — updated live.
            </p>
        </header>

        <!-- Main Content -->
        <main class="flex-1 px-4 pb-12">
            <div class="max-w-lg mx-auto space-y-6">

                <!-- Input Card -->
                <section
                    class="glass-card rounded-2xl shadow-xl shadow-slate-200/60 border border-white/60 p-6 sm:p-8"
                    aria-labelledby="input-heading"
                >
                    <h2 id="input-heading" class="sr-only">Date of Birth Input</h2>

                    <form id="age-form" novalidate>
                        <div class="space-y-5">
                            <div>
                                <label for="dob" class="block text-sm font-medium text-slate-700 mb-2">
                                    Enter Your Date of Birth
                                </label>
                                <input
                                    type="date"
                                    id="dob"
                                    name="dob"
                                    required
                                    aria-required="true"
                                    aria-describedby="dob-hint error-message"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm
                                           focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30
                                           transition-colors text-base"
                                >
                                <p id="dob-hint" class="mt-1.5 text-xs text-slate-500">
                                    Select your birth date using the calendar picker.
                                </p>
                            </div>

                            <!-- Error Message -->
                            <div
                                id="error-message"
                                class="hidden rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700"
                                role="alert"
                                aria-live="polite"
                                aria-hidden="true"
                            ></div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <button
                                    type="submit"
                                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-brand-600 px-6 py-3
                                           text-sm font-semibold text-white shadow-lg shadow-brand-600/25
                                           hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2
                                           transition-colors"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Calculate My Age
                                </button>
                                <button
                                    type="button"
                                    id="clear-btn"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3
                                           text-sm font-medium text-slate-700 shadow-sm
                                           hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2
                                           transition-colors"
                                >
                                    Clear
                                </button>
                            </div>
                        </div>
                    </form>
                </section>

                <!-- Results Card -->
                <section
                    id="results"
                    class="hidden glass-card rounded-2xl shadow-xl shadow-slate-200/60 border border-white/60 p-6 sm:p-8 fade-in-up"
                    aria-labelledby="results-heading"
                    aria-hidden="true"
                    aria-live="polite"
                >
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 id="results-heading" class="text-lg font-semibold text-slate-900">Your Exact Age</h2>
                            <p class="text-xs text-slate-500">Calculated from your local time zone</p>
                        </div>
                    </div>

                    <dl class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div class="stat-card rounded-xl bg-brand-50 border border-brand-100 p-4 text-center">
                            <dt class="text-xs font-medium uppercase tracking-wider text-brand-600 mb-1">Years</dt>
                            <dd id="value-years" class="text-2xl sm:text-3xl font-bold text-brand-900 tabular-nums">0</dd>
                        </div>
                        <div class="stat-card rounded-xl bg-slate-50 border border-slate-100 p-4 text-center">
                            <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 mb-1">Days</dt>
                            <dd id="value-days" class="text-2xl sm:text-3xl font-bold text-slate-900 tabular-nums">0</dd>
                        </div>
                        <div class="stat-card rounded-xl bg-slate-50 border border-slate-100 p-4 text-center">
                            <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 mb-1">Hours</dt>
                            <dd id="value-hours" class="text-2xl sm:text-3xl font-bold text-slate-900 tabular-nums">0</dd>
                        </div>
                        <div class="stat-card rounded-xl bg-slate-50 border border-slate-100 p-4 text-center">
                            <dt class="text-xs font-medium uppercase tracking-wider text-slate-500 mb-1">Minutes</dt>
                            <dd id="value-minutes" class="text-2xl sm:text-3xl font-bold text-slate-900 tabular-nums">0</dd>
                        </div>
                        <div class="stat-card col-span-2 sm:col-span-1 rounded-xl bg-indigo-50 border border-indigo-100 p-4 text-center relative overflow-hidden">
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-200/60 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-indigo-700 animate-pulse-slow">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                    Live
                                </span>
                            </div>
                            <dt class="text-xs font-medium uppercase tracking-wider text-indigo-600 mb-1">Seconds</dt>
                            <dd id="value-seconds" class="text-2xl sm:text-3xl font-bold text-indigo-900 tabular-nums">0</dd>
                        </div>
                    </dl>
                </section>

            </div>
        </main>

        <!-- Footer -->
        <footer class="py-6 text-center text-xs text-slate-500">
            &copy; <?php echo date('Y'); ?> Exact Age Calculator. All calculations use your local time zone.
        </footer>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>
