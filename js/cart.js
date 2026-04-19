/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Intercepts form submissions structurally to add items asynchronously using the fetch AJAX API seamlessly.
 */
document.addEventListener('DOMContentLoaded', () => {
    // AJAX Add to Cart
    // Intercepts structural submit events natively bypassing standard REST page refreshes securely
    document.querySelectorAll('form[action="cart/add.php"]').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = form.querySelector('button');
            const originalText = btn.innerText;
            btn.innerText = 'Adding...';
            btn.disabled = true;

            const formData = new FormData(form);

            try {
                const response = await fetch('cart/add.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    let badge = document.querySelector('.cart-badge');
                    if (!badge) {
                        badge = document.createElement('span');
                        badge.className = 'cart-badge';
                        document.querySelector('.cart-container').appendChild(badge);
                    }
                    badge.innerText = data.cart_count;

                    btn.innerText = 'Added!';
                    setTimeout(() => {
                        btn.innerText = originalText;
                        btn.disabled = false;
                    }, 1300);
                } else {
                    btn.innerText = 'Error';
                    setTimeout(() => {
                        btn.innerText = originalText;
                        btn.disabled = false;
                    }, 2000);
                }
            } catch (err) {
                console.error(err);
                btn.innerText = 'Failed';
                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                }, 2000);
            }
        });
    });
});
