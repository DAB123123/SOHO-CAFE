<?php
header('Content-Type: application/javascript');
?>
// totalamount variable will be set from cart.php


function increasePrice(p,id){
  addtolocal(id);
  var qtyInput = document.getElementById(id);
  if (qtyInput) {
    qtyInput.value++;
    totalamount+=p;
    updateTotalDisplay();
  }
};
function decreasePrice(p,id){
  var qtyInput = document.getElementById(id);
  if(qtyInput && qtyInput.value>1) {
    qtyInput.value--;
    totalamount-=p;
  }
  if(totalamount<=0)
    totalamount=0;

  updateTotalDisplay();
}





function remove(id,price)
{
  deletetolocal(id);
  
  var  cl=id;
  var num="div";
  num+=id;
  
  // Get quantity before hiding
  var qtyInput = document.getElementById(id);
  if (!qtyInput) {
    console.error('Quantity input not found for id:', id);
    return;
  }
  
  var quantity = parseInt(qtyInput.value) || 1;
  var deleted_price = price * quantity;

  // Remove the element immediately (compatible method)
  var element = document.getElementById(num);
  if (element && element.parentNode) {
    element.parentNode.removeChild(element);
  }
  
  // Update total amount
  totalamount -= deleted_price;
  if(totalamount <= 0)
    totalamount = 0;

  updateTotalDisplay();
  
  // Check cart status after removal
  checkCartAndToggleButton();
  
  // Update cart badge count
  updateCartBadge();
}

// New functions for size-based cart items
function increasePriceWithSize(p, fullId) {
  var qtyInput = document.getElementById(fullId);
  if (qtyInput) {
    qtyInput.value++;
    totalamount += p;
    updateTotalDisplay();
    updateCartBadge();
  }
}

function decreasePriceWithSize(p, fullId) {
  var qtyInput = document.getElementById(fullId);
  if (qtyInput && qtyInput.value > 1) {
    qtyInput.value--;
    totalamount -= p;
    if (totalamount <= 0) totalamount = 0;
    updateTotalDisplay();
    updateCartBadge();
  }
}

function removeWithSize(fullId, price) {
  // Get quantity before removing
  var qtyInput = document.getElementById(fullId);
  if (!qtyInput) {
    console.error('Quantity input not found for fullId:', fullId);
    return;
  }
  
  var quantity = parseInt(qtyInput.value) || 1;
  var deleted_price = price * quantity;
  
  // Remove from localStorage
  removeItemFromCart(fullId);
  
  // Remove the element immediately from DOM (compatible method)
  var divElement = document.getElementById("div" + fullId);
  if (divElement && divElement.parentNode) {
    divElement.parentNode.removeChild(divElement);
  }
  
  // Update total amount
  totalamount -= deleted_price;
  if (totalamount <= 0) totalamount = 0;
  
  updateTotalDisplay();
  
  // Check cart status after removal
  checkCartAndToggleButton();
  
  // Update cart badge count
  updateCartBadge();
}

function removeItemFromCart(fullId) {
  // Get current user cart
  var user = {};
  if (localStorage.getItem("user") != null) {
    user = JSON.parse(localStorage.getItem("user"));
  }
  
  if (user[userid]) {
    // Remove the item with matching fullId
    user[userid] = user[userid].filter(function(item) {
      if (typeof item === 'object' && item.fullId) {
        return item.fullId !== fullId;
      }
      return true; // Keep non-object items
    });
    
    // Update localStorage
    localStorage.setItem("user", JSON.stringify(user));
  }
}

function updateTotalDisplay() {
  document.getElementById("amount_total").innerHTML = totalamount;
  document.getElementById("payment_amount").innerHTML = totalamount;
  document.getElementById("payment_amount_qr").innerHTML = totalamount;
}

function checkCartAndToggleButton() {
  // Check if there are any cart items in DOM
  var cartItems = document.querySelectorAll('.cart_item');
  var hasVisibleItems = cartItems.length > 0;
  
  // Enable or disable the complete order button
  var completeOrderBtn = document.getElementById('btn_ad');
  if (completeOrderBtn) {
    if (hasVisibleItems && totalamount > 0) {
      completeOrderBtn.disabled = false;
      completeOrderBtn.style.opacity = '1';
      completeOrderBtn.style.cursor = 'pointer';
    } else {
      completeOrderBtn.disabled = true;
      completeOrderBtn.style.opacity = '0.5';
      completeOrderBtn.style.cursor = 'not-allowed';
    }
  }
  
  // If no items left, show empty cart message
  if (!hasVisibleItems) {
    showEmptyCartMessage();
  }
}

function updateCartBadge() {
  // Update the cart badge count in the navigation
  var cartBadge = document.querySelector('.cart-badge');
  if (cartBadge) {
    var visibleItems = document.querySelectorAll('.cart_item');
    var itemCount = 0;
    
    // Use traditional for loop for compatibility
    for (var i = 0; i < visibleItems.length; i++) {
      var qtyInput = visibleItems[i].querySelector('.input-qty');
      if (qtyInput) {
        itemCount += parseInt(qtyInput.value) || 1;
      }
    }
    
    cartBadge.textContent = itemCount;
    
    // Hide badge if count is 0
    if (itemCount === 0) {
      cartBadge.style.display = 'none';
    }
  }
}

function showEmptyCartMessage() {
  var cartTableBody = document.getElementById('demo');
  if (cartTableBody) {
    cartTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;"><h4 style="color: #666;">Your cart is empty</h4><p style="color: #999; margin: 20px 0;">Add items from the menu to continue.</p><a href="menu.php" class="btn btn-primary" style="margin-top: 10px;"><i class="fa fa-shopping-cart"></i> Browse Menu</a></td></tr>';
  }
  
  // Also disable the Complete Order button
  var completeOrderBtn = document.getElementById('btn_ad');
  if (completeOrderBtn) {
    completeOrderBtn.disabled = true;
    completeOrderBtn.style.opacity = '0.5';
    completeOrderBtn.style.cursor = 'not-allowed';
  }
}