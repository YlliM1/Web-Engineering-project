<?php
session_start();

if (session_status() === PHP_SESSION_ACTIVE) {
    error_log("Session is active");
} else {
    error_log("Session is not active");
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: ../login/index.php');
    exit;
}

$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['first_name']);
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="../main-page/main-page.css">
    
</head>
<body>
    <section id="section-1">
        <div class="container">
            <header>
                <img src="" alt="logo">
                <nav>
                    <ul>
                        <li><a href="#">HOME</a></li>
                        <li><a href="#">ABOUT US</a></li>
                        <li><a href="#">SERVICES</a></li>
                        <li><a href="../contactus/contactus.html">CONTACT US</a></li>
                        <?php if ($isLoggedIn): ?>
                            <li class="user-menu" onclick="togglePopupMenu()">
                                <span class="nav-link nav-link-active"><?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                                <div class="popup-menu" id="popupMenu">
                                    <a href="../profile/profile.php">Profile</a>
                                    <a href="../logout.php">Logout</a>
                                </div>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="../login/index.php" class="nav-link nav-link-active">LOG IN</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </header>
        </div>
    </section>

    <section id="slider">
        <div class="slider">
            <div class="slides">
                <div class="slide">
                    <img src="../images/photo1.jpg" alt="Slide 1">
                </div>
                <div class="slide">
                    <img src="../images/photo2.jpg" alt="Slide 2">
                </div>
                <div class="slide">
                    <img src="../images/photo3.jpg" alt="Slide 3">
                </div>
            </div>
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <button class="next" onclick="nextSlide()">&#10095;</button>
            <div class="dots">
                <span class="dot" onclick="setCurrentSlide(0)"></span>
                <span class="dot" onclick="setCurrentSlide(1)"></span>
                <span class="dot" onclick="setCurrentSlide(2)"></span>
            </div>
        </div>
    </section>

    <hr style="width: 90%; margin-top: 40px;border:1px solid black;">

    <section id="cards">
        <div class="card1">
            <img class="card1-photo" src="../images/card1photo.png" alt="">
            <hr style="width: 90%; border: 1px solid rgba(128, 128, 128, 0.6);">
            <label for="">Nike "Black Smoke Gray"</label>
            <div class="button-container">
                <button class="buy-button-1">Buy Now</button>
            </div>
        </div>
        <div class="card2">
            <img class="card2-photo" src="../images/card2photo.png" alt="">
            <hr style="width: 90%; border: 1px solid rgba(128, 128, 128, 0.6)  ;">
            <label for="">Nike "Air Force 1 "</label>
            <div class="button-container">
                <button class="buy-button-1">Buy Now</button>
            </div>
        </div>
        <div class="card1">
            <img class="card1-photo" src="../images/card3photo.png" alt="">
            <hr style="width: 90%; border: 1px solid rgba(128, 128, 128, 0.6)  ;">
            <label for="">Jordan "Military Black"</label>
            <div class="button-container">
                <button class="buy-button-1">Buy Now</button>
            </div>
        </div>
        <div class="card1">
            <img class="card1-photo" src="../images/card4photo.png" alt="">
            <hr style="width: 90%; border: 1px solid rgba(128, 128, 128, 0.6)  ;">
            <label for="">Nike " Air Max "</label>
            <div class="button-container">
                <button class="buy-button-1">Buy Now</button>
            </div>
    </section>

    <script>
        function togglePopupMenu() {
            const popup = document.getElementById("popupMenu");
            if (popup.style.display === "block") {
                popup.style.display = "none";
            } else {
                popup.style.display = "block";
            }
        }

        document.addEventListener("click", function(event) {
            const popup = document.getElementById("popupMenu");
            const userMenu = document.querySelector(".user-menu");
            if (!userMenu.contains(event.target)) {
                popup.style.display = "none";
            }
        });

        let currentSlide = 0;
        function showSlide(index) {
            const slides = document.querySelectorAll(".slide");
            const dots = document.querySelectorAll(".dot");

            slides.forEach(slide => (slide.style.display = "none"));
            dots.forEach(dot => dot.classList.remove("active"));

            slides[index].style.display = "block";
            dots[index].classList.add("active");
        }

        function nextSlide() {
            const slides = document.querySelectorAll(".slide");
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            const slides = document.querySelectorAll(".slide");
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function setCurrentSlide(index) {
            currentSlide = index;
            showSlide(currentSlide);
        }

        showSlide(currentSlide);
    </script>
</body>
</html>
