class EditorToolbar {
    constructor() {
        this.editor = document.getElementById('editor');
        this.isFloatingMode = false;
        this.undoStack = [];
        this.redoStack = [];
        this.maxHistorySize = 50;
        this.lastCursorPosition = 0;
        this.isProcessingInput = false;
        
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

        // FIX: Enhanced editor change tracking with focus preservation
        this.editor.addEventListener('input', (e) => {
            if (this.isProcessingInput) return;
            
            this.isProcessingInput = true;
            this.lastCursorPosition = this.editor.selectionStart;
            this.debounceHistorySave();
            
            // Use requestAnimationFrame to ensure DOM has updated before restoring focus
            requestAnimationFrame(() => {
                this.isProcessingInput = false;
                this.preserveFocus();
            });
        });

        // FIX: Handle new line creation specifically
        this.editor.addEventListener('keydown', (e) => {
            // Store cursor position before any key action
            this.lastCursorPosition = this.editor.selectionStart;
            
            if (e.key === 'Enter') {
                // For Enter key, handle focus preservation specially
                this.handleNewLine(e);
            } else if (e.ctrlKey || e.metaKey) {
                // Handle keyboard shortcuts
                this.handleKeyboardShortcuts(e);
            }
        });

        // FIX: Prevent focus loss on external events
        this.editor.addEventListener('blur', (e) => {
            // Only allow blur if it's intentional (clicking outside, tab navigation, etc.)
            const relatedTarget = e.relatedTarget;
            if (!relatedTarget || !this.isEditorRelatedElement(relatedTarget)) {
                // Store the cursor position for potential restoration
                this.lastCursorPosition = this.editor.selectionStart;
            }
        });

        // FIX: Restore focus when needed
        document.addEventListener('click', (e) => {
            // If clicking on the editor area but not the textarea itself, refocus
            if (e.target.closest('.editor-container') && e.target !== this.editor) {
                e.preventDefault();
                this.restoreFocus();
            }
        });
    }

    // FIX: Handle new line creation with focus preservation
    handleNewLine(e) {
        const cursorPos = this.editor.selectionStart;
        const textBefore = this.editor.value.substring(0, cursorPos);
        const textAfter = this.editor.value.substring(cursorPos);
        
        // Allow the default Enter behavior
        // Then preserve focus and cursor position
        setTimeout(() => {
            this.preserveFocus();
            this.saveState();
        }, 0);
    }

    // FIX: Enhanced keyboard shortcut handling
    handleKeyboardShortcuts(e) {
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
                // Let default paste behavior work, then save state and preserve focus
                setTimeout(() => {
                    this.saveState();
                    this.preserveFocus();
                }, 10);
                break;
        }
    }

    // FIX: Check if element is related to editor (toolbar buttons, etc.)
    isEditorRelatedElement(element) {
        return element.closest('.toolbar-problematic') || 
               element.closest('.floating-toolbar') ||
               element.closest('.demo-toggle') ||
               element === this.editor;
    }

    // FIX: Preserve focus and cursor position
    preserveFocus() {
        if (document.activeElement !== this.editor) {
            this.editor.focus();
            this.editor.setSelectionRange(this.lastCursorPosition, this.lastCursorPosition);
        }
    }

    // FIX: Restore focus when lost unexpectedly
    restoreFocus() {
        this.editor.focus();
        this.editor.setSelectionRange(this.lastCursorPosition, this.lastCursorPosition);
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
            this.lastCursorPosition = start + text.length;
            
            this.saveState();
            this.preserveFocus();
            this.showFeedback('Paste');
        } catch (err) {
            // Fallback for browsers that don't support clipboard API
            this.editor.focus();
            document.execCommand('paste');
            setTimeout(() => {
                this.saveState();
                this.preserveFocus();
            }, 10);
            this.showFeedback('Paste');
        }
    }

    restoreState(state) {
        this.editor.value = state.content;
        this.editor.selectionStart = state.selectionStart;
        this.editor.selectionEnd = state.selectionEnd;
        this.lastCursorPosition = state.selectionStart;
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
                if (feedback.parentNode) {
                    document.body.removeChild(feedback);
                }
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
                // Restore focus after toolbar switch
                this.restoreFocus();
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
                // Restore focus after toolbar switch
                this.restoreFocus();
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
    editor.value = `Welcome to the Moust Camara Lyric Editor!

This editor has been fixed to prevent focus loss when creating new lines and typing.

Key fixes implemented:
✓ Focus preservation when pressing Enter and typing characters
✓ Cursor position tracking and restoration
✓ Prevention of unexpected focus loss
✓ Enhanced event handling for seamless typing experience

Try the following to test the fixes:
- Press Enter to create a new line, then immediately start typing
- The cursor should stay focused and not lose position
- Use Undo/Redo (Ctrl+Z/Ctrl+Y) while typing
- Click around the editor area
- Switch between toolbar modes

Previous issue: When creating a new line and typing one character, 
the input focus would get lost, interrupting the user's flow.

Fixed: The editor now maintains focus consistently, allowing for 
seamless, uninterrupted typing and editing experience.`;

    // Set initial cursor position
    editor.focus();
    editor.setSelectionRange(0, 0);
});