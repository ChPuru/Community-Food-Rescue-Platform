<?php require_once '../backend/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle — Impact Dashboard</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="bg-page min-h-screen flex flex-col">
    <nav class="site-nav">
        <div class="nav-inner">
            <div class="logo">
                <div class="logo-icon"><i data-icon="recycle" class="icon icon-lg" style="color:#fff"></i></div>
                <span class="logo-text">FoodCycle</span>
            </div>
            <div class="nav-links">
                <a href="index.php">Mission</a>
                <a href="catalogue.php">Find Food</a>
                <a href="new-listing.php">Donate</a>
                <a href="impact.php" class="text-brand-600" style="border-bottom:2px solid var(--brand-600);padding-bottom:0.25rem">Impact</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" style="font-weight:bold; color:var(--brand-600);">Op: <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    <a href="logout.php" class="btn-nav" style="background:#000; color:#fff; border-color:#000;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-nav">Join Movement / Login</a>
                <?php endif; ?>
            </div>
            <button class="mobile-menu-btn"><i data-icon="menu" class="icon icon-lg"></i></button>
        </div>
    </nav>
    <header class="bg-brand-400 brutal-border-b py-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid" style="opacity:0.2"></div>
        <div class="container relative z-10">
            <div class="flex flex-col gap-6 md-flex-row" style="justify-content:space-between;align-items:flex-start">
                <div>
                    <div class="tag-black-skew mb-4">Global Metrics</div>
                    <h1 class="font-display text-6xl sm-text-8xl leading-none">
                        Environmental<br>
                        <span class="text-white drop-shadow-text">Impact</span>
                    </h1>
                </div>
                <div class="bg-white brutal-border p-4" style="max-width:20rem">
                    <p class="font-bold text-sm uppercase tracking-wider mb-2">Live Status</p>
                    <div class="flex items-center gap-2 text-brand-600 font-bold">
                        <span class="relative flex" style="height:0.75rem;width:0.75rem">
                            <span class="pulse-ring absolute" style="display:inline-flex;height:100%;width:100%;border-radius:9999px;background:var(--brand-400)"></span>
                            <span class="relative" style="display:inline-flex;border-radius:9999px;width:0.75rem;height:0.75rem;background:var(--brand-600)"></span>
                        </span>
                        Tracking 1,204 active rescues
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="flex-grow container py-12">
        <div class="grid grid-cols-1 md-grid-cols-3 gap-8 mb-12">
            <div class="stat-card">
                <div class="stat-icon-circle"><i data-icon="scale" class="icon icon-lg"></i></div>
                <h3 class="font-bold uppercase tracking-wider text-gray-500 mb-2">Food Rescued</h3>
                <div class="font-display text-6xl mb-1">14.2<span class="text-brand-600 text-4xl">k</span></div>
                <p class="font-bold text-sm uppercase">Pounds this month</p>
                <div class="progress-bar mt-4"><div class="progress-bar-fill" style="width:75%"></div></div>
                <p class="text-xs font-bold text-brand-600 mt-2 text-right">+12% vs last month</p>
            </div>
            <div class="stat-card" style="background:#000;color:#fff">
                <div class="stat-icon-circle" style="background:#fff"><i data-icon="users" class="icon icon-lg"></i></div>
                <h3 class="font-bold uppercase tracking-wider mb-2" style="color:var(--gray-400)">Meals Provided</h3>
                <div class="font-display text-6xl mb-1 text-brand-400">11,800</div>
                <p class="font-bold text-sm uppercase">To local shelters</p>
                <div class="flex gap-1 mt-4">
                    <div class="brutal-border" style="height:2rem;width:2rem;background:var(--brand-600);border-color:#fff"></div>
                    <div class="brutal-border" style="height:2rem;width:2rem;background:var(--brand-600);border-color:#fff"></div>
                    <div class="brutal-border" style="height:2rem;width:2rem;background:var(--brand-600);border-color:#fff"></div>
                    <div class="brutal-border" style="height:2rem;width:2rem;background:var(--brand-600);border-color:#fff"></div>
                    <div class="brutal-border" style="height:2rem;width:2rem;background:var(--brand-600);border-color:#fff;opacity:0.5"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-circle"><i data-icon="cloud-off" class="icon icon-lg"></i></div>
                <h3 class="font-bold uppercase tracking-wider text-gray-500 mb-2">CO2 Prevented</h3>
                <div class="font-display text-6xl mb-1">5.6<span class="text-brand-600 text-4xl">t</span></div>
                <p class="font-bold text-sm uppercase">Tons of emissions</p>
                <div class="mini-chart">
                    <div class="mini-chart-bar" style="height:40%;background:#000"></div>
                    <div class="mini-chart-bar" style="height:60%;background:#000"></div>
                    <div class="mini-chart-bar" style="height:50%;background:#000"></div>
                    <div class="mini-chart-bar" style="height:80%;background:#000"></div>
                    <div class="mini-chart-bar" style="height:100%;background:var(--brand-400)"></div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-8" style="grid-template-columns:1fr">
            <div class="grid grid-cols-1 lg-grid-cols-3 gap-8">
            <div class="lg-col-span-1 bg-white brutal-border flex flex-col">
                <div class="brutal-border-b p-4 flex justify-between items-center" style="background:#000;color:#fff">
                    <h2 class="font-display text-2xl tracking-wide">Top Rescuers</h2>
                    <i data-icon="trophy" class="icon icon-lg text-brand-400"></i>
                </div>
                <div class="flex-grow p-0">
                    <div class="leaderboard-item">
                        <div class="leaderboard-rank text-brand-600">01</div>
                        <div class="leaderboard-avatar img-placeholder-stripes"><i data-icon="user" class="icon icon-md" style="opacity:0.5"></i></div>
                        <div class="flex-grow"><div class="font-bold uppercase text-sm">Downtown Bakery</div><div class="text-xs font-bold text-gray-500">420 lbs rescued</div></div>
                    </div>
                    <div class="leaderboard-item">
                        <div class="leaderboard-rank">02</div>
                        <div class="leaderboard-avatar bg-brand-400">SM</div>
                        <div class="flex-grow"><div class="font-bold uppercase text-sm">SuperMart East</div><div class="text-xs font-bold text-gray-500">385 lbs rescued</div></div>
                    </div>
                    <div class="leaderboard-item">
                        <div class="leaderboard-rank">03</div>
                        <div class="leaderboard-avatar" style="background:#000;color:#fff">CF</div>
                        <div class="flex-grow"><div class="font-bold uppercase text-sm">City Farms</div><div class="text-xs font-bold text-gray-500">290 lbs rescued</div></div>
                    </div>
                    <div class="leaderboard-item" style="border-bottom:none">
                        <div class="leaderboard-rank text-gray-400">04</div>
                        <div class="leaderboard-avatar bg-white"><i data-icon="user" class="icon icon-md"></i></div>
                        <div class="flex-grow"><div class="font-bold uppercase text-sm">Sarah J. (Volunteer)</div><div class="text-xs font-bold text-gray-500">15 deliveries</div></div>
                    </div>
                </div>
                <a href="#" class="block text-center brutal-border-t py-3 font-bold uppercase tracking-wider transition-colors" style="background:var(--brand-400)" onmouseover="this.style.background='var(--brand-500)'" onmouseout="this.style.background='var(--brand-400)'">
                    View Full Leaderboard
                </a>
            </div>
            <div class="lg-col-span-2 flex flex-col gap-8">
                <div class="bg-white brutal-border p-6">
                    <h2 class="font-display text-3xl tracking-wide mb-6" style="border-bottom:3px solid #000;padding-bottom:0.5rem">Food Types Rescued</h2>
                    <div class="space-y-6">
                        <div class="bar-chart-row">
                            <div class="flex justify-between font-bold uppercase text-sm mb-2"><span>Produce & Veg</span><span>45%</span></div>
                            <div class="bar-track"><div class="bar-fill" style="width:45%;background:var(--brand-600)"></div></div>
                        </div>
                        <div class="bar-chart-row">
                            <div class="flex justify-between font-bold uppercase text-sm mb-2"><span>Baked Goods</span><span>30%</span></div>
                            <div class="bar-track"><div class="bar-fill" style="width:30%;background:#000"></div></div>
                        </div>
                        <div class="bar-chart-row">
                            <div class="flex justify-between font-bold uppercase text-sm mb-2"><span>Prepared Meals</span><span>15%</span></div>
                            <div class="bar-track"><div class="bar-fill" style="width:15%;background:var(--brand-400)"></div></div>
                        </div>
                        <div class="bar-chart-row">
                            <div class="flex justify-between font-bold uppercase text-sm mb-2"><span>Dairy & Other</span><span>10%</span></div>
                            <div class="bar-track"><div class="bar-fill bg-stripes" style="width:10%"></div></div>
                        </div>
                    </div>
                </div>
                <div class="brutal-border p-8 relative overflow-hidden" style="background:var(--brand-600);color:#fff">
                    <i data-icon="leaf" class="icon absolute" style="right:-2.5rem;bottom:-2.5rem;width:16rem;height:16rem;opacity:0.2;color:#000;transform:rotate(12deg)"></i>
                    <div class="relative z-10">
                        <h2 class="font-display text-4xl sm-text-5xl mb-4">Your Impact Matters</h2>
                        <p class="font-medium text-lg mb-8 border-l-brand" style="max-width:28rem;border-left-color:#000;border-left-width:4px">
                            Every pound of food rescued is a step towards zero hunger and zero waste in our community.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <button class="brutal-border font-bold uppercase tracking-wider px-8 py-4 transition-colors" style="background:#000;color:#fff" onmouseover="this.style.background='#fff';this.style.color='#000'" onmouseout="this.style.background='#000';this.style.color='#fff'">Share Report</button>
                            <button class="brutal-border font-bold uppercase tracking-wider px-8 py-4 transition-colors" style="background:#fff;color:#000" onmouseover="this.style.background='var(--brand-400)'" onmouseout="this.style.background='#fff'">Donate Now</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </main>
    <script src="assets/icons.js"></script>
    <script src="assets/nav.js"></script>
</body>
</html>