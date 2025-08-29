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
    <title>Документация | Sneat Admin</title>
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
            <li class="menu-item">
              <a href="support.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Поддръжка</div>
              </a>
            </li>
            <li class="menu-item active">
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Клуб по програмиране "По същество" |</span> Документация</h4>
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="card-title">Документация</h5>
                  <p class="card-text">
                    Добре дошъл в документацията на клуб по програмиране "По същество". Тук ще намериш информация за използване на платформата, ръководства, често задавани въпроси и полезни ресурси.
                  </p>
                  <hr>
                  <h5 class="mb-3">Идеология на Клуб по програмиране „По същество“ – Благоевград</h5>
                  <p>
                    Клубът „По същество“ е пространство за съзнателно действие чрез код. Вярваме, че стойността не произтича от институции, авторитети или състезания, а от приноса, от разбирането и от желанието да сътворяваш нещо, което има реално значение. Той е възможност за младите да изградят себе си, както и портфолио, което да ги направи конкурентноспособни на пазара на труда, докато активно допринасят към своята общност.
                  </p>
                  <h6>Принципи</h6>
                  <ol>
                    <li>В този клуб не чакаме покани, конкурси или одобрения. Когато някой види възможност за нещо смислено, той започва – събира съмишленици, формулира идея и я превръща в проект.</li>
                    <li>За нас стойността не е само „готов продукт“. Тя може да бъде идея, експеримент, ново разбиране – всичко, което носи промяна, макар и незавършено. Стойността е не само резултат, но и процес.</li>
                    <li>Вярваме в отговорността отвъд ролите. Всеки може да поеме инициатива, ако носи ясна визия и готовност да отговаря за изпълнението ѝ. В клуба няма титли – има доверие. А то се печели чрез принос и откритост към обратна връзка.</li>
                    <li>Теорията е практика. Питаме „защо“, преди „как“. Разговорите за код са и разговори за света, в който този код действа.</li>
                    <li>Равенство на възможността за участие. Решенията обаче се вземат на база тежестта на аргументите. Ценим експертизата, но не толерираме високомерие.</li>
                  </ol>
                  <h6>Цели и подход</h6>
                  <p>
                    Целите на клуба се извеждат от нуждите на средата и възможностите на участниците. Основната ни мисия е изграждане на действаща общност от млади разработчици, които работят по реални проекти, в реален контекст. Вярваме, че компетентност се изгражда чрез практика, а не чрез изолирана теоретична подготовка. Работим по проекти, които имат реална употреба и измерим резултат – независимо дали са образователни платформи, вътрешноучилищни системи, автоматизации или мобилни приложения. Всеки проект е възможност за професионално развитие, за портфолио, за референции и за връзки с други специалисти. Обучението се случва чрез взаимопомощ и споделяне на опит.
                  </p>
                  <h6>Организация и структура</h6>
                  <p>
                    „По същество“ е хоризонтален клуб. Всеки участник има право на глас и инициатива, но това право произтича от активния му принос. Няма фиксирани йерархии, но се разпределят временни отговорности за да се гарантира изпълнение. Координаторите не управляват, а синхронизират – те са временно избрани с консенсус и се грижат за логистиката на съвместната работа. Всички стратегически решения се обсъждат открито и се вземат чрез гласуване. Всеки може да предложи инициатива, ако е готов да поеме и отговорността за реализацията ѝ. Конфликтите се решават чрез ясно дефиниране на проблема, изслушване на аргументите и, при нужда, гласуване. Това не е административна структура, а етична общност, в която се действа с мисъл за общото и уважение към индивидуалното.
                  </p>
                  <h6>Етика на труда</h6>
                  <ul>
                    <li>Признателност към усилията на другите</li>
                    <li>Смелост за грешка, отговорност за наученото</li>
                    <li>Градивна критика</li>
                    <li>Свобода – не като свободия, а като съзнателен избор</li>
                    <li>Кодът е инструмент – ние сме майстори с отговорност към създаденото</li>
                  </ul>
                  <h6>Подход към проекти и технологии</h6>
                  <p>
                    Основната ни дейност е разработка на софтуер – с ясна цел и използваем краен резултат. Проектите, които поемаме, отговарят на три критерия: да има реална нужда от тях, да носят практическа полза и да могат да бъдат завършени за подходящо време с наличните ресурси. Не използваме технологии с учебна цел, а с цел функционалност. Езиците и инструментите се избират според нуждите на конкретния проект. Най-често използвани са JavaScript (уеб и мобилни приложения); Python (скриптове, автоматизация, анализ, AI); HTML/CSS (фронтенд); SQL (работа с данни); Java и C# (Android и десктоп/Unity разработка). Всеки проект включва самостоятелно решение за технологичен стек, архитектура и управление на версии чрез Git.
                  </p>
                  <h6>Участие и резултати</h6>
                  <p>
                    Участието в клуба води до конкретни резултати: практически опит, работа по реални проекти, портфолио с публични линкове, възможности за препоръки, участия в състезания и кандидатстване за стажове. Всеки допринася според възможностите и интересите си, но поел ангажимент, се очаква да го изпълни.
                  </p>
                  <h6>Съоснователи</h6>
                  <p>
                    Клубът е създаден от хора, които не приемат липсата на практика и екипност в образованието като даденост, а като предизвикателство за действие. Бранимир Янчев е разработчик и преподавател, автор на реални образователни приложения. Вярва, че кодът е инструмент. Спас Китанов е артист и уеб разработчик, който комбинира креативност и технологии. За него програмирането е форма на изграждане на среда – не просто на интерфейс.
                  </p>
                  <h6>Заключение</h6>
                  <p>
                    „По същество“ не е социална инициатива, а структурирана работна среда между връстници и приятели. Ние не чакаме промяна – създаваме я. Основата ни е проста: ако нещо трябва да се направи, правим го. Заедно, добре и навреме. Всяка инициатива започва от участници. Никой не „владее“ проект – всеки, който разбира приноса му, може да допринесе. Обратната връзка е не само право, но и отговорност. Критикуваме с цел подобрение, не за да демонстрираме надмощие. Хвалим, когато има какво да се научи, не от учтивост. Срещите са живи, разговорите – съществени. Говорим, когато има какво да се каже. Пишем, когато може да се подобри. Мълчим, когато е време да слушаме.
                  </p>
                  <hr>
                  <ul>
                    <li>Как да създадеш акаунт и да управляваш потребители</li>
                    <li>Как да използваш търсачката</li>
                    <li>Как да се свържеш с екипа за поддръжка</li>
                    <li>Как да разглеждаш и редактираш информация за екипа</li>
                  </ul>
                  <p class="mt-3">
                    Ако имаш въпрос, който не е описан тук, използвай страницата <a href="support.php">Поддръжка</a>.
                  </p>
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