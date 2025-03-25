<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport"  content="width=device-width, initial-scale=1.0">
    <title><?= $title ??'Application' ?></title>
    
     <!--   Core JS Files  -->
      <script src="<?= BASE_PATH ?>/assets/js/core/jquery-3.7.1.min.js"></script>
      <script src="<?= BASE_PATH ?>/assets/js/core/popper.min.js"></script>
      <script src="<?= BASE_PATH ?>/assets/js/core/bootstrap.min.js"></script> 
 
    <link
      rel="icon"
      href="<?= BASE_PATH ?>/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="<?= BASE_PATH?>/assets/css/sale.css" />
    <link rel="stylesheet" href="<?= BASE_PATH?>/assets/css/order.css" />
    <link rel="stylesheet" href="<?= BASE_PATH?>/assets/css/user.css" />
    <!-- Fonts and icons -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["<?= BASE_PATH ?>/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>
      <script>
        var baseUrl = "<?= BASE_PATH ?>";
     </script>

     <!-- CSS Files -->
      
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/demo.css" />
</head>
<body>
    

    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="<?= BASE_PATH ?>/dashboard" class="logo">
               <img
               src="<?= BASE_PATH ?>/assets/img/logo/logo.png" 
                alt="navbar brand"
                class="navbar-brand"
                height="40"
              /> 
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle=""
                  href="<?= BASE_PATH ?>/dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class=""></span>
                </a>
               
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Services</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="" href="<?= BASE_PATH ?>/patient">
                <i class="fa fa-user"></i>
                  <p>patient</p>
                  <span class=""></span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="" href="<?= BASE_PATH ?>/medicament">
                  <i class="fa  fa-capsules"></i>
                  <p>Medicaments</p>
                  <span class=""></span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="" href="<?= BASE_PATH ?>/category">
                  <i class="fa fa-list"></i>
                  <p>Category</p>
                  <span class=""></span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="" href="<?= BASE_PATH ?>/sale">
                  <i class="fa fa-store"></i>
                  <p>Sales</p>
                  <span class=""></span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="" href="<?= BASE_PATH ?>/supplier">
                  <i class="fas fa-truck"></i>
                  <p>Suppliers</p>
                  <span class=""></span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="" href="<?= BASE_PATH ?>/order">
                <i class="far fa-check-circle"></i>
                  <p>Orders</p>
                  <span class=""></span>
                </a>
               
              </li>
            
            
            
             
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                <i class="fas fa-cog"></i> 
                  <p>settings</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                
                    <li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
                    
                      <a href="<?= BASE_PATH ?>/authenInfo">
                        <span class="sub-item">Registred Users</span>
                      </a>

                      <?php endif; ?>
                    </li>
                    <li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
                   
                      <a href="<?= BASE_PATH ?>/pharmacy">
                        <span class="sub-item">Pharmacy</span>
                      </a>
                      
                      <?php endif; ?>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
       
      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="<?= BASE_PATH ?>/assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
            <!-- Navbar Header -->
            <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
               
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <div class="dropdown-menu quick-actions animated fadeIn">
                  </div>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                    <img src="<?php echo isset($_SESSION['user_picture']) && !empty($_SESSION['user_picture']) 
                                ? $_SESSION['user_picture']  : 'https://via.placeholder.com/130'; ?>" alt="User Profile Picture" 
                             class="avatar-img rounded-circle"/> 
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                        <span> <?php echo htmlspecialchars($_SESSION['username']); ?></span>

                      </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img src="<?php echo isset($_SESSION['user_picture']) && !empty($_SESSION['user_picture']) 
                                ? $_SESSION['user_picture']  : 'https://via.placeholder.com/150'; ?>" alt="User Profile Picture" 
                             class="avatar-img rounded-circle"/> 
                          </div>
                          <div class="u-text">
                            <h4><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'No username available'; ?></h4>
                            <p class="text-muted"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available'; ?></p>

                           
                          </div>
                        </div>
                      </li>
                      <li>
                      
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= BASE_PATH ?>/userSetting/<?php echo htmlspecialchars($_SESSION['user_id']); ?>">Account Setting</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=BASE_PATH ?>/logout">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
        <div class="container">

        <?= $content ?? 'No content provided' ?>

        </div>
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
             
            </nav>
            <div class="copyright">
            © <?php echo date('Y') ?>, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="https://github.com/zineb-khaloua">Zineb Khaloua</a>
            </div>
            <div>
              <a target="_blank" href=""></a>.
            </div>
          </div>
        </footer>
      </div>

    
      <!-- End Custom template -->
    </div>
   

    <!-- jQuery Scrollbar -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="<?= BASE_PATH ?>/assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="<?= BASE_PATH ?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="<?= BASE_PATH ?>/assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="<?= BASE_PATH ?>/assets/js/setting-demo.js"></script>
    <script src="<?= BASE_PATH ?>/assets/js/demo.js"></script>
   
    </script>
  </body>
</html>

