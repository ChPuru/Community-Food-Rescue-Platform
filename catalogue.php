<?php require_once 'init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH | CATALOGUE</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="min-h-screen flex flex-col custom-scrollbar" style="background-color:var(--arch-white);color:var(--arch-black)">

    <!-- Top Navigation -->
    <header class="arch-border-b flex justify-between items-center px-6 py-4 sticky z-50" style="top:0;background:var(--arch-white)">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div style="width:2rem;height:2rem;background:var(--arch-black);display:flex;align-items:center;justify-content:center">
                    <i data-icon="layers" class="icon icon-md" style="color:var(--arch-white)"></i>
                </div>
                <span class="font-bold tracking-tight text-xl uppercase">Rescue_Arch</span>
            </div>
            <nav class="md-flex hidden items-center gap-6 font-mono text-xs font-bold uppercase tracking-widest">
                <a href="index.php" class="transition-colors" style="color:var(--arch-gray)" onmouseover="this.style.color='var(--arch-black)'" onmouseout="this.style.color='var(--arch-gray)'">Dashboard</a>
                <a href="#" style="color:var(--arch-black);border-bottom:2px solid var(--arch-black);padding-bottom:0.25rem">Catalogue</a>
                <a href="#" class="transition-colors" style="color:var(--arch-gray)" onmouseover="this.style.color='var(--arch-black)'" onmouseout="this.style.color='var(--arch-gray)'">Map_View</a>
                <a href="impact.php" class="transition-colors" style="color:var(--arch-gray)" onmouseover="this.style.color='var(--arch-black)'" onmouseout="this.style.color='var(--arch-gray)'">Impact</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <div class="sm-flex hidden items-center gap-2 arch-border px-3 py-1" style="background:var(--arch-light)">
                <span class="pulse" style="width:0.5rem;height:0.5rem;background:var(--arch-accent);border-radius:9999px;display:inline-block"></span>
                <span class="font-mono font-bold uppercase" style="font-size:0.625rem">System Online</span>
            </div>
            <button class="arch-border p-2 relative transition-colors" onmouseover="this.style.background='var(--arch-black)';this.style.color='var(--arch-white)'" onmouseout="this.style.background='transparent';this.style.color='var(--arch-black)'">
                <i data-icon="bell" class="icon icon-md"></i>
                <span class="absolute arch-border" style="top:-0.25rem;right:-0.25rem;width:0.75rem;height:0.75rem;background:var(--arch-accent);border-radius:9999px"></span>
            </button>
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="arch-border font-bold font-mono text-sm" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 2)); ?>
                </div>
            <?php else: ?>
                <a href="login.php" class="arch-border font-bold font-mono text-sm" style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;text-decoration:none;">IN</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="flex flex-1 overflow-hidden">

        <!-- Sidebar Filters -->
        <aside class="arch-border-r lg-flex hidden flex-col overflow-y-auto custom-scrollbar" style="width:18rem;background:var(--arch-light);flex-shrink:0">
            <div class="p-6 arch-border-b bg-white">
                <h2 class="font-bold text-2xl uppercase tracking-tight mb-4">Parameters</h2>
                <div class="relative mb-2">
                    <input type="text" placeholder="Search inventory..." class="arch-input-sm" style="padding-left:2rem">
                    <i data-icon="search" class="icon icon-md absolute" style="left:0;bottom:0.75rem;color:var(--arch-gray)"></i>
                </div>
            </div>

            <div class="p-6 flex-1 space-y-8">
                <!-- Category Filter -->
                <div>
                    <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-4 flex justify-between items-center">
                        Category <i data-icon="chevron-down" class="icon icon-sm"></i>
                    </h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked class="checkbox-brutal" style="width:1rem;height:1rem"><span class="font-mono text-sm uppercase">Produce (42)</span></label>
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked class="checkbox-brutal" style="width:1rem;height:1rem"><span class="font-mono text-sm uppercase">Bakery (18)</span></label>
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" class="checkbox-brutal" style="width:1rem;height:1rem"><span class="font-mono text-sm uppercase">Prepared (24)</span></label>
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" class="checkbox-brutal" style="width:1rem;height:1rem"><span class="font-mono text-sm uppercase">Dairy (7)</span></label>
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" class="checkbox-brutal" style="width:1rem;height:1rem"><span class="font-mono text-sm uppercase">Pantry (56)</span></label>
                    </div>
                </div>

                <!-- Urgency Filter -->
                <div>
                    <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-4 flex justify-between items-center">
                        Urgency Level <i data-icon="chevron-down" class="icon icon-sm"></i>
                    </h3>
                    <div class="flex flex-col gap-2">
                        <div><input type="checkbox" id="urg-high" class="sr-only filter-checkbox" checked><label for="urg-high" class="block w-full text-center py-2 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors">Critical (&lt; 2hrs)</label></div>
                        <div><input type="checkbox" id="urg-med" class="sr-only filter-checkbox" checked><label for="urg-med" class="block w-full text-center py-2 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors">Moderate (&lt; 12hrs)</label></div>
                        <div><input type="checkbox" id="urg-low" class="sr-only filter-checkbox"><label for="urg-low" class="block w-full text-center py-2 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors">Stable (&gt; 24hrs)</label></div>
                    </div>
                </div>

                <!-- Distance Filter -->
                <div>
                    <h3 class="font-mono text-xs font-bold uppercase tracking-widest mb-4 flex justify-between items-center">
                        Radius [Miles] <span class="text-arch-accent">15mi</span>
                    </h3>
                    <input type="range" min="1" max="50" value="15" class="w-full arch-border" style="height:0.5rem;accent-color:var(--arch-black)">
                    <div class="flex justify-between font-mono mt-2" style="font-size:0.625rem;color:var(--arch-gray)">
                        <span>1mi</span><span>50mi</span>
                    </div>
                </div>
            </div>

            <div class="p-6 arch-border-t bg-white">
                <button class="arch-btn-outline w-full text-xs">Reset Parameters</button>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col min-w-0 bg-blueprint relative">

            <!-- Header/Controls -->
            <div class="p-6 arch-border-b sticky z-40 flex flex-col gap-4" style="top:0;background:rgba(244,244,240,0.9);backdrop-filter:blur(4px)">
                <div class="flex justify-between items-start sm-items-center" style="flex-wrap:wrap;gap:1rem">
                    <div>
                        <h1 class="font-bold text-3xl uppercase tracking-tight mb-1">Resource Catalogue</h1>
                        <p class="font-mono text-xs uppercase" style="color:var(--arch-gray)">Showing 60 active listings within parameters</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 arch-border bg-white p-1">
                            <button style="padding:0.375rem;background:var(--arch-black);color:var(--arch-white)"><i data-icon="grid" class="icon icon-sm"></i></button>
                            <button style="padding:0.375rem;color:var(--arch-gray)"><i data-icon="list" class="icon icon-sm"></i></button>
                        </div>
                        <select class="arch-border p-2 font-mono text-xs font-bold uppercase" style="background:var(--arch-white);outline:none">
                            <option>Sort: Urgency (High-Low)</option>
                            <option>Sort: Distance (Nearest)</option>
                            <option>Sort: Quantity (High-Low)</option>
                            <option>Sort: Newest First</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                <div class="grid grid-cols-1 md-grid-cols-2 xl-grid-cols-3 gap-6" style="max-width:80rem;margin:0 auto">

                    <!-- Item Card 1 (Critical) -->
                    <article class="card-hover flex flex-col relative">
                        <div class="critical-badge">Critical</div>
                        <div class="catalogue-img img-placeholder" style="background:linear-gradient(135deg,#d4a574,#c49464,#b08454)">
                            <i data-icon="croissant" class="icon icon-2xl" style="opacity:0.3"></i>
                            <div class="img-id">ID: BATCH-8842</div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl uppercase leading-tight mb-2">Assorted Morning Pastries</h3>
                            <p class="font-mono text-xs mb-4" style="color:var(--arch-gray)">Local Bakery Co. &bull; 1.2mi</p>
                            <div class="grid grid-cols-2 gap-2 mb-6 font-mono uppercase" style="font-size:0.625rem">
                                <div class="arch-border p-2" style="background:var(--arch-light)">
                                    <span class="block mb-1" style="color:var(--arch-gray)">Quantity</span>
                                    <span class="font-bold text-sm">~15 lbs</span>
                                </div>
                                <div class="arch-border p-2" style="border-color:var(--arch-accent);color:var(--arch-accent)">
                                    <span class="block mb-1">Expires In</span>
                                    <span class="font-bold text-sm">45 mins</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-4" style="border-top:2px solid rgba(10,10,10,0.1)">
                                <div class="flex gap-1">
                                    <span class="badge-black">Bakery</span>
                                    <span class="badge-outline">Contains Gluten</span>
                                </div>
                                <button style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:background 0.2s" onmouseover="this.style.background='var(--arch-accent)'" onmouseout="this.style.background='var(--arch-black)'">
                                    <i data-icon="arrow-right" class="icon icon-md"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Item Card 2 -->
                    <article class="card-hover flex flex-col relative">
                        <div class="catalogue-img img-placeholder" style="background:linear-gradient(135deg,#8bc34a,#689f38,#558b2f)">
                            <i data-icon="carrot" class="icon icon-2xl" style="opacity:0.3"></i>
                            <div class="img-id">ID: BATCH-8843</div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl uppercase leading-tight mb-2">Imperfect Apples & Bananas</h3>
                            <p class="font-mono text-xs mb-4" style="color:var(--arch-gray)">City Supermarket &bull; 3.5mi</p>
                            <div class="grid grid-cols-2 gap-2 mb-6 font-mono uppercase" style="font-size:0.625rem">
                                <div class="arch-border p-2" style="background:var(--arch-light)">
                                    <span class="block mb-1" style="color:var(--arch-gray)">Quantity</span>
                                    <span class="font-bold text-sm">~20 lbs</span>
                                </div>
                                <div class="arch-border p-2" style="background:var(--arch-light)">
                                    <span class="block mb-1" style="color:var(--arch-gray)">Expires In</span>
                                    <span class="font-bold text-sm">2 hours</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-4" style="border-top:2px solid rgba(10,10,10,0.1)">
                                <div class="flex gap-1"><span class="badge-black">Produce</span></div>
                                <button style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:background 0.2s" onmouseover="this.style.background='var(--arch-accent)'" onmouseout="this.style.background='var(--arch-black)'">
                                    <i data-icon="arrow-right" class="icon icon-md"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Item Card 3 -->
                    <article class="card-hover flex flex-col relative">
                        <div class="catalogue-img img-placeholder flex items-center justify-center" style="background:var(--arch-light)">
                            <i data-icon="image-off" class="icon icon-2xl" style="opacity:0.3;color:var(--arch-gray)"></i>
                            <div class="img-id">ID: BATCH-8844</div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl uppercase leading-tight mb-2">Catered Event Leftovers (Sandwiches)</h3>
                            <p class="font-mono text-xs mb-4" style="color:var(--arch-gray)">Tech Corp Office &bull; 0.8mi</p>
                            <div class="grid grid-cols-2 gap-2 mb-6 font-mono uppercase" style="font-size:0.625rem">
                                <div class="arch-border p-2" style="background:var(--arch-light)">
                                    <span class="block mb-1" style="color:var(--arch-gray)">Quantity</span>
                                    <span class="font-bold text-sm">~30 items</span>
                                </div>
                                <div class="arch-border p-2" style="background:var(--arch-light)">
                                    <span class="block mb-1" style="color:var(--arch-gray)">Expires In</span>
                                    <span class="font-bold text-sm">4 hours</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-4" style="border-top:2px solid rgba(10,10,10,0.1)">
                                <div class="flex gap-1 flex-wrap">
                                    <span class="badge-black">Prepared</span>
                                    <span class="badge-outline">Meat</span>
                                    <span class="badge-outline">Dairy</span>
                                </div>
                                <button style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;flex-shrink:0;transition:background 0.2s" onmouseover="this.style.background='var(--arch-accent)'" onmouseout="this.style.background='var(--arch-black)'">
                                    <i data-icon="arrow-right" class="icon icon-md"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Item Card 4 (Claimed) -->
                    <article class="arch-border flex flex-col relative opacity-60" style="background:var(--arch-light)">
                        <div class="absolute inset-0 bg-blueprint pointer-events-none z-20" style="opacity:0.2"></div>
                        <div class="claimed-overlay"><div class="claimed-stamp">CLAIMED</div></div>
                        <div class="catalogue-img grayscale" style="background:linear-gradient(135deg,#90a4ae,#78909c,#607d8b)">
                            <div class="img-id">ID: BATCH-8845</div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-xl uppercase leading-tight mb-2 line-through">Excess Dairy Products</h3>
                            <p class="font-mono text-xs mb-4" style="color:var(--arch-gray)">Corner Bodega &bull; 2.1mi</p>
                            <div class="grid grid-cols-2 gap-2 mb-6 font-mono uppercase opacity-50" style="font-size:0.625rem">
                                <div class="arch-border p-2 bg-white"><span class="block mb-1" style="color:var(--arch-gray)">Quantity</span><span class="font-bold text-sm">~10 lbs</span></div>
                                <div class="arch-border p-2 bg-white"><span class="block mb-1" style="color:var(--arch-gray)">Status</span><span class="font-bold text-sm">Resolved</span></div>
                            </div>
                        </div>
                    </article>

                </div>

                <!-- Pagination -->
                <div class="pagination mt-12">
                    <button class="page-btn opacity-50 cursor-not-allowed"><i data-icon="chevron-left" class="icon icon-md"></i></button>
                    <span class="page-btn-active">1</span>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <span style="color:var(--arch-gray)">...</span>
                    <button class="page-btn"><i data-icon="chevron-right" class="icon icon-md"></i></button>
                </div>
            </div>
        </main>
    </div>

    <script src="icons.js"></script>
    <script src="nav.js"></script>
</body>
</html>
