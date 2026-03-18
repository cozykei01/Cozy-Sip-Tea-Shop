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
        const points = parseInt(productCard.getAttribute('data-points')) || 0;

        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ id, name, price, img, quantity: 1, points });
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
        cartTotalPriceElement.textContent = '0 Ks';
        const oldPointsEl = document.getElementById('cartTotalPoints');
        if (oldPointsEl) oldPointsEl.remove();
        return;
    }

    cartItemsContainer.innerHTML = '';
    let total = 0;
    let totalPoints = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        const itemPts = item.points * item.quantity;
        total += itemTotal;
        totalPoints += itemPts;

        const cartItemHTML = `
            <div class="cart-item">
                <img src="${item.img}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-details">
                    <div class="cart-item-title">${item.name}</div>
                    <div class="cart-item-price">${item.price.toLocaleString()} Ks</div>
                    <div class="cart-item-points" style="font-size: 0.85rem; color: var(--cozy-green);">+${itemPts} Pts</div>
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

    cartTotalPriceElement.textContent = total.toLocaleString() + ' Ks';
    
    const pointsEl = document.getElementById('cartTotalPoints');
    const pointsRow = document.getElementById('pointsRow');
    if (pointsEl && pointsRow) {
        if (total === 0) {
            pointsRow.style.display = 'none';
        } else {
            pointsRow.style.display = 'flex';
            pointsEl.textContent = '+' + totalPoints + ' Pts';
        }
    }
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

// --- Checkout & Payment Modal Logic ---
const initCheckout = () => {
    const proceedToCheckoutBtn = document.getElementById('proceedToCheckoutBtn');
    const paymentModalOverlay = document.getElementById('paymentModalOverlay');
    const paymentModal = document.getElementById('paymentModal');
    const closePaymentModal = document.getElementById('closePaymentModal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');

    if (proceedToCheckoutBtn) {
        // Remove existing listener if any to avoid duplicates
        const newBtn = proceedToCheckoutBtn.cloneNode(true);
        proceedToCheckoutBtn.parentNode.replaceChild(newBtn, proceedToCheckoutBtn);
        
        newBtn.addEventListener('click', () => {
            if (!userIsLoggedIn) {
                alert("Please login to proceed with your order.");
                window.location.href = "index.php?page=login";
                return;
            }
            if (cart.length === 0) {
                alert("Your cart is empty!");
                return;
            }
            // Close Cart Modal and Open Payment Modal
            closeModal();
            setTimeout(() => {
                if (paymentModalOverlay && paymentModal) {
                    paymentModalOverlay.classList.add('active');
                    paymentModal.classList.add('active');
                }
            }, 300);
        });
    }

    const closePayment = () => {
        if (paymentModalOverlay && paymentModal) {
            paymentModalOverlay.classList.remove('active');
            paymentModal.classList.remove('active');
        }
    };

    if (closePaymentModal) closePaymentModal.onclick = closePayment;
    if (paymentModalOverlay) paymentModalOverlay.onclick = closePayment;

    // Use event delegation for payment options
    document.addEventListener('click', (e) => {
        const option = e.target.closest('.payment-option');
        if (option) {
            const options = document.querySelectorAll('.payment-option');
            options.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
            if (confirmPaymentBtn) confirmPaymentBtn.disabled = false;
        }
    });

    if (confirmPaymentBtn) {
        confirmPaymentBtn.onclick = () => {
            const selectedOption = document.querySelector('.payment-option.selected');
            if (!selectedOption) return;
            
            const method = selectedOption.getAttribute('data-method');
            
            // Calculate totals for backend
            const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            const earnedPoints = cart.reduce((sum, item) => sum + (item.points * item.quantity), 0);

            // Prepare order data
            const orderData = {
                cart: cart,
                payment_method: method,
                total_amount: totalAmount,
                total_quantity: totalQuantity,
                earned_points: earnedPoints
            };

            // Disable button during processing
            confirmPaymentBtn.disabled = true;
            confirmPaymentBtn.textContent = 'Processing...';

            fetch('index.php?page=checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Order confirmed with ${method.toUpperCase()}! Thank you for your purchase.`);
                    
                    // Update Points Display in Navbar
                    const pointsDisplay = document.getElementById('userPointsDisplay');
                    if (pointsDisplay) {
                        pointsDisplay.textContent = data.new_points + ' Pts';
                    }

                    // Reset cart and UI
                    cart = [];
                    updateCartCount();
                    closePayment();
                    
                    // Optional: Redirect or refresh to update all session states
                    // window.location.reload(); 
                } else {
                    alert(data.message || 'Failed to process order. Please try again.');
                    confirmPaymentBtn.disabled = false;
                    confirmPaymentBtn.textContent = 'Confirm Order';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
                confirmPaymentBtn.disabled = false;
                confirmPaymentBtn.textContent = 'Confirm Order';
            });
        };
    }
};

// Initialize on load
initCheckout();

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

// --- Menu Page Search & Filter Functionality ---
const searchInput = document.querySelector('.search-input');
const categoryFilter = document.querySelector('.category-filter');
const productsCards = document.querySelectorAll('.product-card');
const allSections = document.querySelectorAll('.products-section');

if (allSections.length > 0) {
    // Clean up old noResultsMsg if any exists
    const oldMsg = document.querySelector('.no-results-msg');
    if (oldMsg) oldMsg.remove();

    // Create "No results" message element
    let noResultsMsg = document.createElement('div');
    noResultsMsg.className = 'no-results-msg';
    noResultsMsg.style.textAlign = 'center';
    noResultsMsg.style.padding = '3rem 2rem';
    noResultsMsg.style.width = '100%';
    noResultsMsg.style.color = '#888';
    noResultsMsg.innerHTML = '<i class="fa-solid fa-mug-hot" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i><h3>Oh no! We couldn\'t find that brew.</h3><p>Try searching for a different tea or coffee.</p>';
    noResultsMsg.style.display = 'none';
    
    // Append it perfectly beneath the menu-controls if it exists
    const controlsWrap = document.querySelector('.menu-controls');
    if (controlsWrap) {
        controlsWrap.parentNode.insertBefore(noResultsMsg, controlsWrap.nextSibling);
    }

    // Unified filter function
    function filterProducts() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedValue = categoryFilter ? categoryFilter.value : 'all';
        
        // Map dropdown values to section names (these must match the <h2> text in HTML)
        const categoryMap = { 
            '1': 'basic coffee', 
            '2': 'cold coffee', 
            '3': 'tea & non-coffee', 
            '4': 'specialty drinks', 
            '5': 'bakery & snacks' 
        };
        const targetCategory = selectedValue !== 'all' ? categoryMap[selectedValue] : 'all';

        let totalVisibleCards = 0;

        allSections.forEach(sec => {
            const header = sec.querySelector('.section-header');
            const grid = sec.querySelector('.products-grid');
            if (!header || !grid) return;
            
            const h2 = header.querySelector('h2');
            const sectionName = h2 ? h2.textContent.toLowerCase() : '';
            let sectionHasVisibleCards = false;

            // Check if section matches category dropdown
            const matchesCategory = targetCategory === 'all' || sectionName === targetCategory;

            const cards = grid.querySelectorAll('.product-card');
            cards.forEach(card => {
                const productName = card.dataset.name ? card.dataset.name.toLowerCase() : '';
                const matchesSearch = productName.includes(searchTerm);

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                    sectionHasVisibleCards++;
                    totalVisibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Hide the entire section layout components if no cards are visible inside it
            if (sectionHasVisibleCards > 0) {
                // If the user typed a search term, usually we hide category headers to look more like a flat list, but if they just select a category, keep the header.
                header.style.display = searchTerm.length > 0 ? 'none' : 'block';
                grid.style.display = 'grid'; // .products-grid requires 'grid'
            } else {
                header.style.display = 'none';
                grid.style.display = 'none';
            }
        });

        // Show/hide main no results message
        if (totalVisibleCards === 0) {
            noResultsMsg.style.display = 'block';
        } else {
            noResultsMsg.style.display = 'none';
        }
    }

    if (searchInput) searchInput.addEventListener('input', filterProducts);
    
    // Custom Dropdown Logic
    const customDropdown = document.getElementById('categoryDropdown');
    const hiddenCategoryFilter = document.getElementById('categoryFilterVal');
    
    if (customDropdown && hiddenCategoryFilter) {
        const selectedDisplay = customDropdown.querySelector('.dropdown-selected');
        const selectedText = document.getElementById('selectedCategoryText');
        const options = customDropdown.querySelectorAll('.dropdown-option');

        selectedDisplay.addEventListener('click', (e) => {
            e.stopPropagation();
            customDropdown.classList.toggle('active');
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                // Remove active from all
                options.forEach(opt => opt.classList.remove('active'));
                // Add active state to clicked option
                option.classList.add('active');
                
                // Update text and hidden input value
                selectedText.textContent = option.textContent;
                hiddenCategoryFilter.value = option.dataset.value;
                
                // Close dropdown
                customDropdown.classList.remove('active');
                
                // Trigger filter manually
                filterProducts();
            });
        });

        // Close dropdown when clicking anywhere else
        document.addEventListener('click', (e) => {
            if (!customDropdown.contains(e.target)) {
                customDropdown.classList.remove('active');
            }
        });
    }
}

