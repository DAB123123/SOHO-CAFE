<?php
require_once "config.php";

if (isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $customer_view = isset($_POST['customer_view']) && $_POST['customer_view'] == '1';
    
    // Get order details
    $order_sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $order_result = mysqli_query($conn, $order_sql);
    
    if ($order_row = mysqli_fetch_array($order_result)) {
        // If this is a customer view request, only return the items table
        if ($customer_view) {
            // Jump directly to the items section
            goto items_section;
        }
        
        // Check if payment proof exists to determine layout
        $hasPaymentProof = !empty($order_row['payment_proof']);
        
        echo '<div class="row">';
        
        // Left side - Order and Customer Information
        echo '<div class="' . ($hasPaymentProof ? 'col-md-7' : 'col-md-12') . '">';
        
        // Order Information Section
        echo '<div class="mb-4">';
        echo '<h6 class="mb-3"><strong>Order Information</strong></h6>';
        echo '<table class="table table-borderless table-sm order-details-info-table">';
        echo '<tr><td><strong>Order ID:</strong></td><td>#' . $order_row['order_id'] . '</td></tr>';
        echo '<tr><td><strong>Date:</strong></td><td>' . date('F j, Y g:i A', strtotime($order_row['date'])) . '</td></tr>';
        echo '<tr><td><strong>Status:</strong></td><td>';
        
        switch($order_row['status']) {
            case 'in_progress':
                echo '<span class="badge bg-warning">In Progress</span>';
                break;
            case 'food_otw':
                echo '<span class="badge bg-info">Food OTW</span>';
                break;
            case 'delivered':
                echo '<span class="badge bg-success">Delivered</span>';
                break;
            case 'cancel':
                echo '<span class="badge bg-danger">Cancelled</span>';
                break;
            default:
                echo '<span class="badge bg-secondary">' . htmlspecialchars($order_row['status']) . '</span>';
                break;
        }
        
        echo '</td></tr>';
        echo '<tr><td><strong>Total Amount:</strong></td><td><span class="fw-bold text-success">₱ ' . number_format($order_row['amount'], 2) . '</span></td></tr>';
        echo '</table>';
        echo '</div>';
        
        // Customer Information Section
        echo '<div class="mb-4">';
        echo '<h6 class="mb-3"><strong>Customer Information</strong></h6>';
        echo '<table class="table table-borderless table-sm order-details-info-table">';
        echo '<tr><td><strong>Customer Name:</strong></td><td>' . htmlspecialchars($order_row['name']) . '</td></tr>';
        echo '<tr><td><strong>Customer ID:</strong></td><td>#' . $order_row['id'] . '</td></tr>';
        echo '<tr><td><strong>Delivery Address:</strong></td><td>' . htmlspecialchars($order_row['address']) . '</td></tr>';
        echo '</table>';
        echo '</div>';
        
        // Items section label for customer view
        items_section:
        
        // Order Description Section
        if (!empty($order_row['description'])) {
            echo '<div class="mb-3">';
            echo '<h6 class="mb-3"><strong>Order Items</strong></h6>';
            echo '<div class="border-start border-3 border-primary ps-3">';
            
            // Parse the description to extract individual items
            $description = trim($order_row['description'], ',');
            $items = explode(',', $description);
            
            if (!empty($items)) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-hover table-sm">';
                echo '<thead class="table-light">';
                echo '<tr>';
                echo '<th>Item</th>';
                echo '<th>Details</th>';
                echo '<th>Qty</th>';
                echo '<th>Price</th>';
                echo '<th>Subtotal</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                $total_calculated = 0;
                
                // Parse size information from the size_info column
                $size_info_data = array();
                if (!empty($order_row['size_info'])) {
                    $size_info_data = json_decode($order_row['size_info'], true);
                    if (!is_array($size_info_data)) {
                        $size_info_data = array();
                    }
                }
                
                // Create a lookup for size information by menu_id
                $size_lookup = array();
                foreach ($size_info_data as $size_item) {
                    if (isset($size_item['menu_id'])) {
                        $size_lookup[$size_item['menu_id']] = $size_item;
                    }
                }
                
                foreach ($items as $item) {
                    if (!empty(trim($item))) {
                        $parts = explode('-', $item);
                        if (count($parts) >= 3) {
                            $quantity = trim($parts[0]);
                            $dish_name = trim($parts[1]);
                            $dish_price = floatval(trim($parts[2]));
                            $subtotal = $quantity * $dish_price;
                            $total_calculated += $subtotal;
                            
                            // Get menu item details including menu_id
                            // Extract base name without size info in parentheses
                            $base_name = trim(explode('(', $dish_name)[0]);
                            $menu_sql = "SELECT menu_id, temperature FROM menu WHERE name LIKE '" . mysqli_real_escape_string($conn, $base_name) . "%'";
                            $menu_result = mysqli_query($conn, $menu_sql);
                            $menu_data = mysqli_fetch_array($menu_result);
                            
                            echo '<tr>';
                            echo '<td>';
                            echo '<strong>' . htmlspecialchars($dish_name) . '</strong>';
                            echo '</td>';
                            echo '<td>';
                            
                            // Add temperature badge
                            if ($menu_data && !empty($menu_data['temperature'])) {
                                $temp_class = $menu_data['temperature'] == 'hot' ? 'hot-badge' : 'cold-badge';
                                echo '<span class="temperature-badge ' . $temp_class . '">' . strtoupper($menu_data['temperature']) . '</span>';
                            }
                            
                            // Add size badge from size_info data with inline styles
                            $size_found = false;
                            $size_colors = [
                                'short' => 'background-color: #28a745 !important; color: white !important;',
                                'tall' => 'background-color: #17a2b8 !important; color: white !important;',
                                'grande' => 'background-color: #ffc107 !important; color: black !important;',
                                'venti' => 'background-color: #dc3545 !important; color: white !important;'
                            ];
                            
                            if ($menu_data) {
                                // Try to find size info by menu_id
                                if (isset($size_lookup[$menu_data['menu_id']])) {
                                    $size_info = $size_lookup[$menu_data['menu_id']];
                                    $size = strtolower($size_info['size']);
                                    if (!empty($size)) {
                                        $size_class = 'size-' . $size . '-badge';
                                        $inline_style = isset($size_colors[$size]) ? $size_colors[$size] : '';
                                        echo '<span class="size-badge ' . $size_class . '" style="display: inline-block; padding: 2px 6px; border-radius: 8px; font-size: 0.7rem; font-weight: bold; margin-left: 4px; ' . $inline_style . '">' . strtoupper($size) . '</span>';
                                        $size_found = true;
                                    }
                                }
                                
                                // Fallback: search size_info by item name if menu_id didn't work
                                if (!$size_found) {
                                    foreach ($size_info_data as $size_item) {
                                        if (isset($size_item['item_name']) && stripos($dish_name, $size_item['item_name']) !== false && !empty($size_item['size'])) {
                                            $size = strtolower($size_item['size']);
                                            $size_class = 'size-' . $size . '-badge';
                                            $inline_style = isset($size_colors[$size]) ? $size_colors[$size] : '';
                                            echo '<span class="size-badge ' . $size_class . '" style="display: inline-block; padding: 2px 6px; border-radius: 8px; font-size: 0.7rem; font-weight: bold; margin-left: 4px; ' . $inline_style . '">' . strtoupper($size) . '</span>';
                                            break;
                                        }
                                    }
                                }
                            }
                            
                            echo '</td>';
                            echo '<td><span class="badge bg-secondary">' . $quantity . '</span></td>';
                            echo '<td>₱' . number_format($dish_price, 2) . '</td>';
                            echo '<td><strong>₱' . number_format($subtotal, 2) . '</strong></td>';
                            echo '</tr>';
                        }
                    }
                }
                
                echo '</tbody>';
                echo '<tfoot class="table-light">';
                echo '<tr>';
                echo '<td colspan="4" class="text-end"><strong>Total Amount:</strong></td>';
                echo '<td><strong class="text-success">₱' . number_format($total_calculated, 2) . '</strong></td>';
                echo '</tr>';
                echo '</tfoot>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p class="mb-0 text-muted">No items found in order description.</p>';
            }
            
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>'; // End left column
        
        // Right side - Payment Proof (if available)
        if ($hasPaymentProof) {
            echo '<div class="col-md-5">';
            echo '<div class="position-sticky" style="top: 20px;">';
            echo '<h6 class="mb-3"><strong>Payment Proof</strong></h6>';
            echo '<div class="card shadow-sm">';
            echo '<div class="card-body modal-card-body p-2">';
            echo '<div class="text-center">';
            echo '<img src="uploads/payment_proofs/' . htmlspecialchars($order_row['payment_proof']) . '" ';
            echo 'alt="Payment Proof" ';
            echo 'class="img-fluid rounded cursor-pointer" ';
            echo 'style="max-height: 300px; width: 100%; object-fit: contain; border: 2px solid #e9ecef;" ';
            echo 'onclick="openImageModal(this.src)" ';
            echo 'title="Click to view full size">';
            echo '</div>';
            echo '<div class="text-center mt-2">';
            echo '<small class="text-muted"><i class="fa fa-search-plus"></i> Click image to enlarge</small>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>'; // End right column
        }
        
        echo '</div>'; // End row
        
    } else {
        echo '<div class="alert alert-warning">';
        echo '<i class="fa fa-exclamation-triangle"></i> ';
        echo 'Order not found. The order may have been deleted or the order ID is incorrect.';
        echo '</div>';
    }
} else {
    echo '<div class="alert alert-danger">';
    echo '<i class="fa fa-times-circle"></i> ';
    echo 'Invalid request. No order ID provided.';
    echo '</div>';
}

mysqli_close($conn);
?>
