<?php 
/*
   Food Donation Catalogue
   Searchable and filterable grid of all active items.
*/
require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Donation Catalogue</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 40px">
                
                <!-- Filter Sidebar -->
                <aside>
                    <div class="card" style="position: sticky; top: 100px">
                        <h4 style="margin-bottom: 20px; border-bottom: 2px solid var(--primary-color); padding-bottom: 5px">Filter Items</h4>
                        
                        <!-- Search Box -->
                        <div class="form-group">
                            <label class="form-label" style="font-size: 0.8rem">Search Keywords</label>
                            <input type="text" id="search-input" class="form-control" placeholder="Search food...">
                        </div>

                        <!-- Category Filters -->
                        <div style="margin-top: 25px">
                            <label class="form-label" style="font-size: 0.8rem">Categories</label>
                            <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.9rem">
                                <label><input type="checkbox" class="filter-checkbox" value="Produce" checked> Fresh Produce</label>
                                <label><input type="checkbox" class="filter-checkbox" value="Baked Goods" checked> Bakery Items</label>
                                <label><input type="checkbox" class="filter-checkbox" value="Dairy" checked> Dairy Products</label>
                                <label><input type="checkbox" class="filter-checkbox" value="Meals" checked> Prepared Meals</label>
                                <label><input type="checkbox" class="filter-checkbox" value="Pantry" checked> Pantry Staples</label>
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div style="margin-top: 25px">
                            <label class="form-label" style="font-size: 0.8rem">Sort By</label>
                            <select id="sort-select" class="form-control" style="font-size: 0.8rem">
                                <option value="expiry_asc">Expiring Soonest</option>
                                <option value="qty_desc">Highest Quantity</option>
                                <option value="qty_asc">Lowest Quantity</option>
                            </select>
                        </div>

                        <button id="reset-filters" class="btn btn-outline" style="width: 100%; margin-top: 20px; font-size: 11px">Reset All Filters</button>
                    </div>
                </aside>

                <!-- Grid View -->
                <section>
                    <div class="flex justify-between items-center mb-6">
                        <h2 style="color: var(--primary-color)">Product Catalogue</h2>
                        <span id="catalogue-count" style="font-size: 0.8rem; font-weight: bold; color: #888">Updating...</span>
                    </div>

                    <div id="catalogue-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px">
                        <!-- JS populated -->
                        <div class="skeleton" style="height: 350px"></div>
                        <div class="skeleton" style="height: 350px"></div>
                        <div class="skeleton" style="height: 350px"></div>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.8rem">
        FoodCycle Academic Project &copy; 2026
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
    <script src="assets/catalogue.js"></script>
</body>
</html>