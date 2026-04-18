<?php
session_start();
require '../backend/db.php';
$error = '';
$success = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $success = "Registration successful. You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH - REGISTER</title>
    <link rel="stylesheet" href="assets/styles.css">
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
                        Registration Protocol
                    </div>
                    <h1 class="font-bold tracking-tight mb-6" style="font-size:3rem;line-height:1.1">
                        INITIALIZE<br>OPERATOR.
                    </h1>
                    <p class="text-lg font-medium" style="color:var(--arch-gray);max-width:28rem">
                        Join the logistics network to coordinate surplus food distribution and track community impact metrics.
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
                            Level 1 (Pending)
                        </div>
                    </div>
                </div>
                <i data-icon="fingerprint" class="icon icon-huge absolute" style="bottom:-5rem;right:-5rem;opacity:0.05;color:var(--arch-black)"></i>
            </div>
            <div class="p-8 lg-p-12 relative" style="background:var(--arch-white)">
                <div class="mb-8">
                    <h2 class="font-bold tracking-tight mb-2" style="font-size:1.875rem">System Registration</h2>
                    <p class="font-mono text-sm" style="color:var(--arch-gray)">Create credentials to access network.</p>
                </div>
                <?php if ($error): ?>
                    <div style="background: #ffcccc; color: #cc0000; padding: 10px; margin-bottom: 20px; border: 1px solid #cc0000; font-family: monospace;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div style="background: #ccffcc; color: #006600; padding: 10px; margin-bottom: 20px; border: 1px solid #006600; font-family: monospace;">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="register.php" class="space-y-6">
                    <div class="relative">
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-1">
                            Operator [Name]
                        </label>
                        <input type="text" name="name" placeholder="John Doe" class="arch-input" required>
                    </div>
                    <div class="relative">
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-1">
                            Identification [Email]
                        </label>
                        <input type="email" name="email" placeholder="operator@rescue-arch.org" class="arch-input" required>
                        <i data-icon="mail" class="icon icon-md absolute" style="right:0;bottom:1rem;color:var(--arch-gray)"></i>
                    </div>
                    <div class="relative">
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-1">
                            Passcode [Password]
                        </label>
                        <input type="password" name="password" placeholder="••••••••••••" class="arch-input" required minlength="8">
                    </div>
                    <div class="pt-6 space-y-4">
                        <button type="submit" class="arch-btn w-full">
                            <span>Register Operator</span>
                            <i data-icon="arrow-right" class="icon icon-md"></i>
                        </button>
                        <div class="text-center">
                            <span class="font-mono text-xs uppercase" style="color:var(--arch-gray)">
                                Already have Clearance?
                                <a href="login.php" class="font-bold ml-2 pb-1 transition-colors" style="color:var(--arch-black);border-bottom:1px solid var(--arch-black)" onmouseover="this.style.color='var(--arch-accent)';this.style.borderColor='var(--arch-accent)'" onmouseout="this.style.color='var(--arch-black)';this.style.borderColor='var(--arch-black)'">
                                    System_Login
                                </a>
                            </span>
                        </div>
                    </div>
                </form>
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
    <script src="assets/icons.js"></script>
    <script src="assets/nav.js"></script>
</body>
</html>

