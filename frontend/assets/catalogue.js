document.addEventListener('DOMContentLoaded', () => {
    const catalogueGrid = document.getElementById('catalogue-grid');
    const catalogueCount = document.getElementById('catalogue-count');
    let listings = [];
    
    function fetchListings() {
        fetch('../backend/api_listings.php')
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    listings = data.data;
                    renderListings();
                }
            })
            .catch(err => console.error('Error fetching listings:', err));
    }

    function renderListings() {
        catalogueGrid.innerHTML = '';
        catalogueCount.textContent = `Showing ${listings.length} active listings`;

        listings.forEach(item => {
            const article = document.createElement('article');
            article.className = 'card-hover flex flex-col relative';
            
            const expiryTime = new Date(item.available_until).getTime();
            
            let icon = 'package';
            if (item.category === 'Produce') icon = 'carrot';
            else if (item.category === 'Baked Goods') icon = 'croissant';

            const paddedId = String(item.id).padStart(4, '0');

            article.innerHTML = `
                <div class="critical-badge" style="display: none;">Critical</div>
                <div class="catalogue-img img-placeholder" style="background:var(--arch-light)">
                    <i data-icon="${icon}" class="icon icon-2xl" style="opacity:0.3"></i>
                    <div class="img-id">ID: BATCH-${paddedId}</div>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-xl uppercase leading-tight mb-2">${escapeHtml(item.title)}</h3>
                    <p class="font-mono text-xs mb-4" style="color:var(--arch-gray)">${escapeHtml(item.operator_name)} &bull; ${escapeHtml(item.pickup_location)}</p>
                    <div class="grid grid-cols-2 gap-2 mb-6 font-mono uppercase" style="font-size:0.625rem">
                        <div class="arch-border p-2" style="background:var(--arch-light)">
                            <span class="block mb-1" style="color:var(--arch-gray)">Quantity</span>
                            <span class="font-bold text-sm">~${escapeHtml(item.quantity)} lbs</span>
                        </div>
                        <div class="arch-border p-2" style="background:var(--arch-light)">
                            <span class="block mb-1" style="color:var(--arch-gray)">Expires In</span>
                            <span class="font-bold text-sm countdown-timer" data-expiry="${expiryTime}">...</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-auto pt-4" style="border-top:2px solid rgba(10,10,10,0.1)">
                        <div class="flex gap-1">
                            <span class="badge-black">${escapeHtml(item.category)}</span>
                        </div>
                        <button style="width:2.5rem;height:2.5rem;background:var(--arch-black);color:var(--arch-white);display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:background 0.2s" onmouseover="this.style.background='var(--arch-accent)'" onmouseout="this.style.background='var(--arch-black)'">
                            <i data-icon="arrow-right" class="icon icon-md"></i>
                        </button>
                    </div>
                </div>
            `;
            catalogueGrid.appendChild(article);
        });

        // Initialize icons for the newly injected HTML
        if(typeof lucide !== 'undefined') lucide.createIcons();

        updateTimers();
    }

    function updateTimers() {
        const now = new Date().getTime();
        const articles = catalogueGrid.querySelectorAll('article');

        articles.forEach(article => {
            const timerEl = article.querySelector('.countdown-timer');
            const expiryTime = parseInt(timerEl.getAttribute('data-expiry'), 10);
            const diff = expiryTime - now;
            const criticalBadge = article.querySelector('.critical-badge');

            if (diff <= 0) {
                timerEl.textContent = "EXPIRED";
                timerEl.style.color = "var(--arch-accent)";
                criticalBadge.style.display = 'block';
            } else {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);
                
                timerEl.textContent = `${hours}h ${mins}m ${secs}s`;

                // If less than 2 hours (7200 seconds), show critical badge
                if (diff < 7200000) {
                    criticalBadge.style.display = 'block';
                    timerEl.style.color = "var(--arch-accent)";
                } else {
                    criticalBadge.style.display = 'none';
                    timerEl.style.color = "inherit";
                }
            }
        });
    }

    function escapeHtml(unsafe) {
        if(!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    setInterval(updateTimers, 1000);
    fetchListings();
});
