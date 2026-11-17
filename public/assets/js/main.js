/**
 * Elite Homez — Bespoke Luxury Real Estate Platform
 * Modern Client-Side Controller
 * Standards: Modern Web Guidance (State-aware headers, Natural interactions, Accessible drawer)
 */

document.addEventListener('DOMContentLoaded', () => {
    // ============================================================
    // 1. STATE-AWARE STICKY HEADER (IntersectionObserver & Scroll Listener)
    // ============================================================
    const headerWrapper = document.getElementById('siteHeaderWrapper');
    if (headerWrapper) {
        const updateStickyState = () => {
            const isScrolled = window.scrollY > 30;
            headerWrapper.classList.toggle('is-stuck', isScrolled);
        };

        window.addEventListener('scroll', updateStickyState, { passive: true });
        updateStickyState();
    }

    // ============================================================
    // 2. LUXURY MOBILE NAVIGATION DRAWER
    // ============================================================
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const drawerOverlay = document.getElementById('mobileDrawerOverlay');
    const drawerCloseBtn = document.getElementById('drawerCloseBtn');

    function openMobileDrawer() {
        if (!mobileDrawer || !drawerOverlay) return;
        mobileDrawer.classList.add('active');
        drawerOverlay.classList.add('active');
        if (mobileMenuBtn) {
            mobileMenuBtn.setAttribute('aria-expanded', 'true');
        }
        document.body.style.overflow = 'hidden';
    }

    function closeMobileDrawer() {
        if (!mobileDrawer || !drawerOverlay) return;
        mobileDrawer.classList.remove('active');
        drawerOverlay.classList.remove('active');
        if (mobileMenuBtn) {
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
        }
        document.body.style.overflow = '';
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const isOpen = mobileDrawer.classList.contains('active');
            if (isOpen) {
                closeMobileDrawer();
            } else {
                openMobileDrawer();
            }
        });
    }

    if (drawerCloseBtn) drawerCloseBtn.addEventListener('click', closeMobileDrawer);
    if (drawerOverlay) drawerOverlay.addEventListener('click', closeMobileDrawer);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobileDrawer();
            closeLightbox();
        }
    });

    // ============================================================
    // 3. PROPERTY DETAIL GALLERY & LIGHTBOX
    // ============================================================
    const mainGalleryImg = document.querySelector('.gallery-main img');
    const thumbItems = document.querySelectorAll('.gallery-thumb-item');
    const fullscreenTrigger = document.querySelector('.gallery-view-fullscreen');
    const lightboxModal = document.querySelector('.lightbox-modal');
    const lightboxImg = document.querySelector('.lightbox-modal img');
    const lightboxClose = document.querySelector('.lightbox-close');

    if (thumbItems.length > 0 && mainGalleryImg) {
        thumbItems.forEach(thumb => {
            thumb.addEventListener('click', () => {
                const targetSrc = thumb.getAttribute('data-full');
                if (targetSrc) {
                    mainGalleryImg.src = targetSrc;
                    thumbItems.forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                    if (lightboxImg) lightboxImg.src = targetSrc;
                }
            });
        });
    }

    function openLightbox() {
        if (lightboxModal && mainGalleryImg && lightboxImg) {
            lightboxImg.src = mainGalleryImg.src;
            lightboxModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeLightbox() {
        if (lightboxModal) {
            lightboxModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    if (fullscreenTrigger) fullscreenTrigger.addEventListener('click', openLightbox);
    if (mainGalleryImg && mainGalleryImg.parentElement) {
        mainGalleryImg.parentElement.addEventListener('click', openLightbox);
    }
    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxModal) {
        lightboxModal.addEventListener('click', (e) => {
            if (e.target === lightboxModal) closeLightbox();
        });
    }

    // ============================================================
    // 4. AJAX LEAD FORM ENHANCEMENTS
    // ============================================================
    const enquiryForms = document.querySelectorAll('form[action*="/enquire"]');
    enquiryForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (!submitBtn) return;

            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting Confidential Inquiry...';

            if (!window.fetch) return;

            e.preventDefault();
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                let alertBox = form.querySelector('.form-alert');
                if (!alertBox) {
                    alertBox = document.createElement('div');
                    alertBox.className = 'form-alert alert';
                    form.prepend(alertBox);
                }

                if (data.success) {
                    alertBox.className = 'form-alert alert alert-success';
                    alertBox.textContent = data.message;
                    form.reset();
                } else {
                    alertBox.className = 'form-alert alert alert-error';
                    alertBox.textContent = data.message || 'An error occurred. Please telephone our advisory desk directly.';
                }
            } catch (err) {
                form.submit();
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            }
        });
    });
});
