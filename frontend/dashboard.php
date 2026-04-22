<?php
require '../backend/protect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH - SYSTEM DASHBOARD</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="min-h-screen flex flex-col bg-blueprint" style="background-color:var(--arch-white);color:var(--arch-black)">
    <header class="arch-border-b flex justify-between items-center px-6 py-4 sticky z-50" style="top:0;background:var(--arch-white)">
        <div class="flex items-center gap-3">
            <div style="width:2rem;height:2rem;background:var(--arch-black);display:flex;align-items:center;justify-content:center">
                <i data-icon="layout" class="icon icon-md" style="color:var(--arch-white)"></i>
            </div>
            <span class="font-bold tracking-tight text-xl uppercase">Dashboard</span>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-2">
                <span class="pulse" style="width:0.5rem;height:0.5rem;background:var(--arch-accent);border-radius:9999px;display:inline-block"></span>
                <span class="font-mono text-xs uppercase font-bold" style="color:var(--arch-gray)">System Online</span>
            </div>
            <div class="arch-border font-bold font-mono text-sm px-3 py-1" style="background:var(--arch-black);color:var(--arch-white)">
                <?php echo htmlspecialchars(strtoupper($_SESSION['user_name'])); ?>
            </div>
        </div>
    </header>
    <div class="flex flex-1 overflow-hidden">
        <aside class="arch-border-r lg-flex hidden flex-col overflow-y-auto" style="width:16rem;background:var(--arch-light);flex-shrink:0">
            <div class="p-6 space-y-2">
                <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-6" style="color:var(--arch-gray)">Main Navigation</h3>
                <a href="#" class="flex items-center gap-3 p-3 arch-border bg-white font-bold text-sm uppercase transition-colors" style="border-left:4px solid var(--arch-black)">
                    <i data-icon="home" class="icon icon-sm"></i> Overview
                </a>
                <a href="catalogue.php" class="flex items-center gap-3 p-3 arch-border font-bold text-sm uppercase transition-colors" onmouseover="this.style.background='var(--arch-white)'" onmouseout="this.style.background='transparent'">
                    <i data-icon="grid" class="icon icon-sm"></i> Catalogue
                </a>
                <a href="feed.php" class="flex items-center gap-3 p-3 arch-border font-bold text-sm uppercase transition-colors" onmouseover="this.style.background='var(--arch-white)'" onmouseout="this.style.background='transparent'">
                    <i data-icon="activity" class="icon icon-sm"></i> Live Feed
                </a>
                <a href="new-listing.php" class="flex items-center gap-3 p-3 arch-border font-bold text-sm uppercase transition-colors" onmouseover="this.style.background='var(--arch-white)'" onmouseout="this.style.background='transparent'">
                    <i data-icon="plus-circle" class="icon icon-sm"></i> Submit Food
                </a>
            </div>
            <div class="mt-auto p-6 arch-border-t bg-white">
                <a href="logout.php" class="flex justify-between items-center w-full font-mono text-xs font-bold uppercase transition-colors" style="color:var(--arch-gray)" onmouseover="this.style.color='var(--arch-black)'" onmouseout="this.style.color='var(--arch-gray)'">
                    [ LOGOUT ] <i data-icon="log-out" class="icon icon-sm"></i>
                </a>
            </div>
        </aside>
        <main class="flex-1 overflow-y-auto p-6 lg-p-12 relative">
            <div class="crosshair lg-block hidden" style="top:2rem;left:2rem"></div>
            <div class="crosshair lg-block hidden" style="top:2rem;right:2rem"></div>
            <div class="max-w-4xl mx-auto space-y-8 relative z-10">
                <h1 class="font-bold tracking-tight mb-2" style="font-size:3rem;line-height:1.1">
                    Welcome, <br><span style="color:var(--arch-gray)"><?php echo htmlspecialchars($_SESSION['user_name']); ?>.</span>
                </h1>
                <div class="grid grid-cols-1 md-grid-cols-3 gap-6 pt-4">
                    <div class="arch-border p-6 bg-white" style="box-shadow:4px 4px 0 var(--arch-black)">
                        <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--arch-gray)">Impact</h3>
                        <div class="font-bold text-3xl">42 lbs</div>
                    </div>
                    <div class="arch-border p-6 bg-white" style="box-shadow:4px 4px 0 var(--arch-black)">
                        <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--arch-gray)">Active Listings</h3>
                        <div class="font-bold text-3xl">3</div>
                    </div>
                    <div class="arch-border p-6 bg-white" style="box-shadow:4px 4px 0 var(--arch-black)">
                        <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--arch-gray)">Network Rank</h3>
                        <div class="font-bold text-3xl">Tier 2</div>
                    </div>
                </div>
                <div class="arch-border bg-white mt-12 overflow-hidden">
                    <div class="arch-border-b p-6" style="background:var(--arch-light)">
                        <h2 class="font-bold uppercase text-2xl tracking-tight">Recent Activity</h2>
                    </div>
                    <div class="p-8 text-center" style="border:4px dashed rgba(10,10,10,0.1);margin:1.5rem">
                        <i data-icon="inbox" class="icon icon-2xl mb-4" style="color:var(--arch-gray);opacity:0.5"></i>
                        <p class="font-mono text-sm uppercase font-bold" style="color:var(--arch-gray)">No operations to display...</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/icons.js"></script>
    <script src="assets/nav.js"></script>
</body>
</html>

