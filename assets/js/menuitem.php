
<?php
header('Content-Type: application/javascript');
session_start();
?>

var userid=0;
<?php
$x=0;
if (isset($_SESSION['login'])) 
$x=$_SESSION['login'];

?>
var userid=<?php echo $x; ?>;
console.log(userid);

var user={};
// Check browser support
if (localStorage.getItem("user") != null) {

var obj=localStorage.getItem("user");
user=JSON.parse(obj);

}

if(!(user.hasOwnProperty(userid)))
{
  if((user.hasOwnProperty(0)))
  {user[userid]=user[0];
   delete user[0];
   localStorage.setItem("user",JSON.stringify(user));
  }
  else	
  user[userid]=[];
}


function addtolocal(nid)
{
  if(user[userid].indexOf(nid)==-1)
  {
    var i;
    var n=user[userid].length;
    var key=nid;
    for (i = n - 1; (i >= 0 && user[userid][i] > key); i--)
        user[userid][i + 1] = user[userid][i];

    user[userid][i + 1] = key;

    localStorage.setItem("user",JSON.stringify(user));

    // Show success notification if function exists
    if (typeof showCartNotification === 'function') {
        showCartNotification('success', 'Added to Cart', 'Item has been added to your cart!');
    }
  }
  else 
  {
    // Show warning notification if function exists
    if (typeof showCartNotification === 'function') {
        showCartNotification('warning', 'Already in Cart', 'This item is already in your cart.');
    }
  }
  
  console.log(user);
}

function deletetolocal(nid)
{
  if(user[userid].indexOf(nid)!=-1)
  {
    var index = user[userid].indexOf(nid);
    


    var i;
    var n=user[userid].length;
    for (i = index; i < n - 1; i++)
            user[userid][i] = user[userid][i + 1];
            user[userid].pop();



    
    
    localStorage.setItem("user",JSON.stringify(user));
    

  }


  
  console.log(user);

  

}