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

// Songs page specific functionality
class SongsPage {
    constructor() {
        this.init();
    }

    init() {
        // Add some interactive features to songs
        const songCards = document.querySelectorAll('.song-card');
        songCards.forEach(card => {
            const playBtn = card.querySelector('.btn-icon');
            if (playBtn && playBtn.textContent === '▶') {
                playBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.playSong(card);
                });
            }
        });

        // Add problematic event listeners that might interfere with drawer
        const floatingPlayer = document.querySelector('.floating-player');
        if (floatingPlayer) {
            // This adds a high z-index element that captures clicks
            floatingPlayer.addEventListener('click', (e) => {
                e.stopPropagation();
                console.log('Floating player clicked');
            });
        }

        // Add more problematic event listeners on the songs page
        document.addEventListener('click', (e) => {
            // This might interfere with drawer closing
            const isSongsPage = window.location.pathname.includes('songs.html');
            if (isSongsPage) {
                console.log('Songs page click captured:', e.target);
                // Don't prevent default or stop propagation here - let it bubble
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
        const playBtn = songCard.querySelector('.btn-icon');
        if (playBtn) {
            playBtn.textContent = playBtn.textContent === '▶' ? '⏸' : '▶';
        }
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