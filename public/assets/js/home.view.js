const floatingCart = document.getElementById('floatingCart');
const cartModalOverlay = document.getElementById('cartModalOverlay');
const cartModal = document.getElementById('cartModal');
const closeCartModal = document.getElementById('closeCartModal');
const cartCountElement = document.getElementById('cartCount');
const cartItemsContainer = document.getElementById('cartItemsContainer');
const cartTotalPriceElement = document.getElementById('cartTotalPrice');
const addToCartButtons = document.querySelectorAll('.add-to-cart');

let cart = [];

// Toast Notification Function
function showToast(message, icon = 'fa-check-circle') {
    const toast = document.createElement('div');
    toast.style = "position: fixed; bottom: 100px; right: 20px; background: #004225; color: white; padding: 1rem 2rem; border-radius: 2rem; z-index: 10000; animation: fadeInUp 0.5s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;";
    toast.innerHTML = `<i class="fa-solid ${icon}"></i> ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        toast.style.transition = 'all 0.5s ease';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

// Open Modal
if (floatingCart) {
    floatingCart.addEventListener('click', () => {
        cartModalOverlay.classList.add('active');
        cartModal.classList.add('active');
        renderCart();
    });
}

// Close Modal
const closeModal = () => {
    if (cartModalOverlay) cartModalOverlay.classList.remove('active');
    if (cartModal) cartModal.classList.remove('active');
};
if (closeCartModal) closeCartModal.addEventListener('click', closeModal);
if (cartModalOverlay) cartModalOverlay.addEventListener('click', closeModal);

// Add to Cart Logic
addToCartButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        if (!userIsLoggedIn) {
            if (confirm("You need to be logged in to add items to your cart. Would you like to login now?")) {
                window.location.href = "index.php?page=login";
            }
            return;
        }
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
        
        // toast notification
        showToast(`Added ${name} to cart`);

        // Small animation effect on click
        const icon = button.querySelector('i');
        if (icon) {
            icon.classList.remove('fa-cart-plus');
            icon.classList.add('fa-check');
            setTimeout(() => {
                icon.classList.remove('fa-check');
                icon.classList.add('fa-cart-plus');
            }, 1000);
        }
    });
});

// Update Cart Count Badge
function updateCartCount() {
    const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
    if (cartCountElement) cartCountElement.textContent = totalCount;
    
    // Show/Hide floating cart
    if (floatingCart) {
        if (totalCount > 0) {
            floatingCart.style.display = 'flex';
        } else {
            floatingCart.style.display = 'none';
        }
    }

    // Animation for cart badge
    if (cartCountElement) {
        cartCountElement.style.transform = 'scale(1.5)';
        setTimeout(() => {
            cartCountElement.style.transform = 'scale(1)';
        }, 200);
    }
}

// Render Cart Items in Modal
function renderCart() {
    if (!cartItemsContainer) return;
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
            <div class="empty-cart-message">
                <i class="fa-solid fa-basket-shopping"></i>
                <p>Your cart is empty.</p>
            </div>
        `;
        cartTotalPriceElement.textContent = '0 Ks';
        return;
    }

    cartItemsContainer.innerHTML = '';
    let total = 0;
    let totalPoints = 0;
    let anyOverStock = false;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        const itemPts = item.points * item.quantity;
        total += itemTotal;
        totalPoints += itemPts;

        // Stock Validation
        let isOverStock = false;
        const qtyElement = document.getElementById(`product-qty-${item.id}`);
        if (qtyElement) {
            const availableStock = parseInt(qtyElement.textContent);
            if (!isNaN(availableStock) && item.quantity > availableStock) {
                isOverStock = true;
                anyOverStock = true;
            }
        }

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
                    <span style="${isOverStock ? 'color: #dc2626; font-weight: 700;' : ''}">${item.quantity}</span>
                    <button class="qty-btn plus" data-id="${item.id}" ${isOverStock ? 'style="opacity: 0.5;"' : ''}><i class="fa-solid fa-plus"></i></button>
                    <button class="remove-item" data-id="${item.id}"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        `;
        cartItemsContainer.insertAdjacentHTML('beforeend', cartItemHTML);
    });

    // Handle checkout button state
    const checkoutBtn = document.getElementById('proceedToCheckoutBtn');
    if (checkoutBtn) {
        if (anyOverStock) {
            checkoutBtn.disabled = true;
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.textContent = 'Insufficient Stock';
        } else {
            checkoutBtn.disabled = false;
            checkoutBtn.style.opacity = '1';
            checkoutBtn.textContent = 'Proceed to Checkout';
        }
    }

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

// --- Unified Checkout & Receipt Modal Logic ---
const initCheckout = () => {
    const proceedToCheckoutBtn = document.getElementById('proceedToCheckoutBtn');
    const checkoutReceiptOverlay = document.getElementById('checkoutReceiptOverlay');
    const checkoutReceiptModal = document.getElementById('checkoutReceiptModal');
    const closeCheckoutModal = document.getElementById('closeCheckoutModal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const closeReceiptModal = document.getElementById('closeReceiptModal');

    // UI Elements for Toggleable states
    const modalTitle = document.getElementById('modalTitle');
    const successStateHeader = document.getElementById('successStateHeader');
    const successStateFooter = document.getElementById('successStateFooter');
    const receiptIdRow = document.getElementById('receiptIdRow');
    const receiptPaymentRow = document.getElementById('receiptPaymentRow');
    const paymentSelectionSection = document.getElementById('paymentSelectionSection');
    
    // Data Elements
    const receiptOrderId = document.getElementById('receiptOrderId');
    const receiptPayment = document.getElementById('receiptPayment');
    const receiptTotal = document.getElementById('receiptTotal');
    const receiptPoints = document.getElementById('receiptPoints');
    const receiptItemsList = document.getElementById('receiptItemsList');

    if (proceedToCheckoutBtn) {
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

            // 1. Populate Summary Data (Step 1)
            const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const earnedPoints = cart.reduce((sum, item) => sum + (item.points * item.quantity), 0);

            if (receiptTotal) receiptTotal.textContent = totalAmount.toLocaleString() + ' Ks';
            if (receiptPoints) receiptPoints.textContent = '+' + earnedPoints + ' Pts';
            if (receiptItemsList) {
                receiptItemsList.innerHTML = cart.map(item => `
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <span style="color: #333;">${item.name} <span style="color: #999; font-size: 0.8rem;">x${item.quantity}</span></span>
                        <span style="font-weight: 500;">${(item.price * item.quantity).toLocaleString()} Ks</span>
                    </div>
                `).join('');
            }

            // 2. Reset Modal to "Selection" State
            if (modalTitle) modalTitle.textContent = "Order Summary";
            if (successStateHeader) successStateHeader.style.display = 'none';
            if (successStateFooter) successStateFooter.style.display = 'none';
            if (receiptIdRow) receiptIdRow.style.display = 'none';
            if (receiptPaymentRow) receiptPaymentRow.style.display = 'none';
            if (paymentSelectionSection) paymentSelectionSection.style.display = 'block';
            if (confirmPaymentBtn) {
                confirmPaymentBtn.style.display = 'block';
                confirmPaymentBtn.disabled = true;
                confirmPaymentBtn.textContent = 'Confirm Order';
            }
            
            const options = document.querySelectorAll('.payment-option');
            options.forEach(opt => opt.classList.remove('selected'));

            // 3. Open Modal
            closeModal(); // Close Cart
            setTimeout(() => {
                if (checkoutReceiptOverlay && checkoutReceiptModal) {
                    checkoutReceiptOverlay.classList.add('active');
                    checkoutReceiptModal.classList.add('active');
                }
            }, 300);
        });
    }

    const closeAll = () => {
        if (checkoutReceiptOverlay && checkoutReceiptModal) {
            checkoutReceiptOverlay.classList.remove('active');
            checkoutReceiptModal.classList.remove('active');
        }
    };

    if (closeCheckoutModal) closeCheckoutModal.onclick = closeAll;
    if (checkoutReceiptOverlay) checkoutReceiptOverlay.onclick = (e) => {
        if (e.target === checkoutReceiptOverlay) closeAll();
    };

    // Close and Refresh on final success
    if (closeReceiptModal) {
        closeReceiptModal.onclick = () => {
            closeAll();
            location.reload();
        };
    }

    // Payment Selection logic
    document.addEventListener('click', (e) => {
        const option = e.target.closest('.payment-option');
        if (option) {
            const options = document.querySelectorAll('.payment-option');
            options.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
            if (confirmPaymentBtn) confirmPaymentBtn.disabled = false;
        }
    });

    // Confirm Payment Logic (Transitions to Success State)
    if (confirmPaymentBtn) {
        confirmPaymentBtn.onclick = () => {
            const selectedOption = document.querySelector('.payment-option.selected');
            if (!selectedOption) return;
            
            const method = selectedOption.getAttribute('data-method');
            const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            const earnedPoints = cart.reduce((sum, item) => sum + (item.points * item.quantity), 0);

            const orderData = {
                cart: cart,
                payment_method: method,
                total_amount: totalAmount,
                total_quantity: totalQuantity,
                earned_points: earnedPoints
            };

            confirmPaymentBtn.disabled = true;
            confirmPaymentBtn.textContent = 'Processing...';

            fetch('index.php?page=checkout', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update Notification Badge
                    if (data.unread_count !== undefined) {
                        const notiBadge = document.getElementById('notiBadge');
                        if (notiBadge) {
                            notiBadge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                            notiBadge.style.display = data.unread_count > 0 ? 'flex' : 'none';
                        }
                    }

                    // --- TRANSITION TO SUCCESS STATE (Step 2) ---
                    if (modalTitle) modalTitle.textContent = "Order Receipt";
                    if (successStateHeader) successStateHeader.style.display = 'block';
                    if (successStateFooter) successStateFooter.style.display = 'block';
                    if (receiptIdRow) {
                        receiptIdRow.style.display = 'flex';
                        if (receiptOrderId) receiptOrderId.textContent = `#${data.order_id || '0000'}`;
                    }
                    if (receiptPaymentRow) {
                        receiptPaymentRow.style.display = 'flex';
                        if (receiptPayment) receiptPayment.textContent = method;
                    }
                    if (paymentSelectionSection) paymentSelectionSection.style.display = 'none';
                    if (confirmPaymentBtn) confirmPaymentBtn.style.display = 'none';

                    // Clear cart
                    cart = [];
                    updateCartCount();
                } else {
                    alert(data.message || 'Payment failed. Please try again.');
                    confirmPaymentBtn.disabled = false;
                    confirmPaymentBtn.textContent = 'Confirm Order';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                confirmPaymentBtn.disabled = false;
                confirmPaymentBtn.textContent = 'Confirm Order';
            });
        };
    }
};

// Initialize on load
initCheckout();

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

// --- Favorites (Add to Favorite) Logic ---
function initFavorites() {
    const favoriteButtons = document.querySelectorAll('.wishlist-btn');
    
    // 1. Fetch initial favorite state if logged in
    if (userIsLoggedIn) {
        fetch('index.php?page=get_favorites')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.favorites) {
                    const favoriteIds = data.favorites.map(String);
                    document.querySelectorAll('.product-card').forEach(card => {
                        const productId = card.dataset.id;
                        if (favoriteIds.includes(productId)) {
                            const heart = card.querySelector('.wishlist-btn i');
                            if (heart) {
                                heart.classList.remove('fa-regular');
                                heart.classList.add('fa-solid');
                                heart.style.color = '#dc2626'; // Red for solid heart
                            }
                        }
                    });
                }
            })
            .catch(err => console.error('Error fetching favorites:', err));
    }

    // 2. Add Click Listeners
    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (!userIsLoggedIn) {
                if (confirm("Please login to add items to your favorites. Login now?")) {
                    window.location.href = "index.php?page=login";
                }
                return;
            }

            const card = this.closest('.product-card');
            const productId = card.dataset.id;
            const heart = this.querySelector('i');

            // Visual Toggle (Optimistic UI)
            const isAdding = heart.classList.contains('fa-regular');
            if (isAdding) {
                heart.classList.remove('fa-regular');
                heart.classList.add('fa-solid');
                heart.style.color = '#dc2626';
            } else {
                heart.classList.remove('fa-solid');
                heart.classList.add('fa-regular');
                heart.style.color = '';
            }

            // Sync with Server
            fetch('index.php?page=favorite_toggle', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ productId: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // If server confirms success, show toast
                    if (typeof showToast === 'function') {
                        // For added, use server's descriptive message
                        if (data.status === 'added') {
                            showToast(data.message, 'fa-heart');
                        }
                    }
                    // Refresh system notifications
                    if (typeof window.fetchNotifications === 'function') {
                        window.fetchNotifications();
                    }
                } else {
                    // Revert UI on failure
                    if (isAdding) {
                        heart.classList.add('fa-regular');
                        heart.classList.remove('fa-solid');
                        heart.style.color = '';
                    } else {
                        heart.classList.add('fa-solid');
                        heart.classList.remove('fa-regular');
                        heart.style.color = '#dc2626';
                    }
                    alert(data.message || "Failed to update favorites");
                }
            })
            .catch(err => {
                console.error('Favorite error:', err);
                // Revert UI on error (assuming it was an add, revert to regular)
                if (isAdding) {
                    heart.classList.add('fa-regular');
                    heart.classList.remove('fa-solid');
                    heart.style.color = '';
                } else { // If it was a remove, revert to solid
                    heart.classList.add('fa-solid');
                    heart.classList.remove('fa-regular');
                    heart.style.color = '#dc2626';
                }
                alert("An error occurred while updating favorites.");
            });
        });
    });
}

// Initialize favorites
initFavorites();
