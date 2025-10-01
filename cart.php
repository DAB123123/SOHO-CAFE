
<?php 
// Start session and handle data validation at the very beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if data is posted
if(!isset($_POST["data"])) {
    header("location:test.php");
    exit();
}

require_once "config.php";
?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/ico/favicon-16x16.png">
    <link rel="manifest" href="assets/ico/manifest.json">
    <link rel="mask-icon" href="assets/ico/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <meta name="msapplication-config" content="assets/ico/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Cart</title>

    <!-- CSS Plugins -->
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/lightbox/css/lightbox.min.css">
    <link rel="stylesheet" href="assets/plugins/flickity/flickity.min.css">

    <!-- CSS Global -->
    <link rel="stylesheet" href="assets/css/theme.min.css">
     <link rel="stylesheet" href="assets/css/styles_cart.css">


    </head>
<body class="cart-page">

 <!-- / .navbar -->

<?php require_once 'nav.php' ?>
     <br><br><br><br>
  <main class="site-main  main-container no-sidebar">
        <div class="container">
           <!--  <div class="breadcrumb-trail breadcrumbs">
                <ul class="trail-items breadcrumb">
                    <li class="trail-item trail-begin">
                        <a href="">
								<span>
									Home
								</span>
                        </a>
                    </li>
                    <li class="trail-item trail-end active">
							<span>
								Shopping Cart
							</span>
                    </li>
                </ul>
            </div> -->  
            <h3 class="custom_blog_title">
                        Shopping Cart
                    </h3>
            <!-- Main Cart Content -->
            <div class="row main-content-cart main-content">
                <div class="col-sm-9">
                    <div class="page-main-content">
                        <div class="shoppingcart-content">
                            <div class="cart-table-container">
                                <form class="cart-form">
                                    <table class="shop_table">
                                        <thead>
                                        <tr>
                                            <th class="product-remove"></th>
                                            <th class="product-thumbnail"></th>
                                            <th class="product-name"></th>
                                            <th class="product-price"></th>
                                            <th class="product-quantity"></th>
                                            <th class="product-subtotal"></th>
                                        </tr>
                                        </thead>
                             <tbody  id='demo'>
                                        

<?php

$arr = json_decode($_POST["data"], true); // Add true for associative array

// Validate that json_decode was successful and resulted in an array
if (!is_array($arr)) {
    $arr = array(); // Initialize as empty array if json_decode failed
}

   $total=0;
   $processedItems = array(); // Track processed items

$sql = "SELECT * from menu ORDER BY menu_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create a menu lookup for quick access
    $menuLookup = array();
    while($row = $result->fetch_assoc()) {
        $menuLookup[$row["menu_id"]] = $row;
    }
    
    // Process cart items
    foreach($arr as $cartItem) {
        if (is_array($cartItem) && isset($cartItem['id'])) {
            // New format: drink with size
            $menuId = $cartItem['id'];
            $size = $cartItem['size'];
            $price = $cartItem['price'];
            $itemName = $cartItem['name'];
            
            if (isset($menuLookup[$menuId])) {
                $row = $menuLookup[$menuId];
                $total += $price;
                array_push($processedItems, $cartItem);
                
                // Display item with size information
                echo '<tr class="cart_item" id="div' . $cartItem['fullId'] . '">';
                echo '<td class="product-remove">';
                echo '<a class="remove" onclick="removeWithSize(\'' . $cartItem['fullId'] . '\', ' . $price . ')"></a>';
                echo '</td>';
                echo '<td class="product-thumbnail"><a>';
                echo '<img src="assets/img/menu/' . $menuId . '.png" alt="img" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">';
                echo '</a></td>';
                echo '<td class="product-name" data-title="Product">';
                echo '<div class="product-title-container">';
                echo '<a class="title" id="dish' . $cartItem['fullId'] . '">' . htmlspecialchars($itemName) . '</a>';
                
                // Add temperature badge
                if (!empty($row["temperature"])) {
                    $badge_class = $row["temperature"] == 'hot' ? 'hot-badge' : 'cold-badge';
                    echo '<span class="temperature-badge ' . $badge_class . '">' . strtoupper($row["temperature"]) . '</span>';
                }
                
                // Add size badge for drinks
                echo '<span class="size-badge size-' . strtolower($size) . '-badge">' . strtoupper($size) . '</span>';
                
                echo '</div>';
                echo '<span class="attributes-select attributes-size">' . htmlspecialchars($row["description"]) . '</span>';
                echo '</td>';
                echo '<td class="product-quantity" data-title="Quantity">';
                echo '<div class="quantity"><div class="control">';
                echo '<a class="btn-number qtyminus quantity-minus" onclick="decreasePriceWithSize(' . $price . ', \'' . $cartItem['fullId'] . '\')">-</a>';
                echo '<input type="text" data-step="1" data-min="0" value="1" id="' . $cartItem['fullId'] . '" title="Qty" class="input-qty qty" size="4">';
                echo '<a class="btn-number qtyplus quantity-plus" onclick="increasePriceWithSize(' . $price . ', \'' . $cartItem['fullId'] . '\')">+</a>';
                echo '</div></div></td>';
                echo '<td class="product-price" data-title="Price">';
                echo '<span class="woocommerce-Price-amount amount">';
                echo '<span class="woocommerce-Price-currencySymbol">₱</span>';
                echo '<span id="pricy' . $cartItem['fullId'] . '">' . $price . '</span>';
                echo '</span></td></tr>';
            }
        } else if (is_numeric($cartItem)) {
            // Old format: simple menu ID (for non-drinks or legacy items)
            $menuId = intval($cartItem);
            
            if (isset($menuLookup[$menuId])) {
                $row = $menuLookup[$menuId];
                $total += $row["price"];
                array_push($processedItems, $menuId);
                
                // Display regular item
                echo '<tr class="cart_item" id="div' . $menuId . '">';
                echo '<td class="product-remove">';
                echo '<a class="remove" onclick="remove(' . $menuId . ', ' . $row["price"] . ')"></a>';
                echo '</td>';
                echo '<td class="product-thumbnail"><a>';
                echo '<img src="assets/img/menu/' . $menuId . '.png" alt="img" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">';
                echo '</a></td>';
                echo '<td class="product-name" data-title="Product">';
                echo '<div class="product-title-container">';
                echo '<a class="title" id="dish' . $menuId . '">' . htmlspecialchars($row["name"]) . '</a>';
                
                // Add temperature badge
                if (!empty($row["temperature"])) {
                    $badge_class = $row["temperature"] == 'hot' ? 'hot-badge' : 'cold-badge';
                    echo '<span class="temperature-badge ' . $badge_class . '">' . strtoupper($row["temperature"]) . '</span>';
                }
                
                echo '</div>';
                echo '<span class="attributes-select attributes-size">' . htmlspecialchars($row["description"]) . '</span>';
                echo '</td>';
                echo '<td class="product-quantity" data-title="Quantity">';
                echo '<div class="quantity"><div class="control">';
                echo '<a class="btn-number qtyminus quantity-minus" onclick="decreasePrice(' . $row["price"] . ', ' . $menuId . ')">-</a>';
                echo '<input type="text" data-step="1" data-min="0" value="1" id="' . $menuId . '" title="Qty" class="input-qty qty" size="4">';
                echo '<a class="btn-number qtyplus quantity-plus" onclick="increasePrice(' . $row["price"] . ', ' . $menuId . ')">+</a>';
                echo '</div></div></td>';
                echo '<td class="product-price" data-title="Price">';
                echo '<span class="woocommerce-Price-amount amount">';
                echo '<span class="woocommerce-Price-currencySymbol">₱</span>';
                echo '<span id="pricy' . $menuId . '">' . $row["price"] . '</span>';
                echo '</span></td></tr>';
            }
        }
    }
    
    $arr = $processedItems;
} else {
    echo "0 results";
}

$conn->close();

?>




                                    </tbody>
                                </table>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- QR Code Section - Right Side -->
                <div class="col-sm-3">
                    <div class="qr-section">
                        <h4>GCash Payment</h4>
                        <div class="qr-code-container">
                            <?php 
                            $qr_image_path = 'assets/img/payment/gcash_qr.png';
                            $qr_image_path_jpg = 'assets/img/payment/gcash_qr.jpg';
                            if (file_exists($qr_image_path)) {
                                echo '<img src="' . $qr_image_path . '" alt="GCash QR Code">';
                            } elseif (file_exists($qr_image_path_jpg)) {
                                echo '<img src="' . $qr_image_path_jpg . '" alt="GCash QR Code">';
                            } else {
                                echo '<div class="qr-placeholder">
                                        <i class="fa fa-qrcode" style="font-size: 40px; color: #ccc;"></i><br>
                                        <p style="color: #666; margin-top: 10px; font-size: 14px;">GCash QR Code</p>
                                        <small style="color: #999;">Contact admin to set up</small>
                                      </div>';
                            }
                            ?>
                        </div>
                        <p class="qr-amount">
                            Pay: ₱<span id="payment_amount_qr">135</span>
                        </p>
                        <small style="color: #666;">Scan with GCash app</small>
                    </div>
                </div>
            </div>
            
            <!-- Checkout Details Section - Bottom -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="checkout-details">
                        <h4 style="color: #333; margin-bottom: 20px; text-align: center;">Complete Your Order</h4>
                        
                        <!-- Total Amount -->
                        <div class="order-total">
                            <span style="font-size: 18px; color: #666;">Total Amount: </span>
                            <span style="font-size: 28px; color: #e93b81; font-weight: bold;">₱<span id="amount_total">135</span></span>
                        </div>
                        
                        <!-- Checkout Form -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="display: flex; align-items: center; margin-bottom: 15px; font-size: 16px;">
                                        <input type="checkbox" id="checkz" required style="margin-right: 10px; transform: scale(1.2);">
                                        I agree to <span style="color:#e93b81; margin-left: 5px;"><i>terms & conditions</i></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="message">
                                        <i class="fa fa-map-marker"></i> Delivery Address *
                                    </label>
                                    <textarea id="message" name="message" required 
                                            placeholder="Enter your complete delivery address..."></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_proof">
                                        <i class="fa fa-camera"></i> Payment Proof *
                                    </label>
                                    <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*" required>
                                    <small class="text-muted">Upload GCash payment screenshot (JPG, PNG, GIF - Max 5MB)</small>
                                </div>
                                <div id="preview-container" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                        
                        <!-- Payment Instructions -->
                        <div class="payment-info">
                            <strong style="color: #007bff;"><i class="fa fa-info-circle"></i> Payment Steps:</strong><br>
                            <span style="color: #333;">1. Scan QR code (top right) → 2. Pay ₱<span id="payment_amount">135</span> → 3. Upload screenshot → 4. Complete order</span>
                        </div>
                        
                        <!-- Error Messages & Buttons -->
                        <div id="add_err" style="margin-bottom: 15px;"></div>
                        
                        <div style="text-align: center;">
                            <button type="button" class="btn btn-success btn-lg" id="btn_ad" 
                                    <?php if(count($arr)==0) echo 'disabled'; ?>>
                                <i class="fa fa-lock"></i> Complete Order
                            </button>
                            
                            <a href="menu.php">
                                <button type="button" class="btn btn-primary btn-lg" id="btn_ads">
                                    <i class="fa fa-shopping-cart"></i> Continue Shopping
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
<div id="det"></div>
    </main>

<!-- JAVASCRIPT -->
<!-- JS Global -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Cart JS Functions -->
<script src="assets/js/cartitem.php"></script>
<script src="assets/js/menuitem.php"></script>

<!-- JS Plugins -->
<script src="assets/plugins/parallax/parallax.min.js"></script>
<script src="assets/plugins/isotope/lib/imagesloaded.pkgd.min.js"></script>
<script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
<script src="assets/plugins/flickity/flickity.pkgd.min.js"></script>
<script src="assets/plugins/lightbox/js/lightbox.min.js"></script>
<script src="assets/plugins/reservation/reservation.js"></script>
<script src="assets/plugins/alerts/alerts.js"></script>

<!-- JS Custom -->
<script src="assets/js/theme.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

var totalamount= <?php echo $total; ?>;

document.getElementById("amount_total").innerHTML=totalamount;
document.getElementById("payment_amount").innerHTML=totalamount;
document.getElementById("payment_amount_qr").innerHTML=totalamount;

// File upload preview
document.getElementById('payment_proof').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = '<div style="margin-top: 10px;"><strong>Preview:</strong><br><img src="' + e.target.result + '" style="max-width: 200px; max-height: 150px; border: 1px solid #ccc; border-radius: 5px;"></div>';
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.innerHTML = '';
    }
});

$(document).ready(function(){
  $("#btn_ad").click(function(){
<?php if(isset($_SESSION['name'])) 
{
?>
var addr=document.getElementById('message').value;
var checky=document.getElementById('checkz').checked;
var paymentProof = document.getElementById('payment_proof').files[0];

if(checky==""||checky==null)
{
$("#add_err").html('<div class="alert-danger"> <strong>Terms & Condition!</strong> field required </div> <br>');
console.log('dd');
return ;}
else if(addr==null || addr=="")
{
$("#add_err").html('<div class="alert-danger"> <strong>Address!</strong> Address is required </div> <br>');
console.log('dd');
return ;}
else if(!paymentProof)
{
$("#add_err").html('<div class="alert-danger"> <strong>Payment Proof!</strong> Please upload payment proof </div> <br>');
console.log('payment proof required');
return ;}
else
$("#add_err").html('');


var arry=user[userid];
var i=0;
var desc="";
var sizeInfoArray = []; // Array to store size information

// Process both old format (simple IDs) and new format (objects with size)
<?php foreach($processedItems as $index => $item) { ?>
    <?php if (is_array($item)) { 
        // New format: drink with size
        $itemId = $item['fullId'];
        $menuId = $item['id'];
        ?>
        var itemId = "<?php echo $itemId; ?>";
        var menuId = <?php echo $menuId; ?>;
        var quantity = document.getElementById(itemId).value;
        
        // Check if this item exists in cart
        var itemExists = arry.some(function(cartItem) {
            return (typeof cartItem === 'object' && cartItem.fullId === itemId);
        });
        
        if(itemExists) {
            var dish_name = document.getElementById("dish" + itemId).innerHTML;
            var dish_price = document.getElementById("pricy" + itemId).innerHTML;
            desc += quantity + "-" + dish_name + "-" + dish_price + ",";
            
            // Add size info for this item
            sizeInfoArray.push({
                menu_id: menuId,
                size: "<?php echo $item['size']; ?>",
                quantity: parseInt(quantity),
                item_name: dish_name
            });
            
            $.ajax({
                type:"POST",
                url:"try.php", 
                data: "id=" + menuId + "&quan=" + quantity + "&size=" + "<?php echo $item['size']; ?>",
                success:function(html) {
                    if(html=='true')
                        console.log('done');
                    else
                        console.log(html);
                }
            });
        }
    <?php } else { 
        // Old format: simple menu ID
        $itemId = $item;
        ?>
        var idy = <?php echo $itemId; ?>;
        var quantity = document.getElementById(idy).value;
        
        if(arry.indexOf(idy) !== -1) {
            var dish_name = document.getElementById("dish" + idy).innerHTML;
            var dish_price = document.getElementById("pricy" + idy).innerHTML;
            desc += quantity + "-" + dish_name + "-" + dish_price + ",";
            
            $.ajax({
                type:"POST",
                url:"try.php",
                data: "id=" + idy + "&quan=" + quantity,
                success:function(html) {
                    if(html=='true')
                        console.log('done');
                    else
                        console.log(html);
                }
            });
        }
    <?php } ?>
<?php } ?>

var name='<?php echo $_SESSION['name']; ?>';
console.log(name);
var totaly=document.getElementById("amount_total").innerHTML;
var id=<?php echo $_SESSION['login']; ?>;

// Create FormData object for file upload
var formData = new FormData();
formData.append('name', name);
formData.append('description', desc);
formData.append('addr', addr);
formData.append('amount', totaly);
formData.append('id', id);
formData.append('payment_proof', paymentProof);
formData.append('size_info', JSON.stringify(sizeInfoArray)); // Add size information

$.ajax({
type:"POST",
url:"add_order.php",
data: formData,
processData: false,
contentType: false,
success:function(html)
{
if(html=='true')
{
delete user[userid];
delete user[0];
localStorage.setItem("user",JSON.stringify(user));
console.log('placed');
window.location = "order_his.php";
}
else
console.log('false');
}
                });


<?php } ?>

<?php if(!isset($_SESSION['name'])) 
{
?>
window.location = "login.php";
<?php } ?>

  });
});

</script>

</body>

</html>

