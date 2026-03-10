// Push Notifications Manager
const PushNotifications = {
    swRegistration: null,
    isSubscribed: false,
    publicKey: null,

    // Initialize push notifications
    async init() {
        console.log('Initializing push notifications...');
        
        // Check if browser supports push notifications
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.log('Push notifications are not supported by this browser');
            return;
        }

        try {
            console.log('Browser supports push notifications');
            
            // Get VAPID public key from server
            console.log('Fetching VAPID public key...');
            await this.fetchPublicKey();
            console.log('VAPID key fetched successfully');
            
            // Register service worker
            console.log('Registering service worker...');
            await this.registerServiceWorker();
            console.log('Service worker registered successfully');
            
            // Check current subscription status
            console.log('Checking subscription status...');
            await this.checkSubscription();
            console.log('Subscription status checked');
            
            // Update UI
            this.updateUI();
            console.log('Push notifications initialized successfully');
        } catch (error) {
            console.error('Error initializing push notifications:', error);
            console.error('Stack trace:', error.stack);
        }
    },

    // Fetch VAPID public key from server
    async fetchPublicKey() {
        try {
            console.log('Fetching public key from /push/public-key...');
            const response = await fetch('/push/public-key');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Public key response:', data);
            
            // Check if there was an error in the response
            if (data.error) {
                throw new Error(data.error);
            }
            
            if (!data.publicKey) {
                throw new Error('Public key not found in response. Please check your .env file has VAPID_PUBLIC_KEY set.');
            }
            
            // Validate the public key format (should be base64url encoded, around 87-88 chars)
            if (data.publicKey.length < 80) {
                throw new Error('Public key appears to be invalid or incomplete.');
            }
            
            this.publicKey = data.publicKey;
            console.log('Public key set successfully:', this.publicKey.substring(0, 20) + '...');
        } catch (error) {
            console.error('Error fetching public key:', error);
            console.error('Make sure:');
            console.error('1. The server is running');
            console.error('2. VAPID_PUBLIC_KEY is set in your .env file');
            console.error('3. Config cache is cleared (php artisan config:clear)');
            throw error;
        }
    },

    // Register service worker
    async registerServiceWorker() {
        try {
            this.swRegistration = await navigator.serviceWorker.register('/service-worker.js');
            console.log('Service Worker registered successfully');
            
            // Wait for service worker to be ready
            await navigator.serviceWorker.ready;
        } catch (error) {
            console.error('Service Worker registration failed:', error);
            throw error;
        }
    },

    // Check if user is already subscribed
    async checkSubscription() {
        try {
            const subscription = await this.swRegistration.pushManager.getSubscription();
            this.isSubscribed = subscription !== null;
            
            if (this.isSubscribed) {
                console.log('User is already subscribed');
            }
        } catch (error) {
            console.error('Error checking subscription:', error);
        }
    },

    // Subscribe to push notifications
    async subscribe() {
        try {
            // Check if service worker is registered
            if (!this.swRegistration) {
                console.log('Service worker not registered, initializing...');
                await this.init();
            }
            
            // Check if public key is available
            if (!this.publicKey) {
                console.log('Public key not available, fetching...');
                await this.fetchPublicKey();
            }
            
            // Final validation
            if (!this.publicKey) {
                throw new Error('VAPID public key could not be retrieved. Check server configuration and .env file.');
            }
            
            console.log('Requesting notification permission...');
            
            // Request notification permission
            const permission = await Notification.requestPermission();
            
            if (permission !== 'granted') {
                alert('Please enable notifications to receive updates');
                return;
            }

            console.log('Permission granted, subscribing...');
            console.log('Public key:', this.publicKey);

            // Convert VAPID key to Uint8Array
            const applicationServerKey = this.urlBase64ToUint8Array(this.publicKey);

            // Subscribe to push notifications
            const subscription = await this.swRegistration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: applicationServerKey
            });

            console.log('User subscribed to push notifications');
            console.log('Subscription:', subscription);

            // Send subscription to server
            await this.sendSubscriptionToServer(subscription);

            this.isSubscribed = true;
            this.updateUI();
            
            alert('Push notifications enabled successfully!');
        } catch (error) {
            console.error('Error subscribing to push notifications:', error);
            console.error('Error details:', error.message);
            alert('Failed to enable push notifications: ' + error.message);
        }
    },

    // Unsubscribe from push notifications
    async unsubscribe() {
        try {
            const subscription = await this.swRegistration.pushManager.getSubscription();
            
            if (subscription) {
                await subscription.unsubscribe();
                console.log('User unsubscribed from push notifications');
                
                // Remove subscription from server
                await this.removeSubscriptionFromServer(subscription);
                
                this.isSubscribed = false;
                this.updateUI();
                
                alert('Push notifications disabled successfully!');
            }
        } catch (error) {
            console.error('Error unsubscribing from push notifications:', error);
            alert('Failed to disable push notifications. Please try again.');
        }
    },

    // Send subscription to server
    async sendSubscriptionToServer(subscription) {
        try {
            console.log('Sending subscription to server...');
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                throw new Error('CSRF token not found');
            }
            
            const payload = {
                endpoint: subscription.endpoint,
                keys: {
                    p256dh: this.arrayBufferToBase64(subscription.getKey('p256dh')),
                    auth: this.arrayBufferToBase64(subscription.getKey('auth'))
                }
            };
            
            console.log('Subscription payload:', payload);
            
            const response = await fetch('/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server response:', errorText);
                throw new Error(`Failed to save subscription: ${response.status} ${response.statusText}`);
            }
            
            const result = await response.json();
            console.log('Subscription saved on server:', result);
        } catch (error) {
            console.error('Error sending subscription to server:', error);
            throw error;
        }
    },

    // Remove subscription from server
    async removeSubscriptionFromServer(subscription) {
        try {
            await fetch('/push/unsubscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint
                })
            });

            console.log('Subscription removed from server');
        } catch (error) {
            console.error('Error removing subscription from server:', error);
        }
    },

    // Update UI based on subscription status
    updateUI() {
        const enableBtn = document.getElementById('enable-notifications-btn');
        const disableBtn = document.getElementById('disable-notifications-btn');
        const testBtn = document.getElementById('test-notification-btn');
        const debugBtn = document.getElementById('debug-notification-btn');
        
        if (enableBtn && disableBtn) {
            if (this.isSubscribed) {
                enableBtn.style.display = 'none';
                disableBtn.style.display = 'block';
                if (testBtn) testBtn.style.display = 'block';
                if (debugBtn) debugBtn.style.display = 'none';
            } else {
                enableBtn.style.display = 'block';
                disableBtn.style.display = 'none';
                if (testBtn) testBtn.style.display = 'none';
                if (debugBtn) debugBtn.style.display = 'block';
            }
        }
    },

    // Helper: Convert URL-safe base64 to Uint8Array
    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    },

    // Helper: Convert ArrayBuffer to Base64
    arrayBufferToBase64(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return window.btoa(binary);
    }
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        PushNotifications.init();
        setupTestNotificationButton();
    });
} else {
    PushNotifications.init();
    setupTestNotificationButton();
}

// Setup test notification button
function setupTestNotificationButton() {
    const testBtn = document.getElementById('test-notification-btn');
    if (testBtn) {
        testBtn.addEventListener('click', async function() {
            console.log('Test notification button clicked');
            
            try {
                const response = await fetch('/notifications/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success feedback
                    const originalText = testBtn.innerHTML;
                    testBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Sent!';
                    testBtn.classList.remove('btn-outline-warning');
                    testBtn.classList.add('btn-success');
                    
                    setTimeout(() => {
                        testBtn.innerHTML = originalText;
                        testBtn.classList.remove('btn-success');
                        testBtn.classList.add('btn-outline-warning');
                    }, 2000);
                    
                    // Reload notifications to show the new one
                    if (typeof loadNotifications === 'function') {
                        setTimeout(loadNotifications, 500);
                    }
                } else {
                    alert(data.message || 'Failed to send test notification');
                }
            } catch (error) {
                console.error('Error sending test notification:', error);
                alert('Error sending test notification');
            }
        });
    }
}

// Expose globally for button clicks
window.PushNotifications = PushNotifications;
