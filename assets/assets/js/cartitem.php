<?php
header('Content-Type: application/javascript');
?>
// totalamount variable will be set from cart.php


function increasePrice(p,id){
  addtolocal(id);
document.getElementById(id).value++;
totalamount+=p;

document.getElementById("amount_total").innerHTML=totalamount;
document.getElementById("payment_amount").innerHTML=totalamount;
document.getElementById("payment_amount_qr").innerHTML=totalamount;

};
function decreasePrice(p,id){

  if(document.getElementById(id).value>1)
{document.getElementById(id).value--;
totalamount-=p;}
if(totalamount<=0)
totalamount=0;

document.getElementById("amount_total").innerHTML=totalamount;
document.getElementById("payment_amount").innerHTML=totalamount;
document.getElementById("payment_amount_qr").innerHTML=totalamount;
}





function remove(id,price)
{
  deletetolocal(id);
  

  var  cl=id;
  var num="div";
  num+=id;
  
  document.getElementById(num).style.display="none";

var quantity=document.getElementById(id).value;
var deleted_price=price*quantity;

totalamount-=deleted_price;
if(totalamount<=0)
totalamount=0;

document.getElementById("amount_total").innerHTML=totalamount;
document.getElementById("payment_amount").innerHTML=totalamount;
document.getElementById("payment_amount_qr").innerHTML=totalamount;

  // Check cart status after removal
  checkCartAndToggleButton();
  
}

// New functions for size-based cart items
function increasePriceWithSize(p, fullId) {
  // Add to cart (this will increment quantity in localStorage)
  // For size items, we need to handle this differently
  var qtyInput = document.getElementById(fullId);
  if (qtyInput) {
    qtyInput.value++;
    totalamount += p;
    updateTotalDisplay();
  }
}

function decreasePriceWithSize(p, fullId) {
  var qtyInput = document.getElementById(fullId);
  if (qtyInput && qtyInput.value > 1) {
    qtyInput.value--;
    totalamount -= p;
    if (totalamount <= 0) totalamount = 0;
    updateTotalDisplay();
  }
}

function removeWithSize(fullId, price) {
  // Remove from localStorage
  removeItemFromCart(fullId);
  
  // Hide the DOM element
  var divElement = document.getElementById("div" + fullId);
  if (divElement) {
    divElement.style.display = "none";
  }
  
  // Update total amount
  var qtyInput = document.getElementById(fullId);
  if (qtyInput) {
    var quantity = parseInt(qtyInput.value) || 1;
    var deleted_price = price * quantity;
    totalamount -= deleted_price;
    if (totalamount <= 0) totalamount = 0;
    updateTotalDisplay();
  }
  
  // Check cart status after removal
  checkCartAndToggleButton();
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
  // Check if there are any visible cart items
  var cartItems = document.querySelectorAll('.cart_item');
  var hasVisibleItems = false;
  
  for (var i = 0; i < cartItems.length; i++) {
    if (cartItems[i].style.display !== 'none') {
      hasVisibleItems = true;
      break;
    }
  }
  
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
}