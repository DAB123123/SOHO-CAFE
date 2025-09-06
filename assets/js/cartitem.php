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

  
}