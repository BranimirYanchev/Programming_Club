<?php
require_once 'db.php';
session_start();

$upload_dir = __DIR__ . '/avatars/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$first_name = '';
$last_name = '';
$email = '';
$age = '';
$phone = '';
$city = '';
$avatar = 'assets/avatar.png';
$specialty = '';
$bio = '';

if (isset($_SESSION['email'])) {
    $stmt = $conn->prepare("SELECT first_name, last_name, email, age, phone, city, avatar, specialty, bio FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name, $email, $age, $phone, $city, $avatar_db, $specialty_db, $bio_db);
    $stmt->fetch();
    $stmt->close();
    if ($avatar_db) $avatar = $avatar_db;
    if ($specialty_db) $specialty = $specialty_db;
    if ($bio_db) $bio = $bio_db;
}

// Обработка на формата
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
    $new_first_name = $_POST['firstName'];
    $new_last_name = $_POST['lastName'];
    $new_age = $_POST['age'];
    $new_email = $_POST['email'];
    $new_phone = $_POST['phoneNumber'];
    $new_city = $_POST['city'];
    $new_specialty = $_POST['specialty'];
    $new_bio = $_POST['bio'];

    if (isset($_POST['reset_avatar'])) {
        // Копира assets/avatar.png в avatars/ с ново име и записва линка
        $ext = pathinfo('assets/avatar.png', PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target_abs = $upload_dir . $filename;
        $target_rel = 'avatars/' . $filename;
        copy(__DIR__ . '/assets/avatar.png', $target_abs);
        $avatar_path = $target_rel;
    } elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target_abs = $upload_dir . $filename;
        $target_rel = 'avatars/' . $filename;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_abs)) {
            $avatar_path = $target_rel;
        } else {
            $avatar_path = $avatar_db ?: 'assets/avatar.png';
        }
    } else {
        $avatar_path = $avatar_db ?: 'assets/avatar.png';
    }

    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, age=?, email=?, phone=?, city=?, avatar=?, specialty=?, bio=? WHERE email=?");
    $stmt->bind_param("ssisssssss", $new_first_name, $new_last_name, $new_age, $new_email, $new_phone, $new_city, $avatar_path, $new_specialty, $new_bio, $_SESSION['email']);
    $stmt->execute();
    $stmt->close();

    $_SESSION['email'] = $new_email;
    header("Location: pages-account-settings-account.php?success=1");
    exit;
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

    <title>Account settings - Account | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
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
            <li class="menu-item">
              <a href="admins.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Tables">Екип</div>
              </a>
            </li>
            <li class="menu-item active">
              <a href="pages-account-settings-account.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Tables">Настройки</div>
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
                      <img src="<?php echo htmlspecialchars($avatar); ?>" alt="user-avatar" class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?php echo htmlspecialchars($avatar); ?>" alt="user-avatar" class="w-px-40 h-auto rounded-circle" />
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Клуб по програмиране "По същество" | </span> Настройки</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Профил</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-connections.php"
                        ><i class="bx bx-link-alt me-1"></i> Връзки</a
                      >
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Профил</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center gap-4 mb-4" style="align-items: flex-start;">
                          <div>
                            <img
                              src="<?php echo htmlspecialchars($avatar); ?>"
                              alt="user-avatar"
                              class="rounded-circle border"
                              style="width: 110px; height: 110px; object-fit: cover; margin-bottom: 8px;"
                              id="uploadedAvatar"
                            />
                          </div>
                          <div class="button-wrapper" style="margin-top: 10px;">
                            <label for="avatar" class="btn btn-primary me-2 mb-4" tabindex="0">
                              <span class="d-none d-sm-block">Upload new photo</span>
                              <i class="bx bx-upload d-block d-sm-none"></i>
                              <input
                                type="file"
                                id="avatar"
                                class="account-file-input"
                                hidden
                                accept="image/png, image/jpeg"
                                name="avatar"
                              />
                            </label>
                            <button type="submit" name="reset_avatar" value="1" class="btn btn-outline-secondary mb-4">
                              <i class="bx bx-reset d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                          </div>
                        </div>
                        <hr class="my-0" />
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Име</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName"
                              value="<?php echo htmlspecialchars($first_name); ?>"
                              autofocus
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Фамилия</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="<?php echo htmlspecialchars($last_name); ?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="age" class="form-label">Години</label>
                            <input class="form-control" type="number" name="age" id="age" value="<?php echo htmlspecialchars($age); ?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="<?php echo htmlspecialchars($email); ?>"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Телефонен номер</label>
                            <input
                              type="text"
                              id="phoneNumber"
                              name="phoneNumber"
                              class="form-control"
                              value="<?php echo htmlspecialchars($phone); ?>"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Град</label>
                            <input type="text" id="country" name="city" class="form-control" value="<?php echo htmlspecialchars($city); ?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="specialty" class="form-label">Специалност</label>
                            <select id="specialty" name="specialty" class="form-select">
                              <option value="">Избери...</option>
                              <option value="Web Developer" <?php if($specialty=="Web Developer") echo "selected"; ?>>Web Developer</option>
                              <option value="Frontend Developer" <?php if($specialty=="Frontend Developer") echo "selected"; ?>>Frontend Developer</option>
                              <option value="Backend Developer" <?php if($specialty=="Backend Developer") echo "selected"; ?>>Backend Developer</option>
                              <option value="Mobile Developer" <?php if($specialty=="Mobile Developer") echo "selected"; ?>>Mobile Developer</option>
                              <option value="UI/UX Designer" <?php if($specialty=="UI/UX Designer") echo "selected"; ?>>UI/UX Designer</option>
                              <option value="Marketing" <?php if($specialty=="Marketing") echo "selected"; ?>>Marketing</option>
                              <option value="Project Manager" <?php if($specialty=="Project Manager") echo "selected"; ?>>Project Manager</option>
                            </select>
                          </div>
                          <div class="mb-3 col-md-12">
                            <label for="bio" class="form-label">Биография</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($bio); ?></textarea>
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Запази</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
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
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
