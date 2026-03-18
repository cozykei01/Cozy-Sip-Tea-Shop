const floatingCart = document.getElementById('floatingCart');
const cartModalOverlay = document.getElementById('cartModalOverlay');
const cartModal = document.getElementById('cartModal');
const closeCartModal = document.getElementById('closeCartModal');
const cartCountElement = document.getElementById('cartCount');
const cartItemsContainer = document.getElementById('cartItemsContainer');
const cartTotalPriceElement = document.getElementById('cartTotalPrice');
const addToCartButtons = document.querySelectorAll('.add-to-cart');

let cart = [];

// Open Modal
floatingCart.addEventListener('click', () => {
    cartModalOverlay.classList.add('active');
    cartModal.classList.add('active');
    renderCart();
});

// Close Modal
const closeModal = () => {
    cartModalOverlay.classList.remove('active');
    cartModal.classList.remove('active');
};
closeCartModal.addEventListener('click', closeModal);
cartModalOverlay.addEventListener('click', closeModal);

// Add to Cart Logic
addToCartButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        const productCard = e.target.closest('.product-card');
        const id = productCard.getAttribute('data-id');
        const name = productCard.getAttribute('data-name');
        const price = parseFloat(productCard.getAttribute('data-price'));
        const img = productCard.getAttribute('data-img');

        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ id, name, price, img, quantity: 1 });
        }

        updateCartCount();
        
        // Small animation effect on click
        const icon = button.querySelector('i');
        icon.classList.remove('fa-cart-plus');
        icon.classList.add('fa-check');
        setTimeout(() => {
            icon.classList.remove('fa-check');
            icon.classList.add('fa-cart-plus');
        }, 1000);
    });
});

// Update Cart Count Badge
function updateCartCount() {
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCountElement.textContent = totalCount;
    
    // Animation for cart badge
    cartCountElement.style.transform = 'scale(1.5)';
    setTimeout(() => {
        cartCountElement.style.transform = 'scale(1)';
    }, 200);
}

// Render Cart Items in Modal
function renderCart() {
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart-message">
                <i class="fa-solid fa-basket-shopping"></i>
                <p>Your cart is empty.</p>
            </div>
        `;
        cartTotalPriceElement.textContent = '$0.00';
        return;
    }

    cartItemsContainer.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const cartItemHTML = `
            <div class="cart-item">
                <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-details">
                    <div class="cart-item-title">${item.name}</div>
                    <div class="cart-item-price">$${item.price.toFixed(2)}</div>
                </div>
                <div class="cart-item-actions">
                    <button class="qty-btn minus" data-id="${item.id}"><i class="fa-solid fa-minus"></i></button>
                    <span>${item.quantity}</span>
                    <button class="qty-btn plus" data-id="${item.id}"><i class="fa-solid fa-plus"></i></button>
                    <button class="remove-item" data-id="${item.id}"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        `;
        cartItemsContainer.insertAdjacentHTML('beforeend', cartItemHTML);
    });

    cartTotalPriceElement.textContent = '$' + total.toFixed(2);

    // Add Event Listeners for +/-/remove buttons inside modal
    bindCartItemEvents();
}

function bindCartItemEvents() {
    const minusBtns = cartItemsContainer.querySelectorAll('.minus');
    const plusBtns = cartItemsContainer.querySelectorAll('.plus');
    const removeBtns = cartItemsContainer.querySelectorAll('.remove-item');

    minusBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.target.closest('button').getAttribute('data-id');
            const item = cart.find(i => i.id === id);
            if (item.quantity > 1) {
                item.quantity -= 1;
            } else {
                cart = cart.filter(i => i.id !== id);
            }
            updateCartCount();
            renderCart();
        });
    });

    plusBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.target.closest('button').getAttribute('data-id');
            const item = cart.find(i => i.id === id);
            item.quantity += 1;
            updateCartCount();
            renderCart();
        });
    });

    removeBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.target.closest('button').getAttribute('data-id');
            cart = cart.filter(i => i.id !== id);
            updateCartCount();
            renderCart();
        });
    });
}

// Profile Dropdown Logic
const profileDropdownBtn = document.getElementById('profileDropdownBtn');
const profileDropdown = document.getElementById('profileDropdown');

if (profileDropdownBtn && profileDropdown) {
    profileDropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!profileDropdownBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('active');
        }
    });

    // Prevent closing when clicking inside the dropdown (just in case)
    profileDropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });
}
