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
          <a id="logout" href="logout_ad.php">Logout</a>
        </div>
        <div class="navbar__right">
          <a class="desktop-logout" href="logout_ad.php">Logout</a>
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
