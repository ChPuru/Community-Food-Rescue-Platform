<?php 
/*
   Platform Feedback Survey
   Community input to help improve the FoodCycle initiative.
   Part of the Web Programming Lab documentation.
*/
require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Project Feedback</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .survey-container {
            max-width: 650px;
            margin: 40px auto;
        }
    </style>
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div class="card survey-container">
                <div style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 30px">
                    <h2 style="color: var(--primary-color)">Community Feedback Survey</h2>
                    <p style="font-size: 0.9rem; color: #666">Your insights help us improve the platform for both donors and NGOs.</p>
                </div>

                <form action="feedback.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="form-group">
                        <label class="form-label">How would you rate your overall experience with FoodCycle?</label>
                        <div class="flex gap-4" style="margin-top: 10px">
                            <label><input type="radio" name="rating" value="5"> Excellent</label>
                            <label><input type="radio" name="rating" value="4"> Good</label>
                            <label><input type="radio" name="rating" value="3"> Satisfactory</label>
                            <label><input type="radio" name="rating" value="2"> Poor</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Which feature do you find most useful?</label>
                        <select name="main_feature" class="form-control">
                            <option value="map">Live Interactive Maps</option>
                            <option value="feed">Real-time Food Feed</option>
                            <option value="impact">Impact Analytics</option>
                            <option value="profile">Profile Management</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tell us more about your experience or suggestions:</label>
                        <textarea name="comment" class="form-control" style="height: 120px" placeholder="Your thoughts here..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">May we contact you for further research?</label>
                        <div class="flex gap-4">
                            <label><input type="radio" name="contact_ok" value="yes"> Yes, sure</label>
                            <label><input type="radio" name="contact_ok" value="no" checked> No, thank you</label>
                        </div>
                    </div>

                    <div style="margin-top: 30px">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px">Submit Feedback Response</button>
                    </div>
                </form>

                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <div style="margin-top: 25px; padding: 15px; background: #e8f5e9; color: #2e7d32; border-radius: 8px; font-weight: bold; text-align: center">
                        Thank you! Your feedback has been recorded for our project evaluation.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.8rem">
        FoodCycle Research & Development &copy; 2026
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>