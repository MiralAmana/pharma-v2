// Ajout au panier sans recharger la page : le formulaire reste un vrai <form method="POST">
// (fonctionne sans JS), on intercepte juste sa soumission quand JS est disponible.
document.addEventListener('submit', async (event) => {
    const form = event.target.closest('form[data-cart-add]');
    if (! form) {
        return;
    }

    event.preventDefault();

    const button = form.querySelector('button[type="submit"]');
    button?.setAttribute('disabled', 'disabled');

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
            },
            body: new FormData(form),
        });

        const data = await response.json();

        document.querySelectorAll('[data-cart-count]').forEach((el) => {
            el.textContent = data.cartCount;
        });

        showToast(data.message, data.success ? 'success' : 'error');
    } catch (error) {
        // Le fetch a échoué (réseau coupé, etc.) : on retombe sur la soumission classique.
        form.submit();
    } finally {
        button?.removeAttribute('disabled');
    }
});

function showToast(message, type = 'success') {
    document.getElementById('app-toast')?.remove();

    const toast = document.createElement('div');
    toast.id = 'app-toast';
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed; top: 20px; left: 50%; z-index: 9999;
        transform: translateX(-50%) translateY(-16px);
        background: ${type === 'success' ? '#166534' : '#b91c1c'}; color: #fff;
        padding: 12px 24px; border-radius: 999px; font-weight: 700; font-size: 14px;
        opacity: 0; transition: opacity .25s ease, transform .25s ease;
        box-shadow: 0 10px 25px rgba(0,0,0,.15);
        font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    `;
    document.body.appendChild(toast);

    requestAnimationFrame(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
    });

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(-16px)';
        setTimeout(() => toast.remove(), 250);
    }, 2200);
}
