/**
 * WordPress Block Editor Sidebar Resizer
 * Makes the right settings sidebar draggable/resizable in the block editor
 */

(function() {
  'use strict';

  const STORAGE_KEY = 'moust-editor-sidebar-width';

  // Inject resizer styles once
  const injectStyles = () => {
    if (document.getElementById('moust-editor-resizer-styles')) return;
    const style = document.createElement('style');
    style.id = 'moust-editor-resizer-styles';
    style.textContent = `
      .moust-editor-resizer {
        position: relative;
        width: 8px;
        height: 100%;
        cursor: ew-resize;
        flex-shrink: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
      }
      .moust-editor-resizer:hover {
        background-color: rgba(49, 61, 89, 0.08);
      }
      .moust-editor-resizer-line {
        width: 2px;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.1);
        transition: background-color 0.2s ease;
      }
      .moust-editor-resizer:hover .moust-editor-resizer-line,
      .moust-editor-resizer--active .moust-editor-resizer-line {
        background-color: #313d59;
      }
      .moust-editor-resizer--active {
        background-color: rgba(49, 61, 89, 0.12);
      }
      /* Ensure sidebar respects custom width */
      body.block-editor-page {
        --moust-sidebar-width: 280px;
      }
      body.block-editor-page .interface-interface-skeleton__sidebar {
        flex: 0 0 auto !important;
        width: var(--moust-sidebar-width) !important;
        min-width: var(--moust-sidebar-width) !important;
        max-width: var(--moust-sidebar-width) !important;
      }
      /* Force every nested wrapper WordPress pins at 280px to fill the sidebar */
      body.block-editor-page .interface-interface-skeleton__sidebar > div,
      body.block-editor-page .interface-interface-skeleton__sidebar .interface-complementary-area,
      body.block-editor-page .interface-interface-skeleton__sidebar .editor-sidebar,
      body.block-editor-page .interface-interface-skeleton__sidebar .components-panel {
        width: 100% !important;
        min-width: 0 !important;
        max-width: none !important;
      }
    `;
    document.head.appendChild(style);
  };

  const initResizer = () => {
    const sidebar = document.querySelector('.interface-interface-skeleton__sidebar');
    const content = document.querySelector('.interface-interface-skeleton__content');

    if (!sidebar || !content) {
      // Retry — the editor UI may not be mounted yet
      setTimeout(initResizer, 500);
      return;
    }

    if (document.querySelector('.moust-editor-resizer')) {
      return;
    }

    injectStyles();

    // Create resize handle
    const resizeHandle = document.createElement('div');
    resizeHandle.className = 'moust-editor-resizer';
    resizeHandle.innerHTML = '<div class="moust-editor-resizer-line"></div>';
    resizeHandle.title = 'Drag to resize sidebar';

    sidebar.parentNode.insertBefore(resizeHandle, sidebar);

    const applyWidth = (width) => {
      document.body.style.setProperty('--moust-sidebar-width', width + 'px');
    };

    // Restore saved width
    const savedWidth = parseInt(localStorage.getItem(STORAGE_KEY), 10);
    if (savedWidth) {
      applyWidth(savedWidth);
    }

    let isResizing = false;
    let startX = 0;
    let startWidth = 0;

    const startResize = (clientX, e) => {
      isResizing = true;
      startX = clientX;
      startWidth = parseInt(getComputedStyle(sidebar).width, 10);

      document.body.style.cursor = 'ew-resize';
      document.body.style.userSelect = 'none';
      resizeHandle.classList.add('moust-editor-resizer--active');

      if (e) e.preventDefault();
    };

    const doResize = (clientX) => {
      if (!isResizing) return;

      const diff = startX - clientX; // Sidebar is on the right
      const newWidth = startWidth + diff;

      const minWidth = 280;
      const maxWidth = 800;
      applyWidth(Math.max(minWidth, Math.min(maxWidth, newWidth)));
    };

    const stopResize = () => {
      if (!isResizing) return;

      isResizing = false;
      document.body.style.cursor = '';
      document.body.style.userSelect = '';
      resizeHandle.classList.remove('moust-editor-resizer--active');

      localStorage.setItem(STORAGE_KEY, parseInt(getComputedStyle(sidebar).width, 10));
    };

    // Mouse events
    resizeHandle.addEventListener('mousedown', (e) => startResize(e.clientX, e));
    document.addEventListener('mousemove', (e) => doResize(e.clientX));
    document.addEventListener('mouseup', stopResize);

    // Touch events
    resizeHandle.addEventListener('touchstart', (e) => startResize(e.touches[0].clientX, e));
    document.addEventListener('touchmove', (e) => {
      if (isResizing) doResize(e.touches[0].clientX);
    });
    document.addEventListener('touchend', stopResize);

    // Re-insert handle if the sidebar gets closed and reopened
    const observer = new MutationObserver(() => {
      const currentSidebar = document.querySelector('.interface-interface-skeleton__sidebar');
      if (currentSidebar && !document.querySelector('.moust-editor-resizer')) {
        setTimeout(initResizer, 100);
      }
    });
    observer.observe(document.body, { childList: true, subtree: true });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initResizer);
  } else {
    initResizer();
  }

  // Retry after full editor load
  setTimeout(initResizer, 1000);
})();
