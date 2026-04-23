/* 
   Global Navigation Header Implementation
   Dynamic session handling and vanilla icon rendering
*/

document.addEventListener('DOMContentLoaded', () => {
    // Target the specific placeholder or the top of the body
    const placeholder = document.getElementById('header-placeholder');
    const isDonor = window.USER_ROLE === 'donor';
    
    const headerHtml = `
    <nav class="main-nav">
        <div class="container flex justify-between items-center">
            <a href="index.php" class="logo">
                <i data-icon="recycle" class="icon" style="width:26px;height:26px"></i>
                FoodCycle
            </a>
            
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="feed.php">Donations</a></li>
                <li><a href="nearby.php">Nearby Feed</a></li>
                <li><a href="impact.php">Our Impact</a></li>
                ${isDonor ? '<li><a href="new-listing.php" style="color:var(--primary-color); font-weight:bold">Donate Now</a></li>' : ''}
            </ul>

            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div style="position:relative; cursor:pointer" id="bell-container">
                    <i data-icon="bell" class="icon" style="width:22px;height:22px"></i>
                    <span id="nav-notify-count" style="position:absolute; top:-4px; right:-4px; background:var(--primary-color); color:white; font-size:9px; border-radius:50%; width:15px; height:15px; display:none; align-items:center; justify-content:center">0</span>
                    
                    <div id="nav-notify-dropdown" style="display:none; position:absolute; top:40px; right:0; width:280px; background:white; border:1px solid rgba(0,0,0,0.1); box-shadow:var(--shadow-hover); border-radius:var(--radius); z-index:2000; padding:15px">
                        <p style="font-family:'Lora',serif; font-size:14px; font-weight:bold; border-bottom:1.5px solid #f5f5f5; padding-bottom:8px; margin-bottom:10px">Alerts & Updates</p>
                        <div id="notify-items-list" style="max-height:250px; overflow-y:auto"></div>
                    </div>
                </div>

                <!-- Identity Control -->
                ${window.USER_ID ? `
                    <a href="dashboard.php" class="btn btn-primary" style="padding: 10px 20px">Portal</a>
                    <a href="profile.php" title="Profile Settings">
                        <div style="width:38px; height:38px; background:var(--primary-color); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Lora',serif; font-weight:bold; font-size:14px; border:2px solid white; box-shadow:0 0 0 1px var(--primary-color)">
                            ${window.USER_NAME ? window.USER_NAME.substring(0,1).toUpperCase() : 'U'}
                        </div>
                    </a>
                ` : `
                    <a href="login.php" class="btn btn-outline" style="padding: 8px 20px">Login</a>
                `}
            </div>
        </div>
    </nav>
    <div id="toast-container"></div>
    `;

    if (placeholder) {
        placeholder.innerHTML = headerHtml;
    } else {
        document.body.insertAdjacentHTML('afterbegin', headerHtml);
    }

    // Initialize custom vanilla icons
    if (typeof renderIcons === 'function') {
        renderIcons();
    }

    // Notification Logic
    const bell = document.getElementById('bell-container');
    const dropdown = document.getElementById('nav-notify-dropdown');
    
    if(bell) {
        bell.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            fetchNotifications();
        });
    }

    document.addEventListener('click', () => {
        if(dropdown) dropdown.style.display = 'none';
    });

    // Global Toast Function
    window.showToast = (msg, type='success') => {
        const container = document.getElementById('toast-container');
        if(!container) return;
        
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.style.backgroundColor = type === 'success' ? '#2e7d32' : '#c62828';
        toast.textContent = msg;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    };

    async function fetchNotifications() {
        if(!window.USER_ID) return;
        try {
            const r = await fetch('../backend/api_notifications.php');
            const d = await r.json();
            const list = document.getElementById('notify-items-list');
            const count = document.getElementById('nav-notify-count');
            
            if(d.status === 'success' && d.data) {
                if(d.data.length > 0) {
                    count.style.display = 'flex';
                    count.textContent = d.data.length;
                    list.innerHTML = d.data.map(n => `
                        <div style="padding:10px; border-bottom:1px solid #f5f5f5; font-size:12px; color:#444">
                            <strong>${n.subject}</strong><br>
                            <span style="color:#888; font-size:10px">${new Date(n.sent_at).toLocaleDateString()}</span>
                        </div>
                    `).join('');
                } else {
                    list.innerHTML = '<p style="text-align:center; padding:15px; color:#888; font-size:12px">No notifications</p>';
                }
            }
        } catch(e) {}
    }

    if(window.USER_ID) fetchNotifications();
});