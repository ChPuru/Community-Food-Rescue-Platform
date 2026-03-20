# FoodCycle - Community Food Rescue Platform

A web-based platform that connects local businesses with surplus food to community members, shelters, and volunteers who can pick it up before it goes to waste. Instead of throwing away perfectly good food, list it here and let someone nearby come grab it.

## What this project is

FoodCycle is a frontend prototype for a community food rescue coordination system. It's built as a set of static HTML pages that demonstrate the full user flow — from landing on the site, to browsing available food, to claiming a batch for pickup.

This is currently frontend only. There's no backend or database hooked up yet. The pages use hardcoded sample data to show what the experience would look like.

## Tech stack

This project is intentionally built with zero external dependencies. Everything works offline, no internet required.

- HTML
- CSS (vanilla, one shared `styles.css`)
- JavaScript (vanilla)
- `icons.js` — a small inline SVG icon system, no CDN needed
- System fonts only (no Google Fonts)

No Tailwind, no npm, no build step, no bundler, no framework, no CDN. Just open the HTML files in a browser and they work.

## Pages

Here's what's in the project:

- **index.html** — Landing page. Explains what the platform does, shows some quick stats, and highlights urgent rescue batches nearby.
- **login.html** — Login/registration page. Supports email login with placeholders for GitHub and Google auth.
- **catalogue.html** — Main food catalogue. A filterable, searchable grid of all available food listings. Filter by category, urgency, and distance.
- **feed.html** — Live dashboard view. Shows a scrollable feed of available food with a sidebar for filters and a map panel.
- **nearby.html** — Mobile-first view. Designed for phones, shows nearby food as a card list with a bottom navigation bar.
- **new-listing.html** — Form for donors to post surplus food. Covers title, category, quantity, description, allergens, expiry, and pickup location.
- **pickup.html** — Pickup detail page for a specific batch. Shows what's included, instructions, allergen info, a map placeholder, and the claim button.
- **impact.html** — Impact dashboard. Tracks food rescued, meals provided, CO2 prevented, top rescuers leaderboard, and category breakdown.
- **feedback.html** — Feedback form. Report bugs, suggest ideas, send praise. Supports file attachments.

## Design

The design uses a brutalist / editorial aesthetic. Bold typography, thick black borders, hard box shadows, and high contrast. The project has two visual themes:

1. **FoodCycle theme** (index, feed, nearby, new-listing, pickup, impact) — System sans-serif + Impact display font, green brand colors, thick 3px borders, offset box shadows.
2. **Rescue_Arch theme** (login, catalogue, feedback) — System monospace + sans-serif, orange accent (#FF3B00), technical/systems UI feel.

Both share the same brutalist DNA but have slightly different personalities.

## Running locally

Just open any of the HTML files directly in your browser. Double-click the file or drag it into a browser window. That's it.

Since there are zero external dependencies, the pages work completely offline — no internet connection needed.

If you want to run a local server (for cleaner URL paths), you can do:

```
python -m http.server 8000
```

Then go to `http://localhost:8000`.

## Project structure

```
foodrescueplatform/
    index.html          - Landing page
    login.html          - Authentication
    catalogue.html      - Food listing catalogue
    feed.html           - Live feed dashboard
    nearby.html         - Mobile nearby view
    new-listing.html    - Create new food listing
    pickup.html         - Pickup details
    impact.html         - Impact metrics dashboard
    feedback.html       - User feedback form
    styles.css          - Shared stylesheet (all CSS lives here)
    icons.js            - Inline SVG icon system
    nav.js              - Dev navigation overlay
    figma design/       - Original design mockups
    .gitignore
    README.md
```

## How the icons work

Instead of loading icons from a CDN, the project includes `icons.js` which contains SVG path data for about 40 icons. In the HTML, icons are written as:

```html
<i data-icon="recycle" class="icon icon-lg"></i>
```

When the page loads, `icons.js` replaces each `<i>` tag with the actual `<svg>`. You can add new icons by adding entries to the `ICONS` object in that file.

## What's next

This is a frontend prototype. To make it actually functional, it would need:

- A backend with a database
- User authentication
- Real-time feed updates
- Map integration (Mapbox, Leaflet, etc.)
- Image uploads for food listings
- Push notifications for urgent rescues
- API for claims, listings, and user management

## License

Not specified yet. Reach out if you want to use or build on this.
