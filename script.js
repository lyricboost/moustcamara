// Drawer functionality
class SongDrawer {
    constructor() {
        this.drawerOverlay = document.getElementById('drawerOverlay');
        this.songDrawer = document.getElementById('songDrawer');
        this.createSongBtn = document.getElementById('createSongBtn');
        this.closeDrawerBtn = document.getElementById('closeDrawerBtn');
        this.cancelBtn = document.getElementById('cancelBtn');
        
        this.init();
    }

    init() {
        // Add event listeners
        if (this.createSongBtn) {
            this.createSongBtn.addEventListener('click', () => this.openDrawer());
        }
        
        if (this.closeDrawerBtn) {
            this.closeDrawerBtn.addEventListener('click', () => this.closeDrawer());
        }
        
        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', () => this.closeDrawer());
        }

        // FIX: Add overlay click listener on all pages
        this.drawerOverlay.addEventListener('click', (e) => {
            if (e.target === this.drawerOverlay) {
                this.closeDrawer();
            }
        });

        // Handle form submission
        const form = document.querySelector('.song-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        // Handle escape key - now works on all pages
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isDrawerOpen()) {
                this.closeDrawer();
            }
        });
    }

    openDrawer() {
        console.log('Opening drawer');
        this.drawerOverlay.classList.add('open');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
        // Focus first input
        const firstInput = this.songDrawer.querySelector('input');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    }

    closeDrawer() {
        console.log('Closing drawer');
        this.drawerOverlay.classList.remove('open');
        document.body.style.overflow = ''; // Restore scrolling
        
        // Clear form
        const form = document.querySelector('.song-form');
        if (form) {
            form.reset();
        }
    }

    isDrawerOpen() {
        return this.drawerOverlay.classList.contains('open');
    }

    handleSubmit(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(e.target);
        const songData = {
            title: formData.get('songTitle'),
            artist: formData.get('artist'),
            album: formData.get('album'),
            genre: formData.get('genre'),
            description: formData.get('description')
        };

        console.log('Creating song:', songData);

        // Simulate API call
        this.showSuccessMessage('Song created successfully!');
        this.closeDrawer();
    }

    showSuccessMessage(message) {
        // Simple success notification
        const notification = document.createElement('div');
        notification.className = 'notification success';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: #10b981;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            z-index: 10000;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Swipe gesture handler for song cards
class SwipeHandler {
    constructor() {
        this.activeCard = null;
        this.startX = 0;
        this.startY = 0;
        this.currentX = 0;
        this.isDragging = false;
        this.threshold = 50; // Minimum swipe distance
        this.maxVerticalDrift = 100; // Maximum vertical movement allowed
        
        this.init();
    }

    init() {
        const songCards = document.querySelectorAll('.song-card');
        songCards.forEach(card => {
            this.addSwipeListeners(card);
        });

        // Close actions when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.song-card')) {
                this.closeAllActions();
            }
        });
    }

    addSwipeListeners(card) {
        const content = card.querySelector('.song-content');
        
        // Touch events for mobile
        card.addEventListener('touchstart', (e) => this.handleStart(e, card), { passive: false });
        card.addEventListener('touchmove', (e) => this.handleMove(e, card), { passive: false });
        card.addEventListener('touchend', (e) => this.handleEnd(e, card), { passive: false });
        
        // Mouse events for desktop testing
        card.addEventListener('mousedown', (e) => this.handleStart(e, card));
        card.addEventListener('mousemove', (e) => this.handleMove(e, card));
        card.addEventListener('mouseup', (e) => this.handleEnd(e, card));
        card.addEventListener('mouseleave', (e) => this.handleEnd(e, card));

        // Action button handlers
        const deleteBtn = card.querySelector('.delete-btn');
        const editBtn = card.querySelector('.edit-btn');
        const shareBtn = card.querySelector('.share-btn');

        if (deleteBtn) {
            deleteBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.handleDelete(card);
            });
        }

        if (editBtn) {
            editBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.handleEdit(card);
            });
        }

        if (shareBtn) {
            shareBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.handleShare(card);
            });
        }
    }

    getEventX(e) {
        return e.type.includes('touch') ? e.touches[0]?.clientX || e.changedTouches[0]?.clientX : e.clientX;
    }

    getEventY(e) {
        return e.type.includes('touch') ? e.touches[0]?.clientY || e.changedTouches[0]?.clientY : e.clientY;
    }

    handleStart(e, card) {
        // Don't interfere with button clicks
        if (e.target.closest('button')) return;
        
        this.activeCard = card;
        this.startX = this.getEventX(e);
        this.startY = this.getEventY(e);
        this.currentX = this.startX;
        this.isDragging = false;
        
        card.classList.add('swiping');
        
        // Prevent text selection on desktop
        if (e.type === 'mousedown') {
            e.preventDefault();
        }
    }

    handleMove(e, card) {
        if (!this.activeCard || this.activeCard !== card) return;

        this.currentX = this.getEventX(e);
        const currentY = this.getEventY(e);
        
        const deltaX = this.currentX - this.startX;
        const deltaY = Math.abs(currentY - this.startY);
        
        // Check if this is a horizontal swipe
        if (Math.abs(deltaX) > 10 && deltaY < this.maxVerticalDrift) {
            this.isDragging = true;
            e.preventDefault(); // Prevent scrolling
            
            // Only allow swiping left (negative deltaX reveals actions on right)
            const translateX = Math.min(0, deltaX);
            const content = card.querySelector('.song-content');
            content.style.transform = `translateX(${translateX}px)`;
            
            // Add visual feedback
            card.classList.add('has-actions');
        }
    }

    handleEnd(e, card) {
        if (!this.activeCard || this.activeCard !== card) return;

        const deltaX = this.currentX - this.startX;
        const content = card.querySelector('.song-content');
        
        card.classList.remove('swiping');
        
        if (this.isDragging && Math.abs(deltaX) > this.threshold) {
            if (deltaX < -this.threshold) {
                // Swiped left - show actions
                this.showActions(card);
            } else if (deltaX > this.threshold) {
                // Swiped right - hide actions
                this.hideActions(card);
            }
        } else {
            // Not enough swipe distance - return to original position
            this.hideActions(card);
        }

        this.activeCard = null;
        this.isDragging = false;
    }

    showActions(card) {
        const content = card.querySelector('.song-content');
        const actions = card.querySelector('.song-swipe-actions');
        const actionsWidth = actions.offsetWidth;
        
        content.style.transform = `translateX(-${actionsWidth}px)`;
        card.classList.add('has-actions');
        
        // Close other open cards
        document.querySelectorAll('.song-card').forEach(otherCard => {
            if (otherCard !== card) {
                this.hideActions(otherCard);
            }
        });
    }

    hideActions(card) {
        const content = card.querySelector('.song-content');
        
        content.style.transform = 'translateX(0)';
        card.classList.remove('has-actions');
    }

    closeAllActions() {
        document.querySelectorAll('.song-card').forEach(card => {
            this.hideActions(card);
        });
    }

    handleDelete(card) {
        const songTitle = card.querySelector('.song-title').textContent;
        
        if (confirm(`Are you sure you want to delete "${songTitle}"?`)) {
            card.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out';
            card.style.transform = 'translateX(-100%)';
            card.style.opacity = '0';
            
            setTimeout(() => {
                card.remove();
                this.showNotification(`"${songTitle}" has been deleted`, 'success');
            }, 300);
        } else {
            this.hideActions(card);
        }
    }

    handleEdit(card) {
        const songTitle = card.querySelector('.song-title').textContent;
        this.showNotification(`Edit functionality for "${songTitle}" would open here`, 'info');
        this.hideActions(card);
    }

    handleShare(card) {
        const songTitle = card.querySelector('.song-title').textContent;
        const artist = card.querySelector('.song-artist').textContent;
        
        if (navigator.share) {
            navigator.share({
                title: songTitle,
                text: `Check out "${songTitle}" by ${artist}`,
                url: window.location.href
            }).catch(err => console.log('Error sharing:', err));
        } else {
            // Fallback for browsers without native sharing
            const shareText = `Check out "${songTitle}" by ${artist}`;
            navigator.clipboard.writeText(shareText).then(() => {
                this.showNotification('Song info copied to clipboard!', 'success');
            }).catch(() => {
                this.showNotification('Share functionality not available', 'info');
            });
        }
        this.hideActions(card);
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        const colors = {
            success: '#10b981',
            info: '#3b82f6',
            error: '#ef4444'
        };
        
        notification.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: ${colors[type] || colors.info};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            z-index: 10000;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Remove after delay
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
}

// Songs page specific functionality
class SongsPage {
    constructor() {
        this.swipeHandler = new SwipeHandler();
        this.init();
    }

    init() {
        // Add interactive features to play buttons
        const playBtns = document.querySelectorAll('.play-btn');
        playBtns.forEach(playBtn => {
            playBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const songCard = playBtn.closest('.song-card');
                this.playSong(songCard);
            });
        });

        // Handle floating player interactions
        const floatingPlayer = document.querySelector('.floating-player');
        if (floatingPlayer) {
            floatingPlayer.addEventListener('click', (e) => {
                e.stopPropagation();
                console.log('Floating player clicked');
            });
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            const isSongsPage = window.location.pathname.includes('songs.html');
            if (isSongsPage && e.key === 'Escape') {
                this.swipeHandler.closeAllActions();
            }
        });
    }

    playSong(songCard) {
        const title = songCard.querySelector('.song-title').textContent;
        const artist = songCard.querySelector('.song-artist').textContent;
        
        console.log(`Playing: ${title} by ${artist}`);
        
        // Update floating player
        const nowPlaying = document.querySelector('.now-playing');
        if (nowPlaying) {
            nowPlaying.textContent = `Now Playing: ${title}`;
        }

        // Update play button to pause
        const playBtn = songCard.querySelector('.play-btn');
        if (playBtn) {
            playBtn.textContent = playBtn.textContent === '▶' ? '⏸' : '▶';
            
            // Reset all other play buttons
            document.querySelectorAll('.play-btn').forEach(btn => {
                if (btn !== playBtn) {
                    btn.textContent = '▶';
                }
            });
        }

        // Close any open action menus
        this.swipeHandler.closeAllActions();
    }
}

// Page-specific initialization
document.addEventListener('DOMContentLoaded', () => {
    // Initialize drawer on both pages
    const drawer = new SongDrawer();
    
    // Initialize songs page specific functionality
    if (window.location.pathname.includes('songs.html')) {
        const songsPage = new SongsPage();
    }
    
    console.log('Page initialized');
});