let cart = [];
let cartTotal = 0;

function addToCart(productName, price, quantity = 1) {
    cart.push({ name: productName, price: price, quantity: quantity });
    updateCartCount();
}

function updateCartCount() {
    const cartCountElement = document.getElementById('cart-count');
    const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
    cartCountElement.textContent = totalQuantity;
}

function showCart() {
    const cartModal = document.getElementById('cart-modal');
    cartModal.style.display = 'block';
    displayCartItems();
}

function closeCartModal() {
    const cartModal = document.getElementById('cart-modal');
    cartModal.style.display = 'none';
}

function displayCartItems() {
    const cartItemsList = document.getElementById('cart-items-list');
    const cartTotalElement = document.getElementById('cart-total');

    cartItemsList.innerHTML = '';
    cartTotal = 0;

    cart.forEach(item => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.name} - $${item.price}`;
        cartItemsList.appendChild(listItem);
        cartTotal += item.price;
    });

    cartTotalElement.textContent = cartTotal;
}

// Cierra el modal si se hace clic fuera de él
window.onclick = function(event) {
    const cartModal = document.getElementById('cart-modal');
    if (event.target == cartModal) {
        cartModal.style.display = 'none';
    }
}

function continueToPayment() {
    // Puedes redirigir a la página de selección de método de pago
    window.location.href = 'seleccionar_metodo_pago.php';
}