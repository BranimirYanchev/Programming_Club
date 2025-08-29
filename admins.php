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

if (
  isset($_SESSION['role']) && $_SESSION['role'] === 'owner' &&
  isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['role'], $_POST['specialty'])
) {
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $role = $_POST['role'];
  $specialty = $_POST['specialty'];
  $city = 'Благоевград'; // Винаги задава Благоевград

  // Проверка дали имейлът вече съществува
  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    echo '<div class="alert alert-danger">Този имейл вече съществува!</div>';
  } else {
    $stmt = $conn->prepare("INSERT INTO users (email, password, first_name, last_name, role, specialty, city) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $email, $password, $first_name, $last_name, $role, $specialty, $city);
    if ($stmt->execute()) {
      echo '<div class="alert alert-success">Акаунтът е създаден успешно!</div>';
    } else {
      echo '<div class="alert alert-danger">Грешка при създаване на акаунта!</div>';
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Tables - Basic Tables | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
      rel="stylesheet"
    />
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">ПО СЪЩЕСТВО</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="admin-dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Начало</div>
              </a>
            </li>
            <!-- Forms & Tables -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Страници</span></li>
            <!-- Forms -->
            <!-- Tables -->
            <li class="menu-item active">
              <a href="admins.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tables">Екип</div>
              </a>
            </li>
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Информация</span></li>
            <li class="menu-item">
              <a
                href="support.php"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Поддръжка</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="documentation.php"
                class="menu-link"
              >
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Документация</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
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
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Клуб по програмиране "По същество" |</span> Екип</h4>

              <hr class="my-5" />

              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'owner'): ?>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
                  <i class="bx bx-plus"></i> Създай акаунт
                </button>
              <?php endif; ?>

              <!-- Modal -->
              <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <form method="post" autocomplete="off">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Създай акаунт</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Затвори"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <label for="email" class="form-label">Имейл</label>
                          <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Парола</label>
                          <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                          <label for="first_name" class="form-label">Име</label>
                          <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="mb-3">
                          <label for="last_name" class="form-label">Фамилия</label>
                          <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="mb-3">
                          <label for="role" class="form-label">Роля</label>
                          <select class="form-select" name="role" required>
                            <option value="admin">Админ</option>
                            <option value="owner">Собственик</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="specialty" class="form-label">Специалност</label>
                          <select id="specialty" name="specialty" class="form-select" required>
                            <option value="">Избери...</option>
                            <option value="Web Developer">Web Developer</option>
                            <option value="Frontend Developer">Frontend Developer</option>
                            <option value="Backend Developer">Backend Developer</option>
                            <option value="Mobile Developer">Mobile Developer</option>
                            <option value="UI/UX Designer">UI/UX Designer</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Project Manager">Project Manager</option>
                            <option value="QA Tester">QA Tester</option>
                            <option value="DevOps">DevOps</option>
                            <option value="Data Scientist">Data Scientist</option>
                            <option value="Other">Друго</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Затвори</button>
                        <button type="submit" class="btn btn-primary">Създай</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              
              <!-- Responsive Table -->
              <div class="card">
                <h5 class="card-header">Членове на екипа</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr class="text-nowrap">
                        <th>ID</th>
                        <th>Име</th>
                        <th>Фамилия</th>
                        <th>Имейл</th>
                        <th>Роля</th>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'owner'): ?>
                          <th>Действия</th>
                        <?php endif; ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $result = $conn->query("SELECT id, first_name, last_name, email, role FROM users ORDER BY id ASC");
                      if ($result) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<tr>
                            <th scope='row'>{$row['id']}</th>
                            <td>" . htmlspecialchars($row['first_name']) . "</td>
                            <td>" . htmlspecialchars($row['last_name']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['role']) . "</td>";
                          if (isset($_SESSION['role']) && $_SESSION['role'] === 'owner') {
                            echo "<td>
                              <form method='post' action='delete_user.php' onsubmit=\"return confirm('Сигурен ли си, че искаш да изтриеш този потребител?');\">
                                <input type='hidden' name='user_id' value='{$row['id']}'>
                                <button type='submit' class='btn btn-danger btn-sm'>Изтрий</button>
                              </form>
                            </td>";
                          }
                          echo "</tr>";
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
