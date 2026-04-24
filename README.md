# [FoodCycle - Full-Stack Community Food Rescue Platform](https://foodcycle.wuaze.com/)

**Live Demo:** https://foodcycle.wuaze.com/

FoodCycle is a real-time platform designed to reduce urban food waste by connecting businesses with surplus food to local NGOs and recipients. Developed for the SY BTech Web Programming Lab (2025–26), it utilizes geospatial data and live synchronization to ensure efficient food rescue in Mumbai.

---

## Key Features

- Live Donation Feed: Real-time listing of food batches with automatic expiry countdowns.
- Interactive Nearby Feed: A Leaflet.js-powered map of Mumbai allowing users to find the closest food batches.
- Smart Navigation: One-click deep-linking to Google Maps for precise turn-by-turn navigation to pickup points.
- Geocoded Listing Search: Donors can search for addresses or manually pin their pickup location using an interactive map.
- Impact Analytics: Dynamic tracking of "Meals Rescued," "CO2 Reduced," and community participation metrics.
- Secure Portal: Role-based access control (RBAC) for Donors, NGOs, and Recipients with personalized impact scores.
- Live Notifications: Real-time alerts for claims and status updates.

---

## Technology Stack

This project follows a professional, high-performance vanilla stack to ensure maximum speed and offline-ready components:

- Frontend: HTML5, CSS3, JavaScript (ES6+).
- Backend: PHP 8.x (API-first architecture).
- Database: MySQL (Relational storage for users, listings, and claims).
- Mapping: Leaflet.js with OpenStreetMap (Nominatim) for geocoding.
- Branding: Custom SVG icon system (icons.js) and typography (Lora & Inter).

---

## Project Structure

```text
foodrescueplatform/
├── backend/                # Server-side Logic (PHP APIs)
│   ├── api_listings.php    # CRUD for food batches
│   ├── api_claim.php       # Transactional claim logic
│   ├── api_stats.php       # Environmental & user analytics
│   ├── api_notifications.php
│   ├── db.php              # PDO Connection
│   └── init.php            # Global session & security
├── frontend/               # User Interface
│   ├── index.php           # Landing Page
│   ├── feed.php            # Live Donation Grid
│   ├── nearby.php          # Interactive Map Feed
│   ├── impact.php          # Analytics Dashboard
│   ├── dashboard.php       # User Portal
│   ├── profile.php         # Account & Security
│   ├── new-listing.php     # Donor Submission Map
│   └── assets/             # Styles, custom icons, and JS
└── figma design/           # Original UI mockups
```

---

## Installation & Setup

### Prerequisites
- XAMPP (or any LAMP/WAMP stack with PHP 8.0+ and MySQL).
- Browser with Geolocation permissions enabled.

### Steps
1.  Clone the repository or move the foodrescueplatform folder to your htdocs directory.
2.  Start Apache and MySQL via the XAMPP Control Panel.
3.  Database Import:
    - Open phpMyAdmin (http://localhost/phpmyadmin).
    - Create a new database named foodcycle.
    - Import the provided backend/schema.sql or run the setup script.
4.  Access the Platform:
    - Navigate to http://localhost/foodrescueplatform/frontend/index.php.
    - Register as a Donor to list food or an NGO to claim it.

---

## Academic Context
Developed as a Mini Project Submission for the SY BTech Web Programming Lab. This project demonstrates the integration of relational databases, server-side scripting, and external GIS APIs into a unified social-impact application.

---

## License
Educational Lab Project - All rights reserved 2026.
