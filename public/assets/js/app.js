/*!
 * cstees — frontend application script
 * Handles AJAX cart/wishlist, toast notifications, hero rotator,
 * product carousel arrows, mobile nav toggle, and small UX polish.
 *
 * Loaded from layouts/app.blade.php with `defer`.
 */
(function () {
    'use strict';

    /* --------------------------------------------------------------
     | Helpers
     |-------------------------------------------------------------*/

    const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

    function postForm(url, formData) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        }).then(async (res) => {
            const ct = res.headers.get('Content-Type') || '';
            const data = ct.includes('application/json') ? await res.json() : { ok: res.ok };
            return { ok: res.ok && data.ok !== false, data, status: res.status };
        });
    }

    /* --------------------------------------------------------------
     | Toast notifications
     |-------------------------------------------------------------*/

    function ensureToastContainer() {
        let el = document.getElementById('cs-toast-stack');
        if (el) return el;
        el = document.createElement('div');
        el.id = 'cs-toast-stack';
        Object.assign(el.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: 9999,
            display: 'flex',
            flexDirection: 'column',
            gap: '10px',
            maxWidth: '320px',
        });
        document.body.appendChild(el);
        return el;
    }

    function toast(message, type = 'success') {
        const stack = ensureToastContainer();
        const colors = {
            success: { bg: '#e6f4ea', border: '#34a853', icon: 'bi-check-circle-fill', color: '#157347' },
            error:   { bg: '#fde2e2', border: '#dc3545', icon: 'bi-exclamation-circle-fill', color: '#a02828' },
            info:    { bg: '#d9ebff', border: '#79afe3', icon: 'bi-info-circle-fill', color: '#16324a' },
        };
        const c = colors[type] || colors.info;

        const t = document.createElement('div');
        t.innerHTML = `<i class="bi ${c.icon}" style="margin-right:.5rem; color:${c.color};"></i><span>${message}</span>`;
        Object.assign(t.style, {
            background: c.bg,
            borderLeft: `4px solid ${c.border}`,
            color: c.color,
            padding: '12px 14px',
            borderRadius: '8px',
            boxShadow: '0 4px 16px rgba(22,50,74,.12)',
            fontSize: '14px',
            opacity: '0',
            transform: 'translateY(-6px)',
            transition: 'opacity .2s, transform .2s',
            display: 'flex',
            alignItems: 'center',
        });

        stack.appendChild(t);
        requestAnimationFrame(() => {
            t.style.opacity = '1';
            t.style.transform = 'translateY(0)';
        });

        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transform = 'translateY(-6px)';
            setTimeout(() => t.remove(), 250);
        }, 3500);
    }

    /* --------------------------------------------------------------
     | Header badge updaters
     |-------------------------------------------------------------*/

    function setHeaderBadge(selector, count) {
        const link = document.querySelector(selector);
        if (! link) return;
        let badge = link.querySelector('.action-badge');
        if (count > 0) {
            if (! badge) {
                badge = document.createElement('span');
                badge.className = 'action-badge';
                link.appendChild(badge);
            }
            badge.textContent = count;
        } else if (badge) {
            badge.remove();
        }
    }

    /* --------------------------------------------------------------
     | Add to cart (AJAX)
     |-------------------------------------------------------------*/

    document.addEventListener('submit', function (e) {
        const form = e.target.closest('form.js-add-to-cart');
        if (! form) return;

        e.preventDefault();
        const btn = form.querySelector('button[type=submit]');
        const original = btn ? btn.innerHTML : null;

        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        }

        postForm(form.action, new FormData(form))
            .then(({ ok, data }) => {
                if (ok) {
                    toast(data.message || 'Added to cart.', 'success');
                    if (typeof data.cart_count === 'number') {
                        setHeaderBadge('a.action-box[href*="cart"]', data.cart_count);
                    }
                } else {
                    toast(data.message || 'Could not add to cart.', 'error');
                }
            })
            .catch(() => toast('Network error. Please try again.', 'error'))
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = original;
                }
            });
    });

    /* --------------------------------------------------------------
     | Wishlist toggle (AJAX)
     |-------------------------------------------------------------*/

    document.addEventListener('click', function (e) {
        const link = e.target.closest('.js-wishlist');
        if (! link) return;

        e.preventDefault();

        const productId = link.dataset.productId;
        const url = link.dataset.url;
        if (! productId || ! url) return;

        const fd = new FormData();
        fd.append('product_id', productId);

        const icon = link.querySelector('i');

        postForm(url, fd)
            .then(({ ok, data, status }) => {
                if (status === 401 || status === 419) {
                    toast('Please log in to use the wishlist.', 'info');
                    setTimeout(() => window.location.href = '/login', 800);
                    return;
                }
                if (! ok) {
                    toast(data.message || 'Could not update wishlist.', 'error');
                    return;
                }
                if (data.action === 'added') {
                    link.classList.add('is-active');
                    if (icon) { icon.classList.remove('bi-heart'); icon.classList.add('bi-heart-fill'); }
                    toast('Added to wishlist.', 'success');
                } else {
                    link.classList.remove('is-active');
                    if (icon) { icon.classList.remove('bi-heart-fill'); icon.classList.add('bi-heart'); }
                    toast('Removed from wishlist.', 'info');
                }
                if (typeof data.count === 'number') {
                    setHeaderBadge('a.action-box[href*="wishlist"]', data.count);
                }
            })
            .catch(() => toast('Network error. Please try again.', 'error'));
    });

    /* --------------------------------------------------------------
     | Cart line update — fall back to standard form submit, but
     | refresh the cart count after a soft fetch first.
     |-------------------------------------------------------------*/

    document.addEventListener('submit', function (e) {
        const form = e.target.closest('form.js-cart-update');
        if (! form) return;
        // Allow native submit for now (full page refresh keeps subtotal accurate).
    });

    /* --------------------------------------------------------------
     | Hero rotator — auto-advance dots, no real slide images yet.
     | Placeholder until banner data drives multiple slides.
     |-------------------------------------------------------------*/

    (function heroRotator() {
        const root = document.querySelector('[data-hero-rotator]');
        if (! root) return;

        const slides = Array.from(root.querySelectorAll('[data-hero-slide]'));
        const dots = Array.from(root.querySelectorAll('[data-hero-dot]'));
        const prev = root.querySelector('[data-hero-prev]');
        const next = root.querySelector('[data-hero-next]');
        const current = root.querySelector('[data-hero-current]');
        const total = root.querySelector('[data-hero-total]');

        if (! slides.length) return;

        let active = slides.findIndex(slide => slide.classList.contains('hero-slide-active'));
        if (active < 0) active = 0;

        if (total) {
            total.textContent = String(slides.length).padStart(2, '0');
        }

        const setActive = (index) => {
            active = (index + slides.length) % slides.length;

            slides.forEach((slide, i) => {
                slide.classList.toggle('hero-slide-active', i === active);
            });

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === active);
                dot.setAttribute('aria-current', i === active ? 'true' : 'false');
            });

            if (current) {
                current.textContent = String(active + 1).padStart(2, '0');
            }
        };

        let timerId = null;

        const stop = () => {
            if (timerId) {
                clearInterval(timerId);
                timerId = null;
            }
        };

        const start = () => {
            if (slides.length < 2) return;
            stop();
            timerId = setInterval(() => setActive(active + 1), 5000);
        };

        prev?.addEventListener('click', () => {
            setActive(active - 1);
            start();
        });

        next?.addEventListener('click', () => {
            setActive(active + 1);
            start();
        });

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                setActive(i);
                start();
            });
        });

        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);
        root.addEventListener('focusin', stop);
        root.addEventListener('focusout', start);

        setActive(active);
        start();
    })();

    /* --------------------------------------------------------------
     | Product section arrows — horizontal scroll the product row
     |-------------------------------------------------------------*/

    document.querySelectorAll('.product-section').forEach(section => {
        const row = section.querySelector('.row');
        if (! row) return;
        const prev = section.querySelector('.section-arrow.soft, .section-arrow:nth-child(1)');
        const next = section.querySelector('.section-arrow:not(.soft), .section-arrow:nth-child(2)');
        const step = () => row.firstElementChild?.offsetWidth || 280;

        prev?.addEventListener('click', () => row.scrollBy({ left: -step(), behavior: 'smooth' }));
        next?.addEventListener('click', () => row.scrollBy({ left:  step(), behavior: 'smooth' }));
    });

    /* --------------------------------------------------------------
     | Auto-dismiss flash alerts after 6 seconds
     |-------------------------------------------------------------*/

    setTimeout(() => {
        document.querySelectorAll('.alert.alert-dismissible').forEach(alert => {
            try { bootstrap.Alert.getOrCreateInstance(alert).close(); } catch (_) {}
        });
    }, 6000);

    /* --------------------------------------------------------------
     | Mobile nav toggle (if added to header in future)
     |-------------------------------------------------------------*/

    document.querySelector('[data-toggle="mobile-nav"]')?.addEventListener('click', function () {
        document.querySelector('.nav-row')?.classList.toggle('open');
    });

    /* --------------------------------------------------------------
     | Header badge styling (injected once, since it's set dynamically)
     |-------------------------------------------------------------*/

    (function injectBadgeStyle() {
        if (document.getElementById('cs-action-badge-style')) return;
        const style = document.createElement('style');
        style.id = 'cs-action-badge-style';
        style.textContent = `
            .action-box { position: relative; }
            .action-badge {
                position: absolute;
                top: -4px;
                right: -4px;
                background: #d15378;
                color: #fff;
                font-size: 10px;
                font-weight: 600;
                line-height: 1;
                min-width: 16px;
                height: 16px;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0 4px;
                pointer-events: none;
            }
            .wishlist-btn.is-active i { color: #d15378; }
        `;
        document.head.appendChild(style);
    })();
})();
