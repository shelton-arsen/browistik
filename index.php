<?php
// Простая главная страница без обработки форм
// Обработка AJAX запросов происходит в ajax/callback.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browistik - Профессиональное оформление бровей и ресниц</title>
    <meta name="description" content="Профессиональное оформление бровей и ресниц. Современные техники, качественные материалы, индивидуальный подход к каждому клиенту.">
    <meta name="keywords" content="брови, ресницы, оформление бровей, наращивание ресниц, коррекция бровей">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Browistik - Профессиональное оформление бровей и ресниц">
    <meta property="og:description" content="Создаем идеальные брови и ресницы для вашего неповторимого образа">
    <meta property="og:image" content="/uploads/2025-09-15 22.07.13.jpg">
    <meta property="og:type" content="website">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104232256', 'ym');

    ym(104232256, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/104232256" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-content">
            <div class="preloader-logo">Browistik</div>
            <div class="preloader-spinner"></div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <h1 class="logo">Browistik</h1>
                </div>
                <div class="nav-menu">
                    <a href="#home" class="nav-link">Главная</a>
                    <a href="#services" class="nav-link">Услуги</a>
                    <a href="#gallery" class="nav-link">Галерея</a>
                    <a href="#about" class="nav-link">Обо мне</a>
                    <a href="#contact" class="nav-link">Контакты</a>
                </div>
                <div class="nav-contact">
                    <a href="tel:+375291801121" class="phone-link">
                        <i class="fas fa-phone"></i>
                        <span class="phone-text">+375 29 180-11-21</span>
                    </a>
                    <button class="callback-btn" onclick="openCallbackModal()">
                        Обратный звонок
                    </button>
                </div>
                <div class="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu">
        <a href="#home" class="nav-link">Главная</a>
        <a href="#services" class="nav-link">Услуги</a>
        <a href="#gallery" class="nav-link">Галерея</a>
        <a href="#about" class="nav-link">Обо мне</a>
        <a href="#contact" class="nav-link">Контакты</a>
    </div>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-background">
            <div class="hero-gradient"></div>
            <div class="floating-elements">
                <div class="floating-element"></div>
                <div class="floating-element"></div>
                <div class="floating-element"></div>
            </div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="title-line">Идеальные</span>
                        <span class="title-line highlight">брови</span>
                        <span class="title-line">для вашего образа</span>
                    </h1>
                    <p class="hero-subtitle">
                        Профессиональное оформление бровей и ресниц с использованием современных техник и премиальных материалов
                    </p>
                    <div class="hero-buttons">
                        <button class="btn btn-primary" onclick="openCallbackModal()">
                            <i class="fas fa-phone"></i>
                            Записаться на процедуру
                        </button>
                        <a href="#gallery" class="btn btn-secondary">
                            <i class="fas fa-images"></i>
                            Посмотреть работы
                        </a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="hero-image-wrapper">
                        <img src="uploads/me2.jpg" alt="Профессиональное оформление бровей" class="hero-img">
                        <div class="hero-image-decoration"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Мои услуги</h2>
                <p class="section-subtitle">Профессиональный уход за бровями</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="service-title">Архитектура бровей</h3>
                    <p class="service-description">
                        Создание идеальной формы бровей с учетом особенностей вашего лица.
                    </p>
                    <div class="service-price">20 руб</div>
                </div>
                
                <div class="service-card featured">
                    <div class="service-badge">Хит</div>
                    <div class="service-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <h3 class="service-title">Долговременная укладка бровей</h3>
                    <p class="service-description">
                        Современная процедура, которая делает брови послушными и идеально уложенными на 4-6 недель.
                    </p>
                    <div class="service-price">40 руб</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3 class="service-title">Окрашивание + коррекция бровей</h3>
                    <p class="service-description">
                        Профессиональное окрашивание краской для создания насыщенного и стойкого цвета с коррекцией формы.
                    </p>
                    <div class="service-price">25 руб</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-eye-dropper"></i>
                    </div>
                    <h3 class="service-title">Окрашивание ресниц</h3>
                    <p class="service-description">
                        Профессиональное окрашивание ресниц для создания выразительного взгляда и подчеркивания естественной красоты.
                    </p>
                    <div class="service-price">10 руб</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3 class="service-title">Комплексный уход</h3>
                    <p class="service-description">
                        Полный комплекс процедур для бровей со скидкой. Идеально для особых случаев.
                    </p>
                    <div class="service-price">60 руб</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Мои работы</h2>
                <p class="section-subtitle">Результаты, которыми я горжусь</p>
            </div>
            <!-- Фильтры временно отключены
            <div class="gallery-filter">
                <button class="filter-btn active" data-filter="all">Все работы</button>
                <button class="filter-btn" data-filter="brows">Брови</button>
            </div>
            -->
            <div class="gallery-grid">
                <?php
                $images = glob('uploads/*.jpg');
                // Исключаем me2.jpg из галереи работ
                $images = array_filter($images, function($image) {
                    return basename($image) !== 'me2.jpg';
                });
                // Категории временно отключены - можно восстановить при необходимости
                // $categories = ['brows', 'brows', 'brows', 'brows', 'brows', 'brows', 'brows', 'brows', 'brows'];
                foreach ($images as $index => $image) {
                    // $category = $categories[$index % count($categories)];
                    echo '<div class="gallery-item">'; // data-category="' . $category . '"
                    echo '<div class="gallery-image-wrapper">';
                    echo '<img src="' . $image . '" alt="Работа мастера" class="gallery-image">';
                    echo '<div class="gallery-overlay">';
                    echo '<button class="gallery-btn" onclick="openImageModal(\'' . $image . '\')">';
                    echo '<i class="fas fa-search-plus"></i>';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <div class="section-header">
                        <h2 class="section-title">Обо мне</h2>
                        <p class="section-subtitle">Профессиональный мастер с многолетним опытом</p>
                    </div>
                    <div class="about-description">
                        <p>
                            Меня зовут Соня, я дипломированный специалист и просто ваша бровная фея! 
                            Моя страсть — создавать идеальные брови, которые подчеркнут естественную красоту и индивидуальность каждой девушки.
                        </p>
                        <p>
                            Я постоянно совершенствую свои навыки, изучаю новые техники и работаю только с качественными материалами. 
                            Для меня важно, чтобы каждая клиентка чувствовала себя особенной и уходила довольной результатом.
                        </p>
                    </div>
                    <div class="about-achievements">
                        <div class="achievement">
                            <div class="achievement-number">300+</div>
                            <div class="achievement-text">Довольных клиенток</div>
                        </div>
                        <div class="achievement">
                            <div class="achievement-number">3</div>
                            <div class="achievement-text">Года опыта</div>
                        </div>
                        <div class="achievement">
                            <div class="achievement-number">5</div>
                            <div class="achievement-text">Сертификатов</div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="about-image-wrapper">
                        <img src="uploads/2025-09-15 22.09.30.jpg" alt="Мастер за работой" class="about-img">
                        <div class="about-decoration"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Контакты</h2>
                <p class="section-subtitle">Свяжитесь со мной удобным способом</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Телефон</h4>
                            <a href="tel:+375291801121">+375 29 180-11-21</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fab fa-telegram"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Telegram</h4>
                            <a href="https://t.me/sheltonkaa" target="_blank">@sheltonkaa</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Instagram</h4>
                            <a href="https://instagram.com/browistika__" target="_blank">@browistika__</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Режим работы</h4>
                            <p>Пн-Пт: 16:00 - 21:00<br>Сб-Вс: 11:00 - 21:00</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form-wrapper">
                    <h3>Записаться на процедуру</h3>
                    <p>Оставьте заявку, и я свяжусь с вами в течение 15 минут</p>
                    <button class="btn btn-primary btn-full" onclick="openCallbackModal()">
                        <i class="fas fa-phone"></i>
                        Заказать обратный звонок
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3 class="footer-logo">Browistik</h3>
                    <p>Создаем идеальные брови для вашего неповторимого образа</p>
                </div>
                <div class="footer-links">
                    <h4>Услуги</h4>
                    <ul>
                        <li><a href="#services">Архитектура бровей</a></li>
                        <li><a href="#services">Долговременная укладка</a></li>
                        <li><a href="#services">Окрашивание + коррекция</a></li>
                        <li><a href="#services">Окрашивание ресниц</a></li>
                        <li><a href="#services">Комплексный уход</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Контакты</h4>
                    <p><a href="tel:+375291801121">+375 29 180-11-21</a></p>
                    <div class="footer-social">
                        <a href="https://instagram.com/browistika__" class="social-link" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://t.me/sheltonkaa" class="social-link" target="_blank"><i class="fab fa-telegram"></i></a>
                        <a href="viber://chat?number=%2B375291801121" class="social-link" target="_blank"><i class="fab fa-viber"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Browistik. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <!-- Callback Modal -->
    <div id="callbackModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Заказать обратный звонок</h3>
                <button class="modal-close" onclick="closeCallbackModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="callbackForm" method="POST">
                    <div class="form-group">
                        <label for="name">Ваше имя</label>
                        <input type="text" id="name" name="name" placeholder="Как к вам обращаться?">
                    </div>
                    <div class="form-group">
                        <label for="phone">Номер телефона *</label>
                        <input type="tel" id="phone" name="phone" placeholder="+375 (__) ___-__-__" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-phone"></i>
                            Заказать звонок
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeCallbackModal()">
                            Отмена
                        </button>
                    </div>
                    <p class="form-note">
                        * Нажимая кнопку, вы соглашаетесь на <a href="privacy-policy.txt" target="_blank">обработку персональных данных</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="modal image-modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeImageModal()">&times;</button>
            <img id="modalImage" src="" alt="Увеличенное изображение">
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>

