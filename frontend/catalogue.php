<?php
require_once '../backend/init.php';
require_once '../backend/db.php';
$stmt = $pdo->prepare("SELECT l.*, u.name as operator_name FROM listings l JOIN users u ON l.user_id = u.id WHERE l.status = 'active' ORDER BY l.created_at DESC");
$stmt->execute();
$listings = $stmt->fetchAll();
?>
<?php require_once '../backend/init.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH | CATALOGUE</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="min-h-screen flex flex-col custom-scrollbar"
    style="background-color:var(--arch-white);color:var(--arch-black)">
    <header class="arch-border-b flex justify-between items-center px-6 py-4 sticky z-50"
        style="top:0;background:var(--arch-white)">
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <div
                    style="width:2rem;height:2rem;background:var(--arch-black);display:flex;align-items:center;justify-content:center">
                    <i data-icon="layers" class="icon icon-md" style="color:var(--arch-white)"></i>
                </div>
                <span class="font-bold tracking-tight text-xl uppercase">Rescue_Arch</span>
            </div>
            <nav class="md-flex hidden items-center gap-6 font-mono text-xs font-bold uppercase tracking-widest">
                <a href="index.php" class="transition-colors" style="color:var(--arch-gray)"
                    onmouseover="this.style.color='var(--arch-black)'"
                    onmouseout="this.style.color='var(--arch-gray)'">Dashboard</a>
                <a href="#"
                    style="color:var(--arch-black);border-bottom:2px solid var(--arch-black);padding-bottom:0.25rem">Catalogue</a>
                <a href="impact.php" class="transition-colors" style="color:var(--arch-gray)"
                    onmouseover="this.style.color='var(--arch-black)'"
                    onmouseout="this.style.color='var(--arch-gray)'">Impact</a>
            </nav>
        </div>
        <div class="flex items-center gap-4">
            <div class="sm-flex hidden items-center gap-2 arch-border px-3 py-1" style="background:var(--arch-light)">
                <span class="pulse"
                    style="width:0.5rem;height:0.5rem;background:var(--arch-accent);border-radius:9999px;display:inline-block"></span>
                <span class="font-mono font-bold uppercase" style="font-size:0.625rem">System Online</span>
            </div>
            <button class="arch-border p-2 relative transition-colors"
                onmouseover="this.style.background='var(--arch-black)';this.style.color='var(--arch-white)'"
                onmouseout="this.style.background='transparent';this.style.color='var(--arch-black)'">
                <i data-icon="bell" class="icon icon-md"></i>
                <span class="absolute arch-border"
                    style="top:-0.25rem;right:-0.25rem;width:0.75rem;height:0.75rem;background:var(--arch-accent);border-radius:9999px"></span>
            </button>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="arch-border font-bold font-mono text-sm"
                    title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>"
                    style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 2)); ?>
                </div>
            <?php else: ?>
                <a href="login.php" class="arch-border font-bold font-mono text-sm"
                    style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;text-decoration:none;">IN</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="flex flex-1 overflow-hidden">
        <aside class="arch-border-r lg-flex hidden flex-col overflow-y-auto custom-scrollbar"
            style="width:18rem;background:var(--arch-light);flex-shrink:0">
            <div class="p-6 arch-border-b bg-white">
                <h2 class="font-bold text-2xl uppercase tracking-tight mb-4">Parameters</h2>
                <div class="relative mb-2">
                    <input type="text" placeholder="Search inventory..." class="arch-input-sm"
                        style="padding-left:2rem">
                    <i data-icon="search" class="icon icon-md absolute"
                        style="left:0;bottom:0.75rem;color:var(--arch-gray)"></i>
                </div>
            </div>
            <div class="p-6 flex-1 space-y-8">
                <div>
                    <h3
                        class="font-mono text-xs font-bold uppercase tracking-widest mb-4 flex justify-between items-center">
                        Category</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked
                                class="checkbox-brutal" style="width:1rem;height:1rem"><span
                                class="font-mono text-sm uppercase">Produce</span></label>
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked
                                class="checkbox-brutal" style="width:1rem;height:1rem"><span
                                class="font-mono text-sm uppercase">Bakery</span></label>
                    </div>
                </div>
            </div>
            <div class="p-6 arch-border-t bg-white">
                <button class="arch-btn-outline w-full text-xs">Reset Parameters</button>
            </div>
        </aside>
        <main class="flex-1 flex flex-col min-w-0 bg-blueprint relative">
            <div class="p-6 arch-border-b sticky z-40 flex flex-col gap-4"
                style="top:0;background:rgba(244,244,240,0.9);backdrop-filter:blur(4px)">
                <div class="flex justify-between items-start sm-items-center" style="flex-wrap:wrap;gap:1rem">
                    <div>
                        <h1 class="font-bold text-3xl uppercase tracking-tight mb-1">Resource Catalogue</h1>
                        <<<<<<< HEAD <p class="font-mono text-xs uppercase" style="color:var(--arch-gray)">Showing
                            <?php echo count($listings); ?> active listings</p>
                            =======
                            <p class="font-mono text-xs uppercase" style="color:var(--arch-gray)" id="catalogue-count">
                                Showing 0 active listings</p>
                            >>>>>>> cc25cf5 (implemented dynamic food catalog with countdown timers and status
                            indicators)
                    </div>
                    <div class="flex items-center gap-4">
                        <select class="arch-border p-2 font-mono text-xs font-bold uppercase"
                            style="background:var(--arch-white);outline:none">
                            <option>Sort: Newest First</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                <<<<<<< HEAD <div class="grid grid-cols-1 md-grid-cols-2 xl-grid-cols-3 gap-6"
                    style="max-width:80rem;margin:0 auto">
                    <?php foreach ($listings as $item): ?>
                        <article class="card-hover flex flex-col relative">
                            <?php
                            $diff = strtotime($item['available_until']) - time();
                            if ($diff > 0 && $diff < 7200):
                                ?>
                                <div class="critical-badge">Critical</div>
                            <?php endif; ?>
                            <div class="catalogue-img img-placeholder" style="background:var(--arch-light)">
                                <?php
                                $icon = 'package';
                                if ($item['category'] == 'Produce')
                                    $icon = 'carrot';
                                elseif ($item['category'] == 'Baked Goods')
                                    $icon = 'croissant';
                                ?>
                                <i data-icon="<?php echo $icon; ?>" class="icon icon-2xl" style="opacity:0.3"></i>
                                <div class="img-id">ID: BATCH-<?php echo str_pad($item['id'], 4, '0', STR_PAD_LEFT); ?>
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-bold text-xl uppercase leading-tight mb-2">
                                    <?php echo htmlspecialchars($item['title']); ?></h3>
                                <p class="font-mono text-xs mb-4" style="color:var(--arch-gray)">
                                    <?php echo htmlspecialchars($item['operator_name']); ?> &bull;
                                    <?php echo htmlspecialchars($item['pickup_location']); ?></p>
                                <div class="grid grid-cols-2 gap-2 mb-6 font-mono uppercase" style="font-size:0.625rem">
                                    <div class="arch-border p-2" style="background:var(--arch-light)">
                                        <span class="block mb-1" style="color:var(--arch-gray)">Quantity</span>
                                        <span class="font-bold text-sm">~<?php echo htmlspecialchars($item['quantity']); ?>
                                            lbs</span>
                                    </div>
                                    <div class="arch-border p-2" style="background:var(--arch-light)">
                                        <span class="block mb-1" style="color:var(--arch-gray)">Expires AT</span>
                                        <span
                                            class="font-bold text-sm"><?php echo date('H:i', strtotime($item['available_until'])); ?></span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-auto pt-4"
                                    style="border-top:2px solid rgba(10,10,10,0.1)">
                                    <div class="flex gap-1">
                                        <span class="badge-black"><?php echo htmlspecialchars($item['category']); ?></span>
                                    </div>
                                    <button
                                        style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:background 0.2s"
                                        onmouseover="this.style.background='var(--arch-accent)'"
                                        onmouseout="this.style.background='var(--arch-black)'">
                                        <i data-icon="arrow-right" class="icon icon-md"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    =======
                    <div class="grid grid-cols-1 md-grid-cols-2 xl-grid-cols-3 gap-6" id="catalogue-grid"
                        style="max-width:80rem;margin:0 auto">
                        >>>>>>> cc25cf5 (implemented dynamic food catalog with countdown timers and status indicators)
                    </div>
            </div>
        </main>
    </div>
    <script src="assets/icons.js"></script>
    <<<<<<< HEAD=======<script src="assets/catalogue.js">
        </script>
        >>>>>>> cc25cf5 (implemented dynamic food catalog with countdown timers and status indicators)
        <script src="assets/nav.js"></script>
</body>

</html>