<?php 

require_once '../backend/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodCycle - Contact Us</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div id="header-placeholder"></div>

    <main class="content-area">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px">
                
                <!-- Contact Info Section -->
                <div>
                    <h1 style="color: var(--primary-color); margin-bottom: 20px">Contact the Team</h1>
                    <p style="margin-bottom: 30px; font-size: 1.125rem; color: #555">
                        Whether you're a potential donor or looking for community support, we're here to answer any project-related questions.
                    </p>
                    
                    <div class="card mb-4">
                        <h4 style="color: var(--secondary-color); margin-bottom: 10px">Location</h4>
                        <p style="font-size: 0.9rem">
                            Sandipani Hostel <br>
                            Room 204 <br>
                            Campus South
                        </p>
                    </div>

                    <div class="card" style="border-left: 5px solid var(--accent-color)">
                        <h4 style="color: var(--accent-color); margin-bottom: 10px">Quick Support</h4>
                        <p style="font-size: 0.85rem; color: #666">
                            For immediate assistance, please use the form on the right. 
                            Our team monitors submissions daily between 9 AM and 6 PM.
                        </p>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div class="card" style="padding: 40px">
                    <form action="contact.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="form-group">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nature of Inquiry</label>
                            <select name="subject" class="form-control">
                                <option>Technical Assistance</option>
                                <option>Partnership Inquiry</option>
                                <option>General Information</option>
                                <option>Bug Report</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Inquiry Message</label>
                            <textarea name="message" class="form-control" style="height: 150px; padding-top: 15px" placeholder="How can we help?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px">Send Inquiry Message</button>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <footer style="margin-top: 80px; text-align: center; padding: 40px; border-top: 1px solid #eee; color: #888">
        FoodCycle Development Team &copy; 2026 - Educational Submission
    </footer>

    <script src="assets/icons.js"></script>
    <script src="assets/header.js"></script>
</body>
</html>
