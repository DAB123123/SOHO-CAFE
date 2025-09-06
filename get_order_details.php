<?php
require_once "config.php";

if (isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // Get order details
    $order_sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
    $order_result = mysqli_query($conn, $order_sql);
    
    if ($order_row = mysqli_fetch_array($order_result)) {
        // Check if payment proof exists to determine layout
        $hasPaymentProof = !empty($order_row['payment_proof']);
        
        echo '<div class="row">';
        
        // Left side - Order and Customer Information
        echo '<div class="' . ($hasPaymentProof ? 'col-md-7' : 'col-md-12') . '">';
        
        // Order Information Section
        echo '<div class="mb-4">';
        echo '<h6 class="mb-3"><strong>Order Information</strong></h6>';
        echo '<table class="table table-borderless table-sm">';
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
        echo '<table class="table table-borderless table-sm">';
        echo '<tr><td><strong>Customer Name:</strong></td><td>' . htmlspecialchars($order_row['name']) . '</td></tr>';
        echo '<tr><td><strong>Customer ID:</strong></td><td>#' . $order_row['id'] . '</td></tr>';
        echo '<tr><td><strong>Delivery Address:</strong></td><td>' . htmlspecialchars($order_row['address']) . '</td></tr>';
        echo '</table>';
        echo '</div>';
        
        // Order Description Section
        if (!empty($order_row['description'])) {
            echo '<div class="mb-3">';
            echo '<h6 class="mb-3"><strong>Order Description</strong></h6>';
            echo '<div class="border-start border-3 border-primary ps-3">';
            echo '<p class="mb-0">' . nl2br(htmlspecialchars($order_row['description'])) . '</p>';
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
