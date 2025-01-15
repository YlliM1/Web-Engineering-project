<?php
session_start();

include_once '../config.php';

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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$shoesQuery = "SELECT * FROM shoes ORDER BY created_at DESC";
$result = $conn->query($shoesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="../main-page/main-page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <section id="section-1">
        <div class="container">
            <header>
                <img src="" alt="logo">
                <nav>
                    <ul>
                    <li><a href="/Web-Engineering-project/main-page/main-page.php">HOME</a></li>
                        <li><a href="/Web-Engineering-project/AboutUs/aboutUs.php">ABOUT US</a></li>
                        <li><a href="/Web-Engineering-project/Services/services.php">SERVICES</a></li>
                        <li><a href="/Web-Engineering-project/contactus/contactus.php">CONTACT US</a></li>
                        <?php if ($isLoggedIn): ?>
                        <li class="user-menu" onclick="togglePopupMenu()">
                            <span class="nav-link nav-link-active">
                                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['first_name']); ?>
                            </span>
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

    <hr style="width: 90%; margin-top: 40px; border: 1px solid black;">
    <?php if ($isAdmin): ?>
    <div class="add_shoes_button">
        <button onclick="toggleAddShoeModal()">&#43;</button>
    </div>

    <div id="addShoeModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="toggleAddShoeModal()">&times;</span>
            <form id="addShoeForm" action="add_shoe.php" method="POST" enctype="multipart/form-data">
                <label for="shoeName">Shoe Name:</label>
                <input type="text" id="shoeName" name="shoeName" required>

                <label for="shoePrice">Price:</label>
                <input type="number" id="shoePrice" name="shoePrice" required>

                <label for="shoeImage">Image:</label>
                <input type="file" id="shoeImage" name="shoeImage" accept="image/*" required>

                <button type="submit">Add Shoe</button>
            </form>
        </div>
    </div>

    <div id="editShoeModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('editShoeModal').style.display='none'">&times;</span>
        <form id="editShoeForm" method="POST">
            <input type="hidden" id="editShoeId" name="shoeId">
            <label for="editShoeName">Shoe Name:</label>
            <input type="text" id="editShoeName" name="shoeName" required>
            
            <label for="editShoePrice">Price:</label>
            <input type="number" id="editShoePrice" name="shoePrice" required>
            
            <button type="submit">Update Shoe</button>
        </form>
    </div>
</div>

    <?php endif; ?>

    <section id="cards">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card1">
                <?php if ($isAdmin): ?>
                        <div class="actions_buttons">
                            <button onclick="deleteShoe(<?php echo $row['id']; ?>)" class="shoes_delete_button"> <i class="fas fa-trash-alt"></i></button>
                            <button onclick="editShoe(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['name']); ?>', <?php echo $row['price']; ?>)" class="shoes_edit_button"> <i class="fas fa-pen"></i></button>
                        </div>
                <?php endif; ?>
                    <img class="card1-photo" src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="Shoe Image">
                    <hr style="width: 90%; border: 1px solid rgba(128, 128, 128, 0.6);">
                    <label for=""><?php echo htmlspecialchars($row['name']); ?></label>
                    <hr style="width: 90%; border: 1px solid rgba(128, 128, 128, 0.6);">
                    <label for="">$<?php echo number_format($row['price'], 2); ?></label>
                    <div class="button-container">
                        <button class="buy-button-1" onclick="buyShoe(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['name']); ?>')">Buy Now</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No shoes available.</p>
        <?php endif; ?>
    </section>
    <footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>We are a leading online shoe store offering a variety of stylish and comfortable footwear for all occasions. Quality and customer satisfaction are our top priorities.</p>
        </div>

        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: support@shoestore.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>Address: 123 Shoe St, Shoe City, SC</p>
        </div>

        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="/Web-Engineering-project/main-page/main-page.php">Home</a></li>
                <li><a href="/Web-Engineering-project/main-page/main-page.php">Shop</a></li>
                <li><a href="/Web-Engineering-project/AboutUs/aboutUs.php">About Us</a></li>
                <li><a href="/Web-Engineering-project/contactus/contactus.php">Contact Us</a></li>
                <li><a href="/Web-Engineering-project/Services/services.php">Services</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Follow Us</h3>
            <a href="#" target="_blank">
                <img src="../images/instagram-icon.png" alt="Instagram" class="social-icon">
            </a>
            <a href="#" target="_blank">
                <img src="../images/facebook-icon.png" alt="Facebook" class="social-icon">
            </a>
            <a href="#" target="_blank">
                <img src="../images/twitter-icon.png" alt="Twitter" class="social-icon">
            </a>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 ShoeStore. All rights reserved.</p>
    </div>
</footer>


    <script>

function buyShoe(shoeId, shoeName) {
    const data = {
        shoeName: shoeName,
    };

    fetch('/Web-Engineering-project/main-page/purchases/purchases.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); 
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the purchase.');
    });
}

function deleteShoe(shoeId) {
    const confirmation = confirm("Are you sure you want to delete this shoe?");
    if (!confirmation) return;

    fetch('/Web-Engineering-project/main-page/delete_shoe.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ shoeId: shoeId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload(); 
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the shoe.');
    });
}

function editShoe(shoeId, shoeName, shoePrice) {
    const modal = document.getElementById("editShoeModal");
    document.getElementById("editShoeId").value = shoeId;
    document.getElementById("editShoeName").value = shoeName;
    document.getElementById("editShoePrice").value = shoePrice;
    modal.style.display = "block";
}

document.getElementById("editShoeForm").addEventListener("submit", function(event) {
    event.preventDefault();  
    const shoeId = document.getElementById("editShoeId").value;
    const shoeName = document.getElementById("editShoeName").value;
    const shoePrice = document.getElementById("editShoePrice").value;

    const data = {
        shoeId: shoeId,
        shoeName: shoeName,
        shoePrice: shoePrice
    };

    fetch('/Web-Engineering-project/main-page/edit_shoe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the shoe.');
    });
});



        function toggleAddShoeModal() {
            const modal = document.getElementById("addShoeModal");
            modal.style.display = modal.style.display === "none" ? "block" : "none";
        }

        window.onclick = function(event) {
            const modal = document.getElementById("addShoeModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        function togglePopupMenu() {
            const popup = document.getElementById("popupMenu");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
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

<?php $conn->close(); ?>
