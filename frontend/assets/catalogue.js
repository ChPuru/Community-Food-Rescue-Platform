document.addEventListener('DOMContentLoaded', () => {
    const catalogueGrid = document.getElementById('catalogue-grid');
    const catalogueCount = document.getElementById('catalogue-count');
    const searchInput = document.getElementById('search-input');
    const sortSelect = document.getElementById('sort-select');
    const resetBtn = document.getElementById('reset-filters');
    
    let listings = [];
    
    // Attach event listeners for real-time intelligence
    searchInput.addEventListener('input', applyFiltersAndSort);
    sortSelect.addEventListener('change', applyFiltersAndSort);
    
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    checkboxes.forEach(cb => cb.addEventListener('change', applyFiltersAndSort));

    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        checkboxes.forEach(cb => cb.checked = true);
        sortSelect.value = 'expiry_asc';
        applyFiltersAndSort();
    });

    function fetchListings() {
        fetch('../backend/api_listings.php')
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    listings = data.data;
                    applyFiltersAndSort();
                }
            })
            .catch(err => console.error('Error fetching listings:', err));
    }

    function applyFiltersAndSort() {
        const searchTerm = searchInput.value.toLowerCase();
        
        // Build array of active category strings
        const activeCategories = Array.from(document.querySelectorAll('.filter-checkbox:checked')).map(cb => cb.value);

        // Filter Phase
        let filtered = listings.filter(item => {
            const matchesSearch = item.title.toLowerCase().includes(searchTerm) || item.description.toLowerCase().includes(searchTerm);
            
            // Note: DB uses "Dairy". HTML has "Dairy". 
            // In case of slight mismatches, we ensure string includes or exact matches.
            const matchesCategory = activeCategories.includes(item.category);
            
            return matchesSearch && matchesCategory;
        });

        // Sorting Phase
        const sortMode = sortSelect.value;
        filtered.sort((a, b) => {
            if (sortMode === 'expiry_asc') {
                return new Date(a.available_until).getTime() - new Date(b.available_until).getTime();
            } else if (sortMode === 'qty_desc') {
                return parseFloat(b.quantity) - parseFloat(a.quantity);
            } else if (sortMode === 'qty_asc') {
                return parseFloat(a.quantity) - parseFloat(b.quantity);
            }
            return 0;
        });

        renderListings(filtered);
    }

    function renderListings(dataToRender) {
        catalogueGrid.innerHTML = '';
        catalogueCount.textContent = `Showing ${dataToRender.length} active listings`;

        if(dataToRender.length === 0) {
            // Loading Skeletons
            for(let i=0; i<6; i++) {
                const skel = document.createElement('div');
                skel.className = 'skeleton';
                skel.style.height = '320px';
                catalogueGrid.appendChild(skel);
            }
            return;
        }

        dataToRender.forEach(item => {
            const card = document.createElement('div');
            card.className = 'card flex flex-col';
            
            const expiryTime = new Date(item.available_until).getTime();
            
            // Map category to real image
            let imgSource = 'assets/img/pantry.png';
            if (item.category === 'Produce') imgSource = 'assets/img/produce.png';
            else if (item.category === 'Baked Goods') imgSource = 'assets/img/bakery.png';
            else if (item.category === 'Meals') imgSource = 'assets/img/meals.png';
            else if (item.category === 'Dairy') imgSource = 'assets/img/dairy.png';

            card.innerHTML = `
                <div style="height: 180px; overflow: hidden; border-radius: 8px 8px 0 0;">
                    <img src="${item.image_path || imgSource}" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div style="padding: 20px; flex: 1; display: flex; flex-direction: column;">
                    <div class="flex justify-between items-center mb-2">
                        <span style="font-size: 10px; font-weight: bold; padding: 2px 8px; background: #e8f5e9; color: #2e7d32; border-radius: 4px;">${escapeHtml(item.category)}</span>
                        <span style="font-size: 10px; color: #888;">ID: #${String(item.id).padStart(4, '0')}</span>
                    </div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 10px; color: var(--primary-color)">${escapeHtml(item.title)}</h3>
                    <p style="font-size: 0.8rem; color: #666; margin-bottom: 15px; flex: 1;">${escapeHtml(item.description)}</p>
                    
                    <div style="background: #f8f9fa; padding: 10px; border-radius: 6px; font-size: 11px;">
                        <div class="flex justify-between mb-1">
                            <span>Quantity:</span>
                            <strong>~${escapeHtml(item.quantity)} lbs</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Expires:</span>
                            <strong class="countdown-timer" data-expiry="${expiryTime}">...</strong>
                        </div>
                    </div>
                </div>
            `;
            catalogueGrid.appendChild(card);
        });

        if(typeof lucide !== 'undefined') lucide.createIcons();
        updateTimers();
    }

    function updateTimers() {
        const now = new Date().getTime();
        const articles = catalogueGrid.querySelectorAll('article');

        articles.forEach(article => {
            const timerEl = article.querySelector('.countdown-timer');
            if(!timerEl) return;
            
            const expiryTime = parseInt(timerEl.getAttribute('data-expiry'), 10);
            const diff = expiryTime - now;
            const criticalBadge = article.querySelector('.critical-badge');

            if (diff <= 0) {
                timerEl.textContent = "EXPIRED";
                timerEl.style.color = "var(--arch-accent)";
                if(criticalBadge) criticalBadge.style.display = 'block';
            } else {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);
                
                timerEl.textContent = `${hours}h ${mins}m ${secs}s`;

                // If less than 2 hours (7200 seconds), show critical badge
                if (diff < 7200000) {
                    if(criticalBadge) criticalBadge.style.display = 'block';
                    timerEl.style.color = "var(--arch-accent)";
                } else {
                    if(criticalBadge) criticalBadge.style.display = 'none';
                    timerEl.style.color = "inherit";
                }
            }
        });
    }

    function escapeHtml(unsafe) {
        if(!unsafe) return '';
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    setInterval(updateTimers, 1000);
    setInterval(fetchListings, 30000); // Auto-refresh data and re-apply filters every 30s
    fetchListings();
});