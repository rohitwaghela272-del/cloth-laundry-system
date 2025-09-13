document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Handle date/time input placeholder behavior
    const dateInput = document.getElementById('pickup-date');
    const timeInput = document.getElementById('pickup-time');
    
    dateInput.addEventListener('change', () => {
        if (dateInput.value) {
            dateInput.classList.add('has-value');
        } else {
            dateInput.classList.remove('has-value');
        }
    });
     timeInput.addEventListener('change', () => {
        if (timeInput.value) {
            timeInput.classList.add('has-value');
        } else {
            timeInput.classList.remove('has-value');
        }
    });

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);


    // Laundry Order Form Submission
    const laundryForm = document.getElementById('laundry-form');
    const formMessage = document.getElementById('form-message');

    laundryForm.addEventListener('submit', function(event) {
        event.preventDefault();
        formMessage.innerHTML = `<p class="text-blue-500">Placing your order...</p>`;

        const formData = new FormData(laundryForm);
        const data = Object.fromEntries(formData.entries());

        // --- Backend Integration Point ---
        // This sends the data to your PHP backend
        fetch('api/place_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                formMessage.innerHTML = `<p class="text-green-500">Order placed successfully! Your Order ID is: <strong>${result.order_id}</strong></p>`;
                laundryForm.reset();
                dateInput.classList.remove('has-value');
                timeInput.classList.remove('has-value');
            } else {
                formMessage.innerHTML = `<p class="text-red-500">Error: ${result.message}</p>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            formMessage.innerHTML = `<p class="text-red-500">An unexpected error occurred. Please try again.</p>`;
        });
    });
    
    // Order Tracking
    const trackOrderBtn = document.getElementById('track-order-btn');
    const orderIdInput = document.getElementById('order-id-input');
    const trackingStatusDiv = document.getElementById('tracking-status');

    trackOrderBtn.addEventListener('click', () => {
        const orderId = orderIdInput.value.trim();

        if (!orderId) {
            trackingStatusDiv.innerHTML = `<p class="text-red-500">Please enter an Order ID.</p>`;
            return;
        }

        trackingStatusDiv.innerHTML = `<p class="text-blue-500">Tracking order ${orderId}...</p>`;

        // --- Backend Integration Point (Simulation) ---
        // A real version would fetch('api/track_order.php?id=' + orderId)
        setTimeout(() => {
            const statuses = ['Pending', 'Processing', 'Out for Delivery', 'Completed'];
            const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];

            trackingStatusDiv.innerHTML = `
                <div class="p-4 bg-gray-100 rounded-lg">
                    <h4 class="font-semibold text-lg">Order Status:</h4>
                    <p><strong>Order ID:</strong> ${orderId}</p>
                    <p><strong>Current Status:</strong> <span class="font-bold text-blue-600">${randomStatus}</span></p>
                    <p><strong>Estimated Delivery:</strong> In 2-3 business days.</p>
                </div>
            `;
        }, 1500);
    });
});