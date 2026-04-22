<?php
require_once '../backend/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle — Community Food Rescue</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="bg-page min-h-screen flex flex-col">
    <nav class="site-nav">
        <div class="nav-inner">
            <div class="logo">
                <div class="logo-icon">
                    <i data-icon="recycle" class="icon icon-lg" style="color:#fff"></i>
                </div>
                <span class="logo-text">FoodCycle</span>
            </div>
            <div class="nav-links">
                <a href="#">Mission</a>
                <a href="#">Find Food</a>
                <a href="#">Donate</a>
                <a href="impact.php">Impact</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" style="font-weight:bold; color:var(--brand-600);">Op: <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                    <a href="logout.php" class="btn-nav" style="background:#000; color:#fff; border-color:#000;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-nav">Join Movement / Login</a>
                <?php endif; ?>
            </div>
            <button class="mobile-menu-btn">
                <i data-icon="menu" class="icon icon-lg"></i>
            </button>
        </div>
    </nav>
    <div class="marquee-container">
        <div class="marquee-content">
            RESCUE FOOD. REDUCE WASTE. FEED LIVES. &bull; ZERO HUNGER &bull; RESCUE FOOD. REDUCE WASTE. FEED LIVES. &bull; ZERO HUNGER &bull; RESCUE FOOD. REDUCE WASTE. FEED LIVES. &bull; ZERO HUNGER &bull;
        </div>
    </div>
    <main class="flex-grow">
        <div class="container" style="padding-top:3rem;padding-bottom:3rem">
            <div class="grid grid-cols-1 lg-grid-cols-12 gap-8" style="align-items:center">
                <div style="grid-column:span 7" class="lg-col-span-7">
                    <div class="tag-skew mb-4">Community Action</div>
                    <h1 class="hero-text-giant mb-4">
                        Stop <br>
                        <span class="text-brand-600">Wasting</span><br>
                        Good Food.
                    </h1>
                    <p class="text-xl font-medium hero-accent-line mb-8" style="max-width:42rem">
                        Connect surplus food from local businesses directly to community members and shelters in real-time.
                    </p>
                    <div class="flex flex-col gap-6 sm-flex-row">
                        <a href="nearby.php" class="btn-primary">I Need Food</a>
                        <a href="new-listing.php" class="btn-secondary">I Have Surplus</a>
                    </div>
                    <div class="hero-stats">
                        <div>
                            <div class="font-display text-4xl sm-text-5xl">2.4<span class="text-brand-600">M</span></div>
                            <div class="font-bold uppercase text-xs tracking-wider mt-1">Meals Rescued</div>
                        </div>
                        <div>
                            <div class="font-display text-4xl sm-text-5xl">850<span class="text-brand-600">+</span></div>
                            <div class="font-bold uppercase text-xs tracking-wider mt-1">Active Donors</div>
                        </div>
                        <div>
                            <div class="font-display text-4xl sm-text-5xl">12<span class="text-brand-600">K</span></div>
                            <div class="font-bold uppercase text-xs tracking-wider mt-1">Volunteers</div>
                        </div>
                    </div>
                </div>
                <div style="grid-column:span 5" class="lg-col-span-5 relative">
                    <div class="hero-image-bg"></div>
                    <div class="hero-image-frame">
                        <div class="img-placeholder-stripes brutal-border" style="aspect-ratio:4/5;position:relative">
                            <div style="position:absolute;inset:0;background:linear-gradient(135deg,#a8d5a2 0%,#6ab864 50%,#3d8b37 100%);opacity:0.4"></div>
                            <i data-icon="recycle" class="icon icon-huge" style="color:rgba(0,0,0,0.15);position:relative;z-index:1"></i>
                            <div style="position:absolute;top:1rem;right:1rem;background:#000;color:#fff;padding:1rem;border:3px solid #000;transform:rotate(12deg);z-index:10">
                                <div class="font-display text-3xl text-center leading-none">LIVE</div>
                                <div class="font-bold text-xs uppercase tracking-widest text-brand-400 mt-1">Rescue Map</div>
                            </div>
                        </div>
                        <div class="flex items-start justify-between mt-4">
                            <div>
                                <h3 class="font-bold uppercase text-lg">Current Batch: #8842</h3>
                                <p class="text-sm font-medium text-gray-600">Fresh produce from Downtown Market</p>
                            </div>
                            <span class="badge-brand" style="padding:0.25rem 0.5rem;white-space:nowrap">45 mins left</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <section class="brutal-border-t bg-white">
        <div class="container py-16">
            <div class="flex justify-between items-end mb-8">
                <h2 class="font-display text-5xl sm-text-6xl">Urgent <span class="text-brand-600">Rescues</span></h2>
                <a href="feed.php" class="sm-flex items-center gap-2 font-bold uppercase tracking-wider hidden" style="display:none">
                    View All <i data-icon="arrow-right" class="icon icon-md"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md-grid-cols-3 gap-8">
                <div class="card p-6 relative" style="background:var(--bg)">
                    <div class="nearby-distance bg-brand-400">1.2 mi</div>
                    <div class="flex items-center gap-3 mb-4">
                        <div style="width:3rem;height:3rem;background:#000;border-radius:9999px;display:flex;align-items:center;justify-content:center;color:#fff">
                            <i data-icon="croissant" class="icon icon-lg"></i>
                        </div>
                        <div>
                            <div class="font-bold uppercase">Morning Pastries</div>
                            <div class="text-sm font-medium text-gray-600">Local Bakery Co.</div>
                        </div>
                    </div>
                    <p class="font-medium mb-6">2 boxes of assorted bagels and muffins. Best before end of day.</p>
                    <button class="w-full brutal-border py-3 font-bold uppercase tracking-wider bg-white transition-colors" onmouseover="this.style.background='#000';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#000'">
                        Claim Batch
                    </button>
                </div>
                <div class="card p-6 relative" style="background:var(--bg)">
                    <div class="nearby-distance bg-brand-400">0.8 mi</div>
                    <div class="flex items-center gap-3 mb-4">
                        <div style="width:3rem;height:3rem;background:#000;border-radius:9999px;display:flex;align-items:center;justify-content:center;color:#fff">
                            <i data-icon="carrot" class="icon icon-lg"></i>
                        </div>
                        <div>
                            <div class="font-bold uppercase">Imperfect Produce</div>
                            <div class="text-sm font-medium text-gray-600">City Supermarket</div>
                        </div>
                    </div>
                    <p class="font-medium mb-6">15 lbs of slightly bruised apples and overripe bananas. Great for baking.</p>
                    <button class="w-full brutal-border py-3 font-bold uppercase tracking-wider bg-white transition-colors" onmouseover="this.style.background='#000';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#000'">
                        Claim Batch
                    </button>
                </div>
                <div class="card p-6 flex flex-col justify-center items-center text-center" style="background:#000;color:#fff">
                    <i data-icon="map" class="icon icon-hero text-brand-400 mb-4"></i>
                    <h3 class="font-display text-3xl mb-2">Open Map</h3>
                    <p class="font-medium mb-6" style="color:var(--gray-400)">See 24 more active rescues in your area right now.</p>
                    <button class="brutal-border py-3 px-8 font-bold uppercase tracking-wider transition-colors" style="background:var(--brand-600);color:#fff;border-color:#fff" onmouseover="this.style.background='#fff';this.style.color='#000'" onmouseout="this.style.background='var(--brand-600)';this.style.color='#fff'">
                        Launch Radar
                    </button>
                </div>
            </div>
        </div>
    </section>
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="flex items-center gap-2">
                <i data-icon="recycle" class="icon icon-xl text-brand-400"></i>
                <span class="font-display text-2xl tracking-wide mt-1">FoodCycle</span>
            </div>
            <div class="footer-links">
                <a href="#">About</a>
                <a href="#">Guidelines</a>
                <a href="feedback.php">Contact</a>
            </div>
        </div>
    </footer>
    <script src="assets/icons.js"></script>
    <script src="assets/nav.js"></script>
</body>
</html>

