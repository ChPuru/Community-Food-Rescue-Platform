document.addEventListener('DOMContentLoaded', () => {
    const nav = document.createElement('div');
    nav.innerHTML = `
        <div style="position: fixed; bottom: 20px; right: 20px; z-index: 99999; background: #000; border: 2px solid #16A34A; padding: 15px; font-family: system-ui, -apple-system, sans-serif; box-shadow: 4px 4px 0px #16A34A;">
            <h3 style="color: #16A34A; font-weight: 900; font-size: 12px; text-transform: uppercase; margin-top: 0; margin-bottom: 10px; letter-spacing: 0.1em;">Screens</h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="index.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">1. Landing</a>
                <a href="login.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">2. Login</a>
                <a href="impact.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">3. Impact</a>
                <a href="feed.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">4. Feed</a>
                <a href="nearby.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">5. Nearby</a>
                <a href="pickup.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">6. Pickup</a>
                <a href="new-listing.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">7. New Listing</a>
                <a href="catalogue.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">8. Catalogue</a>
                <a href="feedback.html" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">9. Feedback</a>
            </div>
        </div>
    `;
    document.body.appendChild(nav);
});