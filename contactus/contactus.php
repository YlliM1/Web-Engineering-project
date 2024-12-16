<?php  

include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    
    $conn = new mysqli('localhost', 'root', '', 'shoe_shop');

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        
        $stmt = $conn->prepare("INSERT INTO contactform (firstName, lastName, email, phone, message) VALUES (?, ?, ?, ?, ?)");
        
        
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);  
        }

        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $message);
        
        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successfully!');</script>";
        } else {
            echo "Error while sending the message: " . $stmt->error; 
        }
        
        
        $stmt->close();
        $conn->close();
    }
}







    


   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContactUs</title>
    <link rel="stylesheet" href="../contactus/contactus.css">
</head>
<body>
    <div class ="contact-form">
        <h3>Let's Talk</h3>
        <form action ="contactus.php" method="POST">
            <div class="row">
                <div class="input-group">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName">
                </div>
            <div class="input-group">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName">
            </div>
            </div>

            <div class="row">
                <div class="input-group">
            <label for="email">Business Email</label>
            <input type="email" name="email" id="email">
            </div>
            <div class="input-group">
            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone">
            </div>
            </div>

            <label for="message">What Would You Like To Discuss ?</label> 
            <textarea id="message" name="message" rows="5" cols="40"></textarea>
        
           
            <button id="butoni" type="submit">Book a Meeting</button>
   
        </form>
    </div>
    
    
</body>
</html>