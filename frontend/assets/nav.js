document.addEventListener('DOMContentLoaded', () => {
    const nav = document.createElement('div');
    nav.innerHTML = `
        <div style="position: fixed; bottom: 20px; right: 20px; z-index: 99999; background: #000; border: 2px solid #16A34A; padding: 15px; font-family: system-ui, -apple-system, sans-serif; box-shadow: 4px 4px 0px #16A34A;">
            <h3 style="color: #16A34A; font-weight: 900; font-size: 12px; text-transform: uppercase; margin-top: 0; margin-bottom: 10px; letter-spacing: 0.1em;">Screens</h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="index.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">1. Landing</a>
                <a href="login.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">2. Login</a>
                <a href="impact.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">3. Impact</a>
                <a href="feed.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">4. Feed</a>
                <a href="nearby.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">5. Nearby</a>
                <a href="pickup.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">6. Pickup</a>
                ${window.USER_ROLE === 'donor' || window.USER_ROLE === 'guest' ? `<a href="new-listing.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">7. New Listing</a>` : ''}
                ${window.USER_ROLE === 'ngo' || window.USER_ROLE === 'guest' ? `<a href="catalogue.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">8. Catalogue</a>` : ''}
                <a href="feedback.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">9. Feedback</a>
                <a href="contact.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">10. Contact</a>
                <a href="profile.php" style="color: white; text-decoration: none; font-size: 11px; font-weight: bold; text-transform: uppercase;" onmouseover="this.style.color='#16A34A'" onmouseout="this.style.color='white'">11. Profile</a>
            </div>
        </div>
    `;
    document.body.appendChild(nav);
});

