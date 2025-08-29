<?php
require_once 'db.php';
session_start();

$first_name = '';
$last_name = '';
if (isset($_SESSION['email'])) {
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Support | Sneat Admin</title>
    <meta name="description" content="" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
  </head>
  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              <span class="app-brand-logo demo"></span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">ПО СЪЩЕСТВО</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
            <li class="menu-item">
              <a href="admin-dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Начало</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Страници</span></li>
            <li class="menu-item">
              <a href="admins.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tables">Екип</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Информация</span></li>
            <li class="menu-item active">
              <a href="support.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Поддръжка</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="documentation.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Документация</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Търси..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/avatar.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../assets/avatar.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></span>
                            <small class="text-muted">
                              <?php
                                if (isset($_SESSION['role'])) {
                                  echo $_SESSION['role'] === 'owner' ? 'Собственик' : ($_SESSION['role'] === 'admin' ? 'Админ' : 'Потребител');
                                }
                              ?>
                            </small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="index.php">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <span class="align-middle">Начало</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Профил</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Излез</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Клуб по програмиране "По същество" |</span> Поддръжка</h4>
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="card-title">Свържи се с нас</h5>
                  <p class="card-text">Ако имаш въпрос, проблем или нужда от помощ, можеш да ни пишеш или да се свържеш директно със създателите на клуба:</p>
                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <div class="card h-100">
                        <div class="card-body text-center">
                          <img src="../assets/branimir.jpg" alt="Бранимир Янчев" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                          <h5 class="card-title mb-1">Бранимир Янчев</h5>
                          <p class="text-muted mb-2">Разработчик и преподавател</p>
                          <p class="mb-1"><i class="bx bx-envelope"></i> <a href="mailto:branimir@pcb.com">branimir@pcb.com</a></p>
                          <p class="mb-1"><i class="bx bx-phone"></i> <a href="tel:+359888123456">+359 888 123 456</a></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 mb-4">
                      <div class="card h-100">
                        <div class="card-body text-center">
                          <img src="../assets/spas.jpg" alt="Спас Китанов" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                          <h5 class="card-title mb-1">Спас Китанов</h5>
                          <p class="text-muted mb-2">Артист и уеб разработчик</p>
                          <p class="mb-1"><i class="bx bx-envelope"></i> <a href="mailto:spas@pcb.com">spas@pcb.com</a></p>
                          <p class="mb-1"><i class="bx bx-phone"></i> <a href="tel:+359887654321">+359 887 654 321</a></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <h5 class="mt-4">Форма за контакт</h5>
                  <form method="post" autocomplete="off">
                    <div class="mb-3">
                      <label for="support_email" class="form-label">Твоят имейл</label>
                      <input type="email" class="form-control" id="support_email" name="support_email" required>
                    </div>
                    <div class="mb-3">
                      <label for="support_message" class="form-label">Съобщение</label>
                      <textarea class="form-control" id="support_message" name="support_message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Изпрати</button>
                  </form>
                  <?php
                  if (isset($_POST['support_email'], $_POST['support_message'])) {
                    echo '<div class="alert alert-success mt-3">Съобщението ти е изпратено успешно!</div>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>