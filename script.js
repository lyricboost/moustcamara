class EditorToolbar {
    constructor() {
        this.editor = document.getElementById('editor');
        this.isFloatingMode = false;
        this.undoStack = [];
        this.redoStack = [];
        this.maxHistorySize = 50;
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupHistory();
        this.createToggleButton();
        
        // Save initial state
        this.saveState();
    }

    setupEventListeners() {
        // Original toolbar buttons
        document.getElementById('undo-btn').addEventListener('click', () => this.undo());
        document.getElementById('redo-btn').addEventListener('click', () => this.redo());
        document.getElementById('paste-btn').addEventListener('click', () => this.paste());

        // Floating toolbar buttons
        document.getElementById('floating-undo').addEventListener('click', () => this.undo());
        document.getElementById('floating-redo').addEventListener('click', () => this.redo());
        document.getElementById('floating-paste').addEventListener('click', () => this.paste());

        // Editor change tracking
        this.editor.addEventListener('input', () => {
            this.debounceHistorySave();
        });

        // Keyboard shortcuts
        this.editor.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'z':
                        if (e.shiftKey) {
                            e.preventDefault();
                            this.redo();
                        } else {
                            e.preventDefault();
                            this.undo();
                        }
                        break;
                    case 'y':
                        e.preventDefault();
                        this.redo();
                        break;
                    case 'v':
                        // Let default paste behavior work, then save state
                        setTimeout(() => this.saveState(), 10);
                        break;
                }
            }
        });
    }

    setupHistory() {
        this.historyTimeout = null;
    }

    debounceHistorySave() {
        clearTimeout(this.historyTimeout);
        this.historyTimeout = setTimeout(() => {
            this.saveState();
        }, 500);
    }

    saveState() {
        const currentState = {
            content: this.editor.value,
            selectionStart: this.editor.selectionStart,
            selectionEnd: this.editor.selectionEnd
        };

        // Don't save if content hasn't changed
        const lastState = this.undoStack[this.undoStack.length - 1];
        if (lastState && lastState.content === currentState.content) {
            return;
        }

        this.undoStack.push(currentState);
        
        // Limit history size
        if (this.undoStack.length > this.maxHistorySize) {
            this.undoStack.shift();
        }
        
        // Clear redo stack when new state is saved
        this.redoStack = [];
        
        this.updateButtonStates();
    }

    undo() {
        if (this.undoStack.length <= 1) return;

        const currentState = this.undoStack.pop();
        this.redoStack.push(currentState);

        const previousState = this.undoStack[this.undoStack.length - 1];
        this.restoreState(previousState);
        this.updateButtonStates();
        
        this.showFeedback('Undo');
    }

    redo() {
        if (this.redoStack.length === 0) return;

        const nextState = this.redoStack.pop();
        this.undoStack.push(nextState);
        
        this.restoreState(nextState);
        this.updateButtonStates();
        
        this.showFeedback('Redo');
    }

    async paste() {
        try {
            const text = await navigator.clipboard.readText();
            const start = this.editor.selectionStart;
            const end = this.editor.selectionEnd;
            const currentValue = this.editor.value;
            
            this.editor.value = currentValue.substring(0, start) + text + currentValue.substring(end);
            this.editor.selectionStart = this.editor.selectionEnd = start + text.length;
            
            this.saveState();
            this.showFeedback('Paste');
        } catch (err) {
            // Fallback for browsers that don't support clipboard API
            this.editor.focus();
            document.execCommand('paste');
            setTimeout(() => this.saveState(), 10);
            this.showFeedback('Paste');
        }
    }

    restoreState(state) {
        this.editor.value = state.content;
        this.editor.selectionStart = state.selectionStart;
        this.editor.selectionEnd = state.selectionEnd;
        this.editor.focus();
    }

    updateButtonStates() {
        const canUndo = this.undoStack.length > 1;
        const canRedo = this.redoStack.length > 0;

        // Update original toolbar
        const undoBtn = document.getElementById('undo-btn');
        const redoBtn = document.getElementById('redo-btn');
        
        undoBtn.disabled = !canUndo;
        redoBtn.disabled = !canRedo;
        
        undoBtn.style.opacity = canUndo ? '1' : '0.5';
        redoBtn.style.opacity = canRedo ? '1' : '0.5';

        // Update floating toolbar
        const floatingUndo = document.getElementById('floating-undo');
        const floatingRedo = document.getElementById('floating-redo');
        
        floatingUndo.disabled = !canUndo;
        floatingRedo.disabled = !canRedo;
        
        floatingUndo.style.opacity = canUndo ? '1' : '0.5';
        floatingRedo.style.opacity = canRedo ? '1' : '0.5';
    }

    showFeedback(action) {
        // Create temporary feedback element
        const feedback = document.createElement('div');
        feedback.textContent = action;
        feedback.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            z-index: 2000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        `;
        
        document.body.appendChild(feedback);
        
        // Animate in
        requestAnimationFrame(() => {
            feedback.style.opacity = '1';
        });
        
        // Remove after delay
        setTimeout(() => {
            feedback.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(feedback);
            }, 200);
        }, 1000);
    }

    createToggleButton() {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'demo-toggle';
        toggleBtn.textContent = 'Switch to Floating Toolbar';
        toggleBtn.addEventListener('click', () => this.toggleToolbarMode());
        document.body.appendChild(toggleBtn);
    }

    toggleToolbarMode() {
        const problematicToolbar = document.querySelector('.toolbar-problematic');
        const floatingToolbar = document.getElementById('floating-toolbar');
        const toggleBtn = document.querySelector('.demo-toggle');

        if (!this.isFloatingMode) {
            // Switch to floating mode
            problematicToolbar.classList.add('fade-out');
            
            setTimeout(() => {
                problematicToolbar.style.display = 'none';
                floatingToolbar.style.display = 'flex';
                floatingToolbar.classList.add('fade-in');
                toggleBtn.textContent = 'Switch to Original Toolbar';
                this.isFloatingMode = true;
            }, 300);
            
        } else {
            // Switch back to original mode
            floatingToolbar.classList.remove('fade-in');
            floatingToolbar.classList.add('fade-out');
            
            setTimeout(() => {
                floatingToolbar.style.display = 'none';
                problematicToolbar.style.display = 'flex';
                problematicToolbar.classList.remove('fade-out');
                problematicToolbar.classList.add('fade-in');
                toggleBtn.textContent = 'Switch to Floating Toolbar';
                this.isFloatingMode = false;
            }, 300);
        }
    }
}

// Initialize the editor when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new EditorToolbar();
});

// Add some sample content to demonstrate the editor
document.addEventListener('DOMContentLoaded', () => {
    const editor = document.getElementById('editor');
    editor.value = `Welcome to the Moust Camara Editor!

This demo shows the difference between:

1. BEFORE: A traditional toolbar that takes up significant vertical space
   - Large horizontal bar at the top
   - Takes up ~80px of valuable screen real estate
   - Not optimized for mobile viewing
   - Reduces available space for content

2. AFTER: A floating utility toolbar in the bottom right
   - Compact circular buttons
   - Positioned above the footer
   - Mobile-optimized sizing
   - More screen space for content
   - Always accessible but unobtrusive

Try the following:
- Type some text and use Undo/Redo (Ctrl+Z/Ctrl+Y)
- Use the Paste button
- Click "Switch to Floating Toolbar" to see the improved UX
- Resize your browser to see mobile responsiveness

The floating toolbar provides better UX by:
✓ Maximizing content area
✓ Staying accessible while editing
✓ Working well on mobile devices
✓ Positioning above the fixed footer
✓ Providing visual feedback for actions`;
});