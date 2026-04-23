<?php 
/*
   Submit New Food Donation
   Only accessible by Donor accounts.
   Includes image upload and detailed category management.
*/
require_once '../backend/init.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - List Surplus Food</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .form-container {
            max-width: 700px;
            margin: 40px auto;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="card form-container">
                <div style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 25px">
                    <h2 style="color: var(--primary-color)">Submit Surplus Donation</h2>
                    <p style="font-size: 0.9rem; color: #666">Enter the details of the food you wish to donate for rescue.</p>
                </div>

                <form action="../backend/api_listings.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="form-group">
                        <label class="form-label">Listing Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Fresh Baked Bagels" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px">
                        <div class="form-group">
                            <label class="form-label">Food Category</label>
                            <select name="category" class="form-control" required>
                                <option value="Produce">Fresh Produce</option>
                                <option value="Baked Goods">Bakery Items</option>
                                <option value="Dairy">Dairy Products</option>
                                <option value="Meals">Prepared Meals</option>
                                <option value="Pantry">Pantry Staples</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Approx. Quantity (lbs)</label>
                            <input type="number" name="quantity" class="form-control" placeholder="10" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Available Until (Date & Time)</label>
                        <input type="datetime-local" name="available_until" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description / Special Instructions</label>
                        <textarea name="description" class="form-control" style="height: 100px" placeholder="Details about the food condition, packaging, or pickup instructions..."></textarea>
                    </div>

                    <div class="form-group" style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px dashed #ccc">
                        <label class="form-label" style="display: flex; align-items: center; gap: 10px">
                            <i data-icon="image" class="icon"></i> Upload Food Image (Optional)
                        </label>
                        <input type="file" name="food_image" accept="image/*" class="form-control" style="background: white">
                        <p style="font-size: 10px; color: #888; margin-top: 8px">Max file size: 2MB. Format: JPG, PNG.</p>
                    </div>

                    <div style="margin-top: 30px">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px">Publish Donation Batch</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.8rem">
        FoodCycle Operation Center &copy; 2026
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>