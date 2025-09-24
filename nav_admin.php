     <?php
      session_start();
      if(!isset($_SESSION['login_ad']))
      {

        header("location:login_ad.php");
      }
     ?>
     <nav class="navbar">
        <div class="navbar__left" id="navbar-links">
          <a id="index" href="index_ad.php">Admin</a>
          <a id="order" href="order_ad.php">Order List</a>
          <a id="menu" href="menu_ad.php">Menu</a>
          <a id="additem" href="add_menu.php">Add New Item</a>
          <a id="logout" href="#" onclick="confirmLogout(event)">Logout</a>
        </div>
        <div class="navbar__right">
          <a class="desktop-logout" href="#" onclick="confirmLogout(event)">Logout</a>
          <!-- Mobile menu toggle for nav links -->
          <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <i class="fa fa-bars" aria-hidden="true"></i>
          </div>
          <a href="#">
            <img width="30" src="assets/avatar.svg" alt="" />
            <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
          </a>
        </div>
      </nav>

      <!-- Floating Notification Button -->
      <div class="floating-notification-btn" id="floating-notification-btn">
        <a href="#" onclick="toggleNotificationPanel(event)" title="View Notifications">
          <i class="fa fa-bell"></i>
          <span class="notification-badge" id="notification-badge" style="display: none;">0</span>
        </a>
      </div>

      <!-- Notification Panel -->
      <div class="notification-panel" id="notification-panel">
        <div class="notification-header">
          <h4>Recent Orders</h4>
          <button class="close-btn" onclick="closeNotificationPanel()">
            <i class="fa fa-times"></i>
          </button>
        </div>
        <div class="notification-content" id="notification-content">
          <div class="loading-spinner">
            <i class="fa fa-spinner fa-spin"></i>
            Loading recent orders...
          </div>
        </div>
        <div class="notification-footer">
          <a href="order_ad.php" class="view-all-btn">
            <i class="fa fa-list"></i> View All Orders
          </a>
        </div>
      </div>

      <!-- Notification Count Script -->
      <script>
      function updateNotificationCount() {
          fetch('get_notification_count.php')
              .then(response => response.json())
              .then(data => {
                  const badge = document.getElementById('notification-badge');
                  if (data.count > 0) {
                      badge.textContent = data.count > 99 ? '99+' : data.count;
                      badge.style.display = 'inline-block';
                  } else {
                      badge.style.display = 'none';
                  }
              })
              .catch(error => console.error('Error fetching notification count:', error));
      }

      // Update notification count on page load
      document.addEventListener('DOMContentLoaded', function() {
          updateNotificationCount();
          // Update every 3 seconds (reduced from 30 seconds)
          setInterval(updateNotificationCount, 3000);
      });

      // Logout confirmation function
      function confirmLogout(event) {
          event.preventDefault();
          
          // Create a custom confirmation dialog
          const confirmed = confirm('Are you sure you want to logout?\n\nThis will end your current admin session.');
          
          if (confirmed) {
              // Redirect to logout page
              window.location.href = 'logout_ad.php';
          }
      }

      // Notification panel functions
      function toggleNotificationPanel(event) {
          event.preventDefault();
          const panel = document.getElementById('notification-panel');
          const isVisible = panel.classList.contains('show');
          
          if (isVisible) {
              closeNotificationPanel();
          } else {
              openNotificationPanel();
          }
      }

      function openNotificationPanel() {
          const panel = document.getElementById('notification-panel');
          panel.classList.add('show');
          
          // Fetch recent orders
          fetchRecentOrders();
      }

      function closeNotificationPanel() {
          const panel = document.getElementById('notification-panel');
          panel.classList.remove('show');
      }

      function fetchRecentOrders() {
          const content = document.getElementById('notification-content');
          
          fetch('get_recent_orders.php')
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      renderRecentOrders(data.orders);
                  } else {
                      content.innerHTML = '<div class="no-orders">No recent orders found</div>';
                  }
              })
              .catch(error => {
                  console.error('Error fetching recent orders:', error);
                  content.innerHTML = '<div class="error">Error loading orders</div>';
              });
      }

      function renderRecentOrders(orders) {
          const content = document.getElementById('notification-content');
          
          if (orders.length === 0) {
              content.innerHTML = '<div class="no-orders"><i class="fa fa-check-circle"></i><br>All caught up!<br><small>No unread notifications</small></div>';
              return;
          }
          
          let html = '';
          orders.forEach(order => {
              const statusClass = getStatusClass(order.status);
              const timeAgo = getTimeAgo(order.date);
              
              html += `
                  <div class="order-item" onclick="viewOrder(${order.order_id})">
                      <div class="order-info">
                          <div class="order-id">#${order.order_id}</div>
                          <div class="customer-name">${order.name}</div>
                          <div class="order-time">${timeAgo}</div>
                      </div>
                      <div class="order-status">
                          <span class="status-badge ${statusClass}">${order.status}</span>
                          <div class="order-amount">₱${order.amount}</div>
                      </div>
                  </div>
              `;
          });
          
          content.innerHTML = html;
      }

      function getStatusClass(status) {
          const statusMap = {
              'in_progress': 'status-in-progress',
              'food_otw': 'status-otw',
              'delivered': 'status-delivered',
              'cancel': 'status-cancelled',
              'cancelled': 'status-cancelled',
              'canceled': 'status-cancelled'
          };
          return statusMap[status] || 'status-default';
      }

      function getTimeAgo(dateString) {
          const now = new Date();
          const orderDate = new Date(dateString);
          const diffMs = now - orderDate;
          const diffMins = Math.floor(diffMs / 60000);
          const diffHours = Math.floor(diffMins / 60);
          const diffDays = Math.floor(diffHours / 24);
          
          if (diffMins < 1) return 'Just now';
          if (diffMins < 60) return `${diffMins}m ago`;
          if (diffHours < 24) return `${diffHours}h ago`;
          return `${diffDays}d ago`;
      }

      function viewOrder(orderId) {
          closeNotificationPanel();
          // Mark notification as read
          fetch('mark_notification_read.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: 'order_id=' + encodeURIComponent(orderId)
          })
          .then(() => {
              // Update notification count after marking as read
              updateNotificationCount();
          })
          .catch(error => console.error('Error marking notification as read:', error));
          
          // Redirect to order details
          window.location.href = `order_ad.php?view=${orderId}`;
      }

      // Close panel when clicking outside
      document.addEventListener('click', function(event) {
          const panel = document.getElementById('notification-panel');
          const button = document.getElementById('floating-notification-btn');
          
          if (!panel.contains(event.target) && !button.contains(event.target)) {
              closeNotificationPanel();
          }
      });
      </script>
