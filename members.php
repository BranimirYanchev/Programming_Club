<?php
require_once 'db.php';

// Вземи всички членове от базата
$result = $conn->query("SELECT first_name, last_name, email, role, specialty, avatar FROM users");
?>

<!doctype html>
<html lang="en">
  <head>
 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<title>Клуб по програмиране "По същество" | Благоевград</title>
  	<meta name="description" content="">
  	<meta name="keywords" content="">

 <!-- Favicons -->
  <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">

  	<!-- Fonts -->
  	<link href="https://fonts.googleapis.com" rel="preconnect">
  	<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

  	<!-- Vendor CSS Files -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  	<link href="assets/vendor/aos/aos.css" rel="stylesheet">
  	<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  	<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  	<!-- Main CSS File -->
  	<link href="assets/css/main.css" rel="stylesheet">	
 	<link rel="stylesheet" href="assets/css/members.css">
  	<link rel="stylesheet" href="https://stsackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/members-animations.css">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/logo.png" alt="">
        <!-- <h1 class="sitename">Programming Club</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#hero" class="active">Начало</a></li>
          <li><a href="index.php#about">Информация</a></li>
          <li><a href="index.php#team">Създатели</a></li>
		      <li><a href="members.php">Членове</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="index.php#contact">Запиши се</a>

    </div>
  </header>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-wrap">
                    <table class="table table-responsive-xl">
                      <thead>
                        <tr>
                            <th><b>Снимка:</b></th>
                        	<th><b>Име:</b></th>
                        	<th><b>Имейл:</b></th>
                        	<th><b>Позиция:</b></th>
                        	<th><b>Специалност:</b></th>
                            <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="alert" role="alert">
                            <td>
                                <div class="img" style="background-image: url(<?php echo htmlspecialchars($row['avatar'] ?: 'assets/avatar.png'); ?>);"></div>
                            </td>
                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                          	<td><?php echo htmlspecialchars($row['email']); ?></td>
                          	<td>
                                <?php
                                    if ($row['role'] === 'owner') {
                                        echo 'Собственик';
                                    } else {
                                        echo 'Член';
                                    }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['specialty']); ?></td>
								<td>
									<button class="more-btn" data-email="<?php echo htmlspecialchars($row['email']); ?>">
										<span style="color: white;" >Повече</span>
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 74 74" height="34" width="34">
											<circle stroke-width="3" stroke="white" r="35.5" cy="37" cx="37"></circle>
											<path fill="white" d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z"></path>
										</svg>
									</button>
								</td>
                        </tr>
                        <?php endwhile; ?>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

  <footer id="footer" class="footer">

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Клуб по програмиране "По същество"</strong> |<span> Всички права запазени!</span></p>
      <div class="credits">
      </div>
    </div>

  </footer>

    <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/members.js"></script>
  <script>
document.querySelectorAll('.more-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var email = btn.getAttribute('data-email');
        window.location.href = 'pofile-cv.php?email=' + encodeURIComponent(email);
    });
});
</script>
	</body>
</html>

