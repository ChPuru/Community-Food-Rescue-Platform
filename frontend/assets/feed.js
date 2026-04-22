document.addEventListener('DOMContentLoaded', () => {
    const feedContainer = document.getElementById('feed-container');
    const updateStatus = document.getElementById('feed-update-status');
    let listings = [];
    
    function fetchListings() {
        updateStatus.textContent = 'Updating...';
        
        fetch('../backend/api_listings.php')
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    listings = data.data;
                    renderListings();
                    setTimeout(() => updateStatus.textContent = 'Live', 1000);
                }
            })
            .catch(err => {
                console.error('Error fetching listings:', err);
                updateStatus.textContent = 'Error';
            });
    }

    function renderListings() {
        feedContainer.innerHTML = '';

        if(listings.length === 0) {
            feedContainer.innerHTML = `
                <div class="text-center py-12">
                    <p class="font-bold uppercase text-gray-500">No active listings available.</p>
                </div>
            `;
            return;
        }

        listings.forEach(item => {
            const article = document.createElement('article');
            article.className = 'feed-item';
            
            const expiryTime = new Date(item.available_until).getTime();
            
            let icon = 'package';
            if (item.category === 'Produce') icon = 'carrot';
            else if (item.category === 'Baked Goods') icon = 'croissant';
            else if (item.category === 'Dairy') icon = 'box';

            article.innerHTML = `
                <div class="feed-item-expiry" data-expiry="${expiryTime}">...</div>
                <div class="flex gap-4">
                    <div class="brutal-border flex-shrink-0 flex items-center justify-center" style="width:4rem;height:4rem;background:var(--brand-100)">
                        <i data-icon="${icon}" class="icon icon-xl text-brand-900"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-display text-xl uppercase truncate" style="padding-right:6rem">${escapeHtml(item.title)}</h3>
                        <div class="text-sm font-bold text-gray-600 mb-2 flex items-center gap-2">
                            <i data-icon="map-pin" class="icon icon-sm"></i> ${escapeHtml(item.operator_name)} (${escapeHtml(item.pickup_location)})
                        </div>
                        <p class="text-sm font-medium mb-3 line-clamp-2">${escapeHtml(item.description)}</p>
                        <div class="feed-divider flex items-center justify-between">
                            <div class="flex gap-2">
                                <span class="badge-green">${escapeHtml(item.category)}</span>
                                <span class="badge-outline">~${escapeHtml(item.quantity)} lbs</span>
                            </div>
                            <button class="btn-black claim-btn" data-id="${item.id}">Claim</button>
                        </div>
                    </div>
                </div>
            `;
            feedContainer.appendChild(article);
        });

        if(typeof lucide !== 'undefined') lucide.createIcons();

        updateTimers();
    }

    function updateTimers() {
        const now = new Date().getTime();
        const articles = feedContainer.querySelectorAll('.feed-item');

        articles.forEach(article => {
            const timerEl = article.querySelector('.feed-item-expiry');
            if(!timerEl) return;

            const expiryTime = parseInt(timerEl.getAttribute('data-expiry'), 10);
            const diff = expiryTime - now;

            if (diff <= 0) {
                timerEl.textContent = "Expired";
                timerEl.style.background = "var(--red-500)";
                timerEl.style.color = "white";
            } else {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);
                
                timerEl.textContent = `Expires in ${hours}h ${mins}m ${secs}s`;
                
                if (diff < 3600000) {
                    timerEl.style.background = "#ffcccc";
                    timerEl.style.color = "#cc0000";
                } else {
                    timerEl.style.background = "var(--gray-900)";
                    timerEl.style.color = "#fff";
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

    feedContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('claim-btn')) {
            const listingId = e.target.getAttribute('data-id');
            claimListing(listingId, e.target);
        }
    });

    function claimListing(id, buttonEl) {
        buttonEl.disabled = true;
        buttonEl.textContent = 'Claiming...';
        
        fetch('../backend/api_claim.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ listing_id: id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                buttonEl.textContent = 'Claimed!';
                buttonEl.style.background = '#8bc34a';
                buttonEl.style.color = '#fff';
                buttonEl.style.boxShadow = 'none';
                setTimeout(fetchListings, 1500);
            } else {
                alert(data.message);
                buttonEl.disabled = false;
                buttonEl.textContent = 'Claim';
            }
        })
        .catch(err => {
            console.error('Claim error:', err);
            alert('Failed to process claim.');
            buttonEl.disabled = false;
            buttonEl.textContent = 'Claim';
        });
    }

    setInterval(updateTimers, 1000);
    setInterval(fetchListings, 30000);
    
    fetchListings();
});
