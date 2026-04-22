<?php 
require_once '../backend/init.php'; 
require_once '../backend/protect.php';
require_once '../backend/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $quantity = floatval($_POST['quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    
    $allergensArray = isset($_POST['allergens']) && is_array($_POST['allergens']) ? $_POST['allergens'] : [];
    $allergens = implode(', ', $allergensArray);

    $available_time = trim($_POST['available_until'] ?? '');
    $pickup_location = trim($_POST['pickup_location'] ?? '');

    if (empty($title) || empty($category) || empty($quantity) || empty($available_time) || empty($pickup_location)) {
        $error = "Please fill in all required fields.";
    } else {
        $available_datetime = date('Y-m-d') . ' ' . $available_time . ':00';
        
        // If time passed, assume next day automatically
        if (strtotime($available_datetime) < time()) {
            $available_datetime = date('Y-m-d', strtotime('+1 day')) . ' ' . $available_time . ':00';
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO listings (user_id, title, description, category, quantity, pickup_location, available_until, allergens) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_SESSION['user_id'],
                $title,
                $description,
                $category,
                $quantity,
                $pickup_location,
                $available_datetime,
                $allergens
            ]);
            
            $success = "Your listing has been posted successfully!";
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
            error_log("Listing Insert Error: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle — Share Surplus Food</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="bg-page min-h-screen flex flex-col">
    <nav class="site-nav">
        <div class="nav-inner">
            <div class="flex items-center gap-4">
                <a href="feed.php" class="p-2 brutal-border transition-colors" onmouseover="this.style.background='var(--brand-400)'" onmouseout="this.style.background='transparent'">
                    <i data-icon="x" class="icon icon-lg"></i>
                </a>
                <div class="sm-flex hidden items-center gap-2">
                    <span class="font-display text-2xl tracking-wide mt-1">Cancel</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-black text-white px-4 py-2 brutal-border font-display text-xl uppercase tracking-wider flex items-center gap-2">
                    Step 1 of 3
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow container py-12" style="max-width:48rem">
        <div class="mb-12">
            <div class="tag-skew mb-4">New Listing</div>
            <h1 class="font-display text-6xl sm-text-7xl leading-none mb-4">
                Share <span class="text-brand-600">Surplus</span><br>Food
            </h1>
            <p class="text-xl font-medium border-l-brand-thick">
                List your excess food to connect with local rescuers. Be as descriptive as possible.
            </p>
        </div>

        <?php if ($error): ?>
            <div class="p-4 mb-8 brutal-border" style="background:var(--red-50);border-color:var(--red-500);color:var(--red-600)">
                <span class="font-bold uppercase text-sm"><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="p-4 mb-8 brutal-border" style="background:#e8f5e9;border-color:#4caf50;color:#2e7d32">
                <span class="font-bold uppercase text-sm"><?php echo htmlspecialchars($success); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="new-listing.php" class="space-y-8">
            <div class="bg-white brutal-border p-6 sm-p-8 relative">
                <div class="absolute z-10" style="top:-1rem;right:-1rem;background:#000;color:#fff;border:3px solid #000;padding:0.5rem 1rem;font-family:var(--font-display);font-size:1.5rem;text-transform:uppercase;transform:rotate(6deg)">
                    01. Basics
                </div>
                <div class="space-y-6">
                    <div>
                        <label for="title" class="font-bold uppercase text-sm text-gray-500 block mb-2">Listing Title</label>
                        <input type="text" name="title" id="title" required placeholder="e.g., Morning Pastries Batch" class="input-brutal">
                    </div>
                    <div class="grid grid-cols-1 sm-grid-cols-2 gap-6">
                        <div>
                            <label for="category" class="font-bold uppercase text-sm text-gray-500 block mb-2">Food Category</label>
                            <select name="category" id="category" required class="select-brutal">
                                <option value="">Select Category...</option>
                                <option value="Produce">Produce & Veg</option>
                                <option value="Baked Goods">Baked Goods</option>
                                <option value="Prepared Meals">Prepared Meals</option>
                                <option value="Dairy">Dairy & Eggs</option>
                                <option value="Pantry Staples">Pantry Staples</option>
                            </select>
                        </div>
                        <div>
                            <label for="quantity" class="font-bold uppercase text-sm text-gray-500 block mb-2">Estimated Quantity (lbs)</label>
                            <input type="number" name="quantity" id="quantity" required step="0.01" min="0" placeholder="e.g., 15" class="input-brutal">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white brutal-border p-6 sm-p-8 relative">
                <div class="absolute z-10" style="top:-1rem;right:-1rem;background:#000;color:#fff;border:3px solid #000;padding:0.5rem 1rem;font-family:var(--font-display);font-size:1.5rem;text-transform:uppercase;transform:rotate(6deg)">
                    02. Details
                </div>
                <div class="space-y-6">
                    <div>
                        <label for="description" class="font-bold uppercase text-sm text-gray-500 block mb-2">Description & Contents</label>
                        <textarea name="description" id="description" rows="4" placeholder="Describe what's included, condition, and any packaging details..." class="textarea-brutal"></textarea>
                    </div>
                    <div>
                        <label class="font-bold uppercase text-sm text-gray-500 block mb-4">Allergen Warnings (Select all that apply)</label>
                        <div class="flex flex-wrap gap-3" id="allergens">
                            <label class="cursor-pointer">
                                <input type="checkbox" name="allergens[]" value="Gluten" class="sr-only" onchange="this.nextElementSibling.style.background=this.checked?'var(--brand-400)':'var(--bg)'">
                                <div class="brutal-border px-4 py-2 font-bold uppercase text-sm transition-colors" style="background:var(--bg)">Gluten</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="checkbox" name="allergens[]" value="Dairy" class="sr-only" onchange="this.nextElementSibling.style.background=this.checked?'var(--brand-400)':'var(--bg)'">
                                <div class="brutal-border px-4 py-2 font-bold uppercase text-sm transition-colors" style="background:var(--bg)">Dairy</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="checkbox" name="allergens[]" value="Nuts" class="sr-only" onchange="this.nextElementSibling.style.background=this.checked?'var(--brand-400)':'var(--bg)'">
                                <div class="brutal-border px-4 py-2 font-bold uppercase text-sm transition-colors" style="background:var(--bg)">Nuts</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="checkbox" name="allergens[]" value="Meat" class="sr-only" onchange="this.nextElementSibling.style.background=this.checked?'var(--brand-400)':'var(--bg)'">
                                <div class="brutal-border px-4 py-2 font-bold uppercase text-sm transition-colors" style="background:var(--bg)">Meat</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="checkbox" name="allergens[]" value="None" class="sr-only" onchange="this.nextElementSibling.style.background=this.checked?'#000':'var(--bg)';this.nextElementSibling.style.color=this.checked?'#fff':'#000'">
                                <div class="brutal-border px-4 py-2 font-bold uppercase text-sm transition-colors" style="background:var(--bg)">None</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white brutal-border p-6 sm-p-8 relative">
                <div class="absolute z-10" style="top:-1rem;right:-1rem;background:#000;color:#fff;border:3px solid #000;padding:0.5rem 1rem;font-family:var(--font-display);font-size:1.5rem;text-transform:uppercase;transform:rotate(6deg)">
                    03. Logistics
                </div>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 sm-grid-cols-2 gap-6">
                        <div>
                            <label for="available_until" class="font-bold uppercase text-sm text-gray-500 block mb-2">Available Until</label>
                            <input type="time" name="available_until" id="available_until" required class="input-brutal">
                        </div>
                        <div>
                            <label for="pickup_location" class="font-bold uppercase text-sm text-gray-500 block mb-2">Pickup Location</label>
                            <select name="pickup_location" id="pickup_location" required class="select-brutal">
                                <option value="">Select Location...</option>
                                <option value="Main Storefront">Main Storefront</option>
                                <option value="Back Alley Door">Back Alley Door</option>
                                <option value="Loading Dock B">Loading Dock B</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="font-bold uppercase text-sm text-gray-500 block mb-2">Special Pickup Instructions</label>
                        <textarea rows="2" placeholder="e.g., Ring the bell, bring your own bags..." class="textarea-brutal"></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col gap-6 sm-flex-row sm-items-center" style="justify-content:space-between">
                <p class="text-sm font-bold uppercase text-gray-500 text-center">
                    By posting, you agree to our <a href="#" class="underline" style="color:#000" onmouseover="this.style.color='var(--brand-600)'" onmouseout="this.style.color='#000'">Food Safety Guidelines</a>.
                </p>
                <button type="submit" class="btn-primary brutal-shadow" style="width:auto;padding:1.25rem 3rem" onmouseover="this.style.background='#000'" onmouseout="this.style.background='var(--brand-600)'">
                    Post Listing
                </button>
            </div>
        </form>
    </main>
    <script src="assets/icons.js"></script>
</body>
</html>
