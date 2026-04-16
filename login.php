<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: dashboard.php");
        exit;
    }
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $stmt->execute([$token, $user['id']]);
                
                setcookie("remember_token", $token, time() + (86400 * 30), "/", "", false, true);
            }

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH - LOGIN</title>
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
            SYS.AUTH.v2.4 // SECURE_CONNECTION
        </div>
        <a href="index.php" class="font-mono text-sm font-bold transition-colors" onmouseover="this.style.color='var(--arch-accent)'" onmouseout="this.style.color='inherit'">
            [ RETURN_HOME ]
        </a>
    </header>

    <main class="flex-grow flex items-center justify-center p-4 relative" style="padding:2rem">

        <div class="crosshair lg-block hidden" style="top:2rem;left:2rem"></div>
        <div class="crosshair lg-block hidden" style="top:2rem;right:2rem"></div>
        <div class="crosshair lg-block hidden" style="bottom:2rem;left:2rem"></div>
        <div class="crosshair lg-block hidden" style="bottom:2rem;right:2rem"></div>

        <div class="arch-border w-full grid grid-cols-1 lg-grid-cols-2" style="max-width:64rem;background:var(--arch-white);box-shadow:8px 8px 0 var(--arch-black)">

            <div class="arch-border-r p-8 lg-p-12 flex flex-col justify-between relative overflow-hidden md-flex hidden" style="background:var(--arch-light)">
                <div class="relative z-10">
                    <div class="inline-block font-mono text-xs uppercase mb-8" style="background:var(--arch-black);color:var(--arch-white);padding:0.25rem 0.75rem">
                        Access Protocol
                    </div>
                    <h1 class="font-bold tracking-tight mb-6" style="font-size:3rem;line-height:1.1">
                        AUTHENTICATION<br>REQUIRED.
                    </h1>
                    <p class="text-lg font-medium" style="color:var(--arch-gray);max-width:28rem">
                        Access the logistics network to coordinate surplus food distribution and track community impact metrics.
                    </p>
                </div>

                <div class="relative z-10 mt-12">
                    <div class="grid grid-cols-2 gap-4 font-mono text-xs uppercase" style="color:var(--arch-gray)">
                        <div>
                            <span class="block font-bold mb-1" style="color:var(--arch-black)">Active Nodes</span>
                            [ 1,204 ]
                        </div>
                        <div>
                            <span class="block font-bold mb-1" style="color:var(--arch-black)">System Status</span>
                            [ OPTIMAL ]
                        </div>
                        <div class="col-span-2 mt-4 pt-4 arch-border-b" style="border-color:rgba(142,142,142,0.3)">
                            <span class="block font-bold mb-1" style="color:var(--arch-black)">Security Clearance</span>
                            Level 2 (Coordinator) / Level 3 (Admin)
                        </div>
                    </div>
                </div>

                <i data-icon="fingerprint" class="icon icon-huge absolute" style="bottom:-5rem;right:-5rem;opacity:0.05;color:var(--arch-black)"></i>
            </div>

            <div class="p-8 lg-p-12 relative" style="background:var(--arch-white)">

                <div class="mb-8">
                    <h2 class="font-bold tracking-tight mb-2" style="font-size:1.875rem">System Login</h2>
                    <p class="font-mono text-sm" style="color:var(--arch-gray)">Enter credentials to initialize session.</p>
                </div>
                
                <?php if ($error): ?>
                    <div style="background: #ffcccc; color: #cc0000; padding: 10px; margin-bottom: 20px; border: 1px solid #cc0000; font-family: monospace;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php" class="space-y-8">

                    <div class="relative">
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-1">
                            Identification [Email]
                        </label>
                        <input type="email" name="email" placeholder="operator@rescue-arch.org" class="arch-input" required>
                        <i data-icon="mail" class="icon icon-md absolute" style="right:0;bottom:1rem;color:var(--arch-gray)"></i>
                    </div>

                    <div class="relative">
                        <div class="flex justify-between items-end mb-1">
                            <label class="font-mono text-xs font-bold uppercase tracking-widest block">
                                Passcode [Password]
                            </label>
                            <a href="#" class="font-mono uppercase tracking-wider transition-colors" style="font-size:0.625rem;color:var(--arch-gray)" onmouseover="this.style.color='var(--arch-accent)'" onmouseout="this.style.color='var(--arch-gray)'">
                                Reset_Key?
                            </a>
                        </div>
                        <input type="password" name="password" placeholder="••••••••••••" class="arch-input" required>
                        <button type="button" class="absolute transition-colors" style="right:0;bottom:1rem;color:var(--arch-gray)" onmouseover="this.style.color='var(--arch-black)'" onmouseout="this.style.color='var(--arch-gray)'">
                            <i data-icon="eye" class="icon icon-md"></i>
                        </button>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <label class="relative flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="sr-only" id="remember">
                            <div class="arch-border" style="width:1.25rem;height:1.25rem;background:transparent;display:flex;align-items:center;justify-content:center;cursor:pointer" onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.style.background = this.previousElementSibling.checked ? 'var(--arch-black)' : 'transparent'">
                            </div>
                        </label>
                        <span class="font-mono text-xs uppercase" style="color:var(--arch-gray)">Maintain Session State</span>
                    </div>

                    <div class="pt-6 space-y-4">
                        <button type="submit" class="arch-btn w-full">
                            <span>Initialize Session</span>
                            <i data-icon="arrow-right" class="icon icon-md"></i>
                        </button>

                        <div class="text-center">
                            <span class="font-mono text-xs uppercase" style="color:var(--arch-gray)">
                                No Clearance?
                                <a href="register.php" class="font-bold ml-2 pb-1 transition-colors" style="color:var(--arch-black);border-bottom:1px solid var(--arch-black)" onmouseover="this.style.color='var(--arch-accent)';this.style.borderColor='var(--arch-accent)'" onmouseout="this.style.color='var(--arch-black)';this.style.borderColor='var(--arch-black)'">
                                    Request_Access
                                </a>
                            </span>
                        </div>
                    </div>

                </form>

                <div class="mt-12 pt-8 relative" style="border-top:2px solid rgba(10,10,10,0.1)">
                    <div class="absolute font-mono uppercase tracking-widest" style="top:-0.75rem;left:50%;transform:translateX(-50%);background:var(--arch-white);padding:0 1rem;font-size:0.625rem;color:var(--arch-gray)">
                        Or_Authenticate_Via
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex items-center justify-center gap-2 py-3 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors" onmouseover="this.style.background='var(--arch-black)';this.style.color='var(--arch-white)'" onmouseout="this.style.background='transparent';this.style.color='var(--arch-black)'">
                            <i data-icon="github" class="icon icon-sm"></i> GitHub
                        </button>
                        <button class="flex items-center justify-center gap-2 py-3 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors" onmouseover="this.style.background='var(--arch-black)';this.style.color='var(--arch-white)'" onmouseout="this.style.background='transparent';this.style.color='var(--arch-black)'">
                            <i data-icon="chrome" class="icon icon-sm"></i> Google
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="arch-footer">
        <div>&copy; 2024 RESCUE_ARCH. ALL RIGHTS RESERVED.</div>
        <div class="flex gap-4">
            <a href="#">TERMS</a>
            <a href="#">PRIVACY</a>
        </div>
    </footer>

    <script src="icons.js"></script>
    <script src="nav.js"></script>
</body>
</html>
