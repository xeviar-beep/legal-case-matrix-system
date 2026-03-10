// Service Worker for Push Notifications
self.addEventListener('push', function(event) {
    if (event.data) {
        const data = event.data.json();
        
        const options = {
            body: data.body || 'You have a new notification',
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            vibrate: [200, 100, 200],
            data: {
                url: data.url || '/',
                dateOfArrival: Date.now(),
            },
            actions: data.actions || [
                {
                    action: 'open',
                    title: 'Open',
                },
                {
                    action: 'close',
                    title: 'Close',
                }
            ],
            tag: data.tag || 'notification-' + Date.now(),
            requireInteraction: data.requireInteraction || false,
        };

        event.waitUntil(
            self.registration.showNotification(data.title || 'LAO Case Matrix', options)
        );
    }
});

// Handle notification click
self.addEventListener('notificationclick', function(event) {
    console.log('Notification clicked:', event.action);
    
    // Handle different actions
    if (event.action === 'dismiss' || event.action === 'close') {
        event.notification.close();
        return;
    }
    
    if (event.action === 'snooze') {
        event.notification.close();
        // Re-show notification after 5 minutes
        event.waitUntil(
            new Promise(resolve => {
                setTimeout(() => {
                    self.registration.showNotification(event.notification.title, {
                        body: event.notification.body,
                        icon: event.notification.icon,
                        badge: event.notification.badge,
                        data: event.notification.data,
                        actions: event.notification.actions,
                        tag: event.notification.tag
                    });
                    resolve();
                }, 300000) // 5 minutes
            })
        );
        return;
    }
    
    // Close the notification
    event.notification.close();
    
    // Determine URL to open based on action
    let urlToOpen = event.notification.data.url || '/dashboard';
    
    // Ensure URL is absolute (add origin if needed)
    if (urlToOpen && !urlToOpen.startsWith('http')) {
        urlToOpen = self.location.origin + urlToOpen;
    }
    
    // Handle View Case action - opens the specific case page
    if (event.action === 'view' || event.action === 'open' || !event.action) {
        // Use the URL from notification data (e.g., /cases/1, /cases/15)
        urlToOpen = event.notification.data.url || '/dashboard';
        if (!urlToOpen.startsWith('http')) {
            urlToOpen = self.location.origin + urlToOpen;
        }
        console.log('Opening case URL:', urlToOpen);
    }
    
    // Handle Accept action - opens case and could trigger API call
    if (event.action === 'accept') {
        urlToOpen = event.notification.data.url || '/dashboard';
        console.log('Accepting case and opening URL:', urlToOpen);
    }
    
    // Open the URL
    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(function(clientList) {
            // Parse the target URL
            const targetUrl = new URL(urlToOpen);
            
            // Check if there's already a window/tab open with this URL
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                const clientUrl = new URL(client.url);
                
                // If URL pathname matches, focus that window
                if (clientUrl.pathname === targetUrl.pathname && 'focus' in client) {
                    console.log('Focusing existing window');
                    return client.focus();
                }
            }
            
            // Check if any window is open on the site
            if (clientList.length > 0) {
                const client = clientList[0];
                console.log('Navigating existing window to:', urlToOpen);
                return client.navigate(urlToOpen).then(client => client.focus());
            }
            
            // Open new window if none found
            if (clients.openWindow) {
                console.log('Opening new window:', urlToOpen);
                return clients.openWindow(urlToOpen);
            }
        }).catch(error => {
            console.error('Error handling notification click:', error);
        })
    );
});

// Handle service worker installation
self.addEventListener('install', function(event) {
    self.skipWaiting();
});

// Handle service worker activation
self.addEventListener('activate', function(event) {
    event.waitUntil(clients.claim());
});
