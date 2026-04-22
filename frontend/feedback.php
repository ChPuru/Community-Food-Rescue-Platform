<?php 
require_once '../backend/init.php'; 
require_once '../backend/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['feedback-cat'] ?? '';
    $subject = trim($_POST['subject'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $contact_consent = isset($_POST['contact']) ? 1 : 0;
    
    // Auth logic optional (can be anonymous or linked to session user)
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (empty($category) || empty($subject) || empty($description)) {
        $error = "CATEGORY, SUBJECT, and DESCRIPTION are required parameters.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO feedback (user_id, category, subject, description, contact_consent) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $category, $subject, $description, $contact_consent]);
            $success = "SYS.FEEDBACK RECEIVED. LOGGED SUCCESSFULLY.";
        } catch (PDOException $e) {
            $error = "DATABASE WRITE ERROR. PLEASE TRY AGAIN LATER.";
            error_log("Feedback Insert Error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESCUE_ARCH - FEEDBACK</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="min-h-screen flex flex-col bg-blueprint" style="background-color:var(--arch-white);color:var(--arch-black)">
    <header class="arch-border-b flex justify-between items-center px-6 py-4 sticky z-50" style="top:0;background:var(--arch-white)">
        <div class="flex items-center gap-3">
            <div style="width:1.5rem;height:1.5rem;background:var(--arch-black);display:flex;align-items:center;justify-content:center">
                <i data-icon="message-square" class="icon icon-sm" style="color:var(--arch-white)"></i>
            </div>
            <span class="font-bold tracking-tight text-xl uppercase">Rescue_Arch</span>
        </div>
        <div class="font-mono text-xs sm-block hidden" style="color:var(--arch-gray);text-transform:uppercase;letter-spacing:0.1em">
            SYS.FEEDBACK.v1.2 // OPEN_CHANNEL
        </div>
        <a href="index.php" class="font-mono text-sm font-bold transition-colors" onmouseover="this.style.color='var(--arch-accent)'" onmouseout="this.style.color='inherit'">
            [ RETURN_HOME ]
        </a>
    </header>
    <main class="flex-grow flex items-center justify-center" style="padding:2rem">
        <div class="arch-border w-full" style="max-width:48rem;background:var(--arch-white);box-shadow:8px 8px 0 var(--arch-black)">
            <div class="arch-border-b p-8 lg-p-12 relative overflow-hidden" style="background:var(--arch-light)">
                <i data-icon="megaphone" class="icon icon-huge absolute" style="right:-5rem;top:-5rem;opacity:0.05;color:var(--arch-black);transform:rotate(-12deg)"></i>
                <div class="relative z-10">
                    <div class="inline-block font-mono text-xs uppercase mb-6" style="background:var(--arch-black);color:var(--arch-white);padding:0.25rem 0.75rem">
                        Feedback Protocol
                    </div>
                    <h1 class="font-bold tracking-tight mb-3" style="font-size:2.25rem;line-height:1.1">
                        REPORT. SUGGEST. IMPROVE.
                    </h1>
                    <p class="text-lg font-medium" style="color:var(--arch-gray);max-width:32rem">
                        Your feedback directly impacts how we build and refine the rescue network. Every report counts.
                    </p>
                </div>
            </div>
            <div class="p-8 lg-p-12">
                <?php if ($error): ?>
                    <div class="arch-border p-4 mb-6 font-mono font-bold text-sm" style="background:#ffebee;color:#c62828;">
                        [!] <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="arch-border p-4 mb-6 font-mono font-bold text-sm" style="background:#e8f5e9;color:#2e7d32;">
                        [OK] <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="feedback.php" class="space-y-8">
                    <div>
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-4">
                            Feedback Category *
                        </label>
                        <div class="grid grid-cols-2 sm-grid-cols-4 gap-2">
                            <div><input type="radio" name="feedback-cat" id="cat-bug" value="bug" class="sr-only rating-input" required><label for="cat-bug" class="block text-center py-3 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors"><i data-icon="x" class="icon icon-sm inline-block mb-1"></i><br>Bug/Issue</label></div>
                            <div><input type="radio" name="feedback-cat" id="cat-idea" value="idea" class="sr-only rating-input" required><label for="cat-idea" class="block text-center py-3 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors"><i data-icon="plus" class="icon icon-sm inline-block mb-1"></i><br>Idea</label></div>
                            <div><input type="radio" name="feedback-cat" id="cat-praise" value="praise" class="sr-only rating-input" required><label for="cat-praise" class="block text-center py-3 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors"><i data-icon="trophy" class="icon icon-sm inline-block mb-1"></i><br>Praise</label></div>
                            <div><input type="radio" name="feedback-cat" id="cat-other" value="other" class="sr-only rating-input" required><label for="cat-other" class="block text-center py-3 arch-border font-mono text-xs font-bold uppercase cursor-pointer transition-colors"><i data-icon="layers" class="icon icon-sm inline-block mb-1"></i><br>Other</label></div>
                        </div>
                    </div>
                    <div class="relative">
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-1">Subject *</label>
                        <input type="text" name="subject" placeholder="Brief summary of your feedback" class="arch-input" required>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-1">
                            <label class="font-mono text-xs font-bold uppercase tracking-widest block">Detailed Description *</label>
                            <span class="font-mono" style="font-size:0.625rem;color:var(--arch-gray)">0 / 500</span>
                        </div>
                        <textarea name="description" maxlength="500" rows="6" placeholder="Provide as much detail as possible. If reporting a bug, include steps to reproduce..." class="arch-textarea" required></textarea>
                    </div>
                    <div>
                        <label class="font-mono text-xs font-bold uppercase tracking-widest block mb-4">Attachment (Optional Placeholder)</label>
                        <div class="arch-border p-6 text-center cursor-pointer transition-colors" style="border-style:dashed;background:var(--arch-light)" onmouseover="this.style.background='#fff'" onmouseout="this.style.background='var(--arch-light)'">
                            <i data-icon="upload-cloud" class="icon icon-2xl mb-2" style="display:inline-block;color:var(--arch-gray)"></i>
                            <p class="font-mono text-xs font-bold uppercase mb-1" style="color:var(--arch-gray)">Click or drag to upload</p>
                            <p class="font-mono" style="font-size:0.625rem;color:var(--arch-gray)">PNG, JPG, PDF &mdash; MAX 5MB</p>
                            <input type="file" name="attachment_placeholder" class="hidden" accept=".png,.jpg,.jpeg,.pdf">
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <label class="relative flex items-center cursor-pointer">
                            <input type="checkbox" name="contact" value="1" class="sr-only">
                            <div class="arch-border transition-colors outline-box" style="width:1.25rem;height:1.25rem;display:flex;align-items:center;justify-content:center;cursor:pointer" onclick="this.previousElementSibling.click(); this.style.background = this.previousElementSibling.checked ? 'var(--arch-black)' : 'transparent'"></div>
                        </label>
                        <span class="font-mono text-sm" style="color:var(--arch-gray)">I would like to be contacted about this feedback.</span>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="arch-btn">
                            <span>Submit Feedback</span>
                            <i data-icon="send" class="icon icon-md"></i>
                        </button>
                        <p class="font-mono mt-4 text-center" style="font-size:0.625rem;color:var(--arch-gray);text-transform:uppercase;letter-spacing:0.1em">
                            All submissions are reviewed within 48 hours.
                        </p>
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
