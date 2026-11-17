/**
 * Elite Homez — Admin Control Panel JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Automatic Slug Generation
    const titleInput = document.querySelector('input[name="title"], input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');

    if (titleInput && slugInput && !slugInput.value) {
        titleInput.addEventListener('input', () => {
            const val = titleInput.value.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .trim()
                .replace(/[\s_-]+/g, '-');
            slugInput.value = val;
        });
    }

    // 2. Safe Delete Confirmation
    const deleteForms = document.querySelectorAll('form.delete-confirm-form, .btn-confirm-delete');
    deleteForms.forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to permanently delete this record? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // 3. Responsive Mobile Sidebar Toggle
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const backdrop = document.getElementById('sidebarBackdrop');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            if (backdrop) backdrop.classList.toggle('show');
        });
    }

    if (backdrop && sidebar) {
        backdrop.addEventListener('click', () => {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            if (backdrop) backdrop.classList.remove('show');
        }
    });
});
