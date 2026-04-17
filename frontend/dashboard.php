<?php
require 'protect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH - SYSTEM DASHBOARD</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="min-h-screen flex flex-col bg-blueprint" style="background-color:var(--arch-white);color:var(--arch-black)">

    <header class="arch-border-b flex justify-between items-center px-6 py-4 sticky z-50" style="top:0;background:var(--arch-white)">
        <div class="flex items-center gap-3">
            <div style="width:1.5rem;height:1.5rem;background:var(--arch-black);display:flex;align-items:center;justify-content:center">
                <i data-icon="box" class="icon icon-sm" style="color:var(--arch-white)"></i>
            </div>
            <span class="font-bold tracking-tight text-xl uppercase">Rescue_Arch</span>
        </div>
        <div class="font-mono text-xs sm-block hidden" style="color:var(--arch-gray);text-transform:uppercase;letter-spacing:0.1em">
            NODE: DASHBOARD // CLEARANCE: SECURE
        </div>
        <div class="flex items-center gap-6">
            <span class="font-mono text-sm font-bold">OP: <?php echo htmlspecialchars(strtoupper($_SESSION['user_name'])); ?></span>
            <a href="logout.php" class="font-mono text-sm font-bold transition-colors" onmouseover="this.style.color='var(--arch-accent)'" onmouseout="this.style.color='inherit'">
                [ TERMINATE_SESSION ]
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center p-4 relative" style="padding:2rem">
        <div class="arch-border w-full p-8 lg-p-12 text-center" style="max-width:64rem;background:var(--arch-white);box-shadow:8px 8px 0 var(--arch-black)">
            <h1 class="font-bold tracking-tight mb-6" style="font-size:3rem;line-height:1.1">
                ACCESS GRANTED.
            </h1>
            <p class="text-lg font-medium mb-8" style="color:var(--arch-gray)">
                Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>. Your session is secured.
            </p>
            <div class="grid grid-cols-1 md-grid-cols-2 gap-4">
                <a href="index.php" class="arch-btn w-full justify-center">
                    <span>Return to Public Directory</span>
                </a>
                <a href="logout.php" class="arch-btn w-full justify-center" style="background:transparent; color:var(--arch-black); border-color:var(--arch-black)" onmouseover="this.style.background='var(--arch-black)';this.style.color='var(--arch-white)'" onmouseout="this.style.background='transparent';this.style.color='var(--arch-black)'">
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </main>

    <script src="icons.js"></script>
    <script src="nav.js"></script>
</body>
</html>
