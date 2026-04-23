document.addEventListener('DOMContentLoaded', () => {
    const feedContainer = document.getElementById('feed-container');
    const updateStatus = document.getElementById('feed-update-status');
    let listings = [];
    let initialLoad = true;
    
    function fetchListings() {
        if (updateStatus) updateStatus.textContent = 'Updating...';
        
        fetch('../backend/api_listings.php')
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    listings = data.data;
                    initialLoad = false;
                    renderListings();
                    if (updateStatus) setTimeout(() => updateStatus.textContent = 'Live', 1000);
                }
            })
            .catch(err => {
                console.error('Error fetching listings:', err);
                if (updateStatus) updateStatus.textContent = 'Error';
                initialLoad = false;
                renderListings();
            });
    }

    function renderListings() {
        if (!feedContainer) return;
        feedContainer.innerHTML = '';

        if(listings.length === 0) {
            if (initialLoad) {
                for(let i=0; i<3; i++) {
                    const skel = document.createElement('div');
                    skel.className = 'skeleton mb-6';
                    skel.style.height = '180px';
                    feedContainer.appendChild(skel);
                }
            } else {
                feedContainer.innerHTML = `
                    <div class="card" style="text-align: center; padding: 60px 20px; border: 2px dashed #eee; background: #fafafa; grid-column: 1 / -1">
                        <i data-icon="cloud-off" style="width: 48px; height: 48px; color: #ccc; margin-bottom: 20px"></i>
                        <h3 style="color: #888">No active donations at the moment</h3>
                        <p style="color: #aaa; margin-top: 10px">Check back later or explore the interactive map for nearby centers.</p>
                        <a href="index.php" class="btn btn-outline" style="margin-top: 25px">Back to Home</a>
                    </div>
                `;
                if(typeof renderIcons === 'function') renderIcons();
            }
            return;
        }

        listings.forEach(item => {
            const card = document.createElement('div');
            card.className = 'card mb-6 feed-item';
            card.style.padding = '25px';
            
            const expiryTime = new Date(item.available_until).getTime();
            
            let imgSource = 'assets/img/pantry.png';
            if (item.category === 'Produce') imgSource = 'assets/img/produce.png';
            else if (item.category === 'Baked Goods') imgSource = 'assets/img/bakery.png';
            else if (item.category === 'Meals') imgSource = 'assets/img/meals.png';
            else if (item.category === 'Dairy') imgSource = 'assets/img/dairy.png';

            card.innerHTML = `
                <div class="flex gap-6" style="align-items: stretch">
                    <div style="width: 180px; height: 140px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 12px; overflow: hidden">
                        <img src="${item.image_path || imgSource}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h3 style="color: var(--primary-color); font-family: 'Lora', serif; font-size: 1.4rem; margin:0">${escapeHtml(item.title)}</h3>
                                <span style="font-size: 11px; font-weight: bold; padding: 4px 12px; background: #f0f0f0; border-radius: 50px; color: #666">${escapeHtml(item.category)}</span>
                            </div>
                            <p style="font-size: 0.95rem; color: #555; line-height: 1.6; margin-bottom: 15px">${escapeHtml(item.description)}</p>
                        </div>
                        
                        <div class="flex justify-between items-end">
                            <div class="flex flex-col gap-2">
                                <div style="font-size: 13px; font-weight: 600; color: #444; display: flex; align-items: center; gap: 6px">
                                    <i data-icon="map-pin" style="width:14px; height:14px; color: var(--secondary-color)"></i>
                                    ${escapeHtml(item.operator_name)}
                                </div>
                                <div class="feed-item-expiry" data-expiry="${expiryTime}" style="padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: bold; display: inline-block">...</div>
                            </div>
                            <button class="btn btn-primary claim-btn" data-id="${item.id}" style="padding: 12px 30px; font-weight: bold; font-size: 13px; border-radius: 8px">Claim Batch</button>
                        </div>
                    </div>
                </div>
            `;
            feedContainer.appendChild(card);
        });

        if(typeof renderIcons === 'function') renderIcons();
        updateTimers();
    }

    function updateTimers() {
        if (!feedContainer) return;
        const now = new Date().getTime();
        const articles = feedContainer.querySelectorAll('.feed-item');

        articles.forEach(article => {
            const timerEl = article.querySelector('.feed-item-expiry');
            if(!timerEl) return;

            const expiryTime = parseInt(timerEl.getAttribute('data-expiry'), 10);
            const diff = expiryTime - now;

            if (diff <= 0) {
                timerEl.textContent = "Expired";
                timerEl.style.background = "#ffebee";
                timerEl.style.color = "#c62828";
            } else {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);
                
                timerEl.textContent = `Expires in ${hours}h ${mins}m ${secs}s`;
                
                if (diff < 3600000) {
                    timerEl.style.background = "#fff3e0";
                    timerEl.style.color = "#ef6c00";
                } else {
                    timerEl.style.background = "#e3f2fd";
                    timerEl.style.color = "#1565c0";
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

    if (feedContainer) {
        feedContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('claim-btn')) {
                const listingId = e.target.getAttribute('data-id');
                claimListing(listingId, e.target);
            }
        });
    }

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
                buttonEl.style.background = '#2e7d32';
                buttonEl.style.color = '#fff';
                buttonEl.style.boxShadow = 'none';
                setTimeout(fetchListings, 1500);
            } else {
                window.showToast(data.message, 'error');
                buttonEl.disabled = false;
                buttonEl.textContent = 'Claim Batch';
            }
        })
        .catch(err => {
            console.error('Claim error:', err);
            window.showToast('Failed to process claim.', 'error');
            buttonEl.disabled = false;
            buttonEl.textContent = 'Claim Batch';
        });
    }

    setInterval(updateTimers, 1000);
    setInterval(fetchListings, 30000);
    
    fetchListings();
});