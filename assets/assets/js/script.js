// This is for able to see chart. We are using Apex Chart. U can check the documentation of Apex Charts too..
// function deliverfunction() {
//   $("#2order").find('td:last').('div').hide();
// }
// $(document).ready(function(){
//   $("#deliver2").click(function(){
//     $("#dots2").hide();
//     $("#2badge").text("Delivered");
//     $("#2badge").removeClass("badge-warning").addClass("badge-success");
//   });
//   $("#cancel2").click(function(){
//     $("#dots2").hide();
//     $("#2badge").text("Cancelled");
//     $("#2badge").removeClass("badge-warning").addClass("badge-danger");
//   });
// });

const navbarLinkIds = ["index", "order", "menu", "additem", "sizepricing"];

navbarLinkIds.forEach((id) => {
  const link = document.getElementById(id);
  if (link) {
    link.classList.remove("active_link");
  }
});

const currentUrl = window.location.pathname + window.location.search;
const activateLink = (id) => {
  const link = document.getElementById(id);
  if (link) {
    link.classList.add("active_link");
  }
};

if (currentUrl.includes("index_ad.php")) {
  activateLink("index");
} else if (currentUrl.includes("order_ad.php")) {
  activateLink("order");
} else if (currentUrl.includes("menu_ad.php")) {
  activateLink("menu");
} else if (currentUrl.includes("add_menu.php")) {
  activateLink("additem");
} else if (currentUrl.includes("manage_size_pricing.php")) {
  activateLink("sizepricing");
}

function deliver(value){
  document.getElementById(value).style.display="none";
  var span=value+"span";
  document.getElementById(span).innerHTML='<span class="badge bg-success">Delivered</span>';
  send_post(value,'delivered');
}
function foodOtw(value){
  var span=value+"span";
  document.getElementById(span).innerHTML='<span class="badge bg-info">Food OTW</span>';
  // Update the dropdown menu to show delivered and cancel options
  document.getElementById(value).innerHTML='<a class="hover-primary dropdown-toggle no-caret" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a> <div class="dropdown-menu" style="margin: 0px;"><a class="dropdown-item" onclick="viewOrderDetails(' + value + ')"><i class="fa fa-eye"></i> View Details</a><a class="dropdown-item" onclick="deliver(' + value + ')"><i class="fa fa-check"></i> Delivered</a><a class="dropdown-item" onclick="cancel(' + value + ')"><i class="fa fa-times"></i> Cancel</a></div>';
  send_post(value,'food_otw');
}
function cancel(value){
  document.getElementById(value).style.display="none";
  var span=value+"span";
  document.getElementById(span).innerHTML='<span class="badge bg-danger">Cancelled</span>';
  send_post(value,'cancel');
}

// Sidebar Toggle Codes;

var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");
var sidebarCloseIcon = document.getElementById("sidebarIcon");

function toggleSidebar() {
  // Check if sidebar exists before trying to manipulate it
  if (sidebar && !sidebarOpen) {
    sidebar.classList.add("sidebar_responsive");
    sidebarOpen = true;
  }
}

function closeSidebar() {
  // Check if sidebar exists before trying to manipulate it
  if (sidebar && sidebarOpen) {
    sidebar.classList.remove("sidebar_responsive");
    sidebarOpen = false;
  }
}

// Mobile menu toggle for navigation links
var mobileMenuOpen = false;

function toggleMobileMenu() {
  const navbarLinks = document.getElementById("navbar-links");
  const mobileToggle = document.querySelector(".mobile-menu-toggle");
  
  if (navbarLinks) {
    if (!mobileMenuOpen) {
      navbarLinks.classList.add("mobile-open");
      mobileMenuOpen = true;
    } else {
      navbarLinks.classList.remove("mobile-open");
      mobileMenuOpen = false;
    }
  }
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
  const navbarLinks = document.getElementById("navbar-links");
  const mobileToggle = document.querySelector(".mobile-menu-toggle");
  
  if (mobileMenuOpen && navbarLinks && mobileToggle) {
    if (!navbarLinks.contains(event.target) && !mobileToggle.contains(event.target)) {
      navbarLinks.classList.remove("mobile-open");
      mobileMenuOpen = false;
    }
  }
});

// Close mobile menu when a nav link is clicked
document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll("#navbar-links a");
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      const navbarLinks = document.getElementById("navbar-links");
      const mobileToggle = document.querySelector(".mobile-menu-toggle");
      
      if (mobileMenuOpen && navbarLinks) {
        navbarLinks.classList.remove("mobile-open");
        mobileMenuOpen = false;
      }
    });
  });
});
