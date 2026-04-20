<?php require_once '../backend/init.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Workspace</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="bg-page flex flex-col overflow-hidden" style="height:100vh;color:#000">
    <nav class="brutal-border-b bg-white" style="flex-shrink:0;z-index:50">
        <div class="flex justify-between items-center px-4" style="height:4rem">
            <div class="flex items-center gap-4">
                <div class="logo-icon" style="width:2rem;height:2rem"><i data-icon="recycle" class="icon icon-md"
                        style="color:#fff"></i></div>
                <span class="font-display text-2xl tracking-wide mt-1">FoodCycle</span>
                <div class="md-flex hidden ml-8 space-x-1">
                    <a href="index.php"
                        class="px-4 py-2 bg-black text-white font-bold uppercase text-xs tracking-wider brutal-border">Dashboard</a>
                    <a href="#"
                        class="px-4 py-2 font-bold uppercase text-xs tracking-wider brutal-border transition-colors"
                        style="border-color:transparent"
                        onmouseover="this.style.borderColor='#000';this.style.background='var(--brand-50)'"
                        onmouseout="this.style.borderColor='transparent';this.style.background='transparent'">Map</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 brutal-border relative transition-colors"
                    onmouseover="this.style.background='var(--brand-400)'"
                    onmouseout="this.style.background='transparent'">
                    <i data-icon="bell" class="icon icon-md"></i>
                    <span class="absolute brutal-border"
                        style="top:-0.5rem;right:-0.5rem;background:var(--brand-600);color:#fff;font-size:0.625rem;font-weight:700;padding:0.125rem 0.375rem">3</span>
                </button>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="flex items-center gap-2 brutal-border p-1"
                        style="padding-right:0.75rem;background:var(--bg);text-decoration:none;color:#000;">
                        <div
                            style="width:2rem;height:2rem;background:#000;border-radius:9999px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.875rem">
                            <?php echo strtoupper(substr($_SESSION['user_name'], 0, 2)); ?>
                        </div>
                        <span
                            class="font-bold text-sm uppercase sm-block hidden"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="font-bold text-sm uppercase brutal-border px-4 py-2"
                        style="background:#000;color:#fff;text-decoration:none;">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="flex flex-1 overflow-hidden">
        <aside class="brutal-border-r bg-white lg-flex hidden flex-col overflow-y-auto"
            style="width:16rem;flex-shrink:0">
            <div class="p-4 brutal-border-b bg-brand-400">
                <a href="new-listing.php"
                    class="w-full bg-black text-white py-3 font-display text-xl uppercase tracking-wider brutal-shadow-sm flex items-center justify-center gap-2 transition-colors text-center no-underline"
                    onmouseover="this.style.background='var(--brand-600)'" onmouseout="this.style.background='#000'">
                    <i data-icon="plus-circle" class="icon icon-md"></i> New Listing
                </a>
                </a>
            </div>
            <div class="p-4 flex-1">
                <h3 class="font-display text-xl uppercase mb-4"
                    style="border-bottom:2px solid #000;padding-bottom:0.25rem">Filters</h3>
                <div class="space-y-4">
                    <div>
                        <label class="font-bold uppercase text-xs text-gray-500 block mb-2">Distance</label>
                        <select class="w-full brutal-border p-2 font-bold text-sm"
                            style="background:var(--bg);outline:none">
                            <option>Within 5 miles</option>
                            <option>Within 10 miles</option>
                            <option>Within 25 miles</option>
                            <option>Any distance</option>
                        </select>
                    </div>
                </div>
            </div>
        </aside>
        <main class="flex-1 flex flex-col min-w-0 brutal-border-r bg-page">
            <div class="p-4 brutal-border-b bg-white flex justify-between items-center" style="flex-shrink:0">
                <h2 class="font-display text-3xl uppercase">Live Feed</h2>
                <div class="flex items-center gap-2 text-sm font-bold uppercase">
                    <span class="pulse"
                        style="width:0.5rem;height:0.5rem;border-radius:9999px;background:var(--brand-600);display:inline-block"></span>
                    <span id="feed-update-status">Updating</span>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto feed-scroll p-4 space-y-4" id="feed-container">
            </div>
        </main>
        <aside class="xl-flex hidden flex-col bg-white" style="width:33%">
            <div class="brutal-border-b relative" style="height:50%;background:var(--gray-200)">
                <div class="absolute inset-0 bg-grid" style="opacity:0.3"></div>
                <div class="absolute inset-0 p-4">
                    <div class="brutal-border w-full h-full relative overflow-hidden" style="background:#e5e5f7">
                        <svg class="absolute inset-0 w-full h-full" style="opacity:0.2"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M0,50 Q100,100 200,50 T400,50" fill="none" stroke="black" stroke-width="4" />
                        </svg>
                        <div class="absolute font-bold font-mono"
                            style="top:50%;left:50%;width:1.5rem;height:1.5rem;background:#000;color:#fff;border:3px solid #000;border-radius:9999px;display:flex;align-items:center;justify-content:center;font-size:0.625rem;z-index:10">
                            YOU</div>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-6 overflow-y-auto">
                <div class="h-full flex flex-col items-center justify-center text-center p-6"
                    style="border:4px dashed var(--gray-300)">
                    <i data-icon="mouse-pointer-click" class="icon icon-2xl mb-4" style="color:var(--gray-400)"></i>
                    <h3 class="font-display text-2xl uppercase mb-2 text-gray-500">Select a Listing</h3>
                    <p class="font-medium text-sm" style="color:var(--gray-400)">Click on any rescue batch in the feed
                        to view full details.</p>
                </div>
            </div>
        </aside>
    </div>
    <script src="assets/icons.js"></script>
    <script src="assets/feed.js"></script>
    <script src="assets/nav.js"></script>
</body>

</html>