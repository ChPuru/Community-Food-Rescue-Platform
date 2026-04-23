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
            // Skeletons while loading
            for(let i=0; i<3; i++) {
                const skel = document.createElement('div');
                skel.className = 'skeleton mb-4';
                skel.style.height = '180px';
                feedContainer.appendChild(skel);
            }
            return;
        }

        listings.forEach(item => {
            const card = document.createElement('div');
            card.className = 'card mb-4';
            
            const expiryTime = new Date(item.available_until).getTime();
            
            // Map category to real image
            let imgSource = 'assets/img/pantry.png';
            if (item.category === 'Produce') imgSource = 'assets/img/produce.png';
            else if (item.category === 'Baked Goods') imgSource = 'assets/img/bakery.png';
            else if (item.category === 'Meals') imgSource = 'assets/img/meals.png';
            else if (item.category === 'Dairy') imgSource = 'assets/img/dairy.png';

            card.innerHTML = `
                <div class="flex gap-4">
                    <div style="width: 150px; height: 120px; flex-shrink: 0;">
                        <img src="${item.image_path || imgSource}" style="width:100%; height:100%; object-fit:cover; border-radius: 8px;">
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 style="color: var(--primary-color)">${escapeHtml(item.title)}</h3>
                            <span style="font-size: 11px; font-weight: bold; padding: 2px 8px; background: #f0f0f0; border-radius: 4px;">${escapeHtml(item.category)}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: #555; margin: 8px 0">${escapeHtml(item.description)}</p>
                        <div class="flex justify-between items-center mt-2">
                            <div style="font-size: 12px; font-weight: 600">
                                📍 ${escapeHtml(item.operator_name)}
                            </div>
                            <button class="btn btn-primary claim-btn" data-id="${item.id}" style="padding: 5px 15px; font-size: 12px">Claim Batch</button>
                        </div>
                        <div class="feed-item-expiry" data-expiry="${expiryTime}" style="margin-top: 10px; font-size: 11px; font-weight: bold; color: var(--secondary-color)">...</div>
                    </div>
                </div>
            `;
            feedContainer.appendChild(card);
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
            body: JSON.stringify({ 
                listing_id: id,
                csrf_token: window.CSRF_TOKEN
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                window.showToast('Listing claimed successfully!');
                buttonEl.textContent = 'Claimed!';
                buttonEl.style.background = '#8bc34a';
                buttonEl.style.color = '#fff';
                buttonEl.style.boxShadow = 'none';
                setTimeout(fetchListings, 1500);
            } else {
                window.showToast(data.message, 'error');
                buttonEl.disabled = false;
                buttonEl.textContent = 'Claim';
            }
        })
        .catch(err => {
            console.error('Claim error:', err);
            window.showToast('Failed to process claim.', 'error');
            buttonEl.disabled = false;
            buttonEl.textContent = 'Claim';
        });
    }

    setInterval(updateTimers, 1000);
    setInterval(fetchListings, 30000);
    
    fetchListings();
});