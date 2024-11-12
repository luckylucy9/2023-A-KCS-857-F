<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle rental booking here
    $car_id = $_POST['car_id'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $rental_date = $_POST['rental_date'];
    $return_date = $_POST['return_date'];

    // Connect to database
    $conn = new mysqli('localhost', 'root', '', 'car_rental');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Calculate the total price
    $sql = "SELECT car_price FROM cars WHERE car_id = $car_id";
    $result = $conn->query($sql);
    $car = $result->fetch_assoc();
    $car_price = $car['car_price'];
    $rental_days = (strtotime($return_date) - strtotime($rental_date)) / (60 * 60 * 24);
    $total_price = $rental_days * $car_price;

    // Insert customer data into the rentals table
    $stmt = $conn->prepare("INSERT INTO rentals (customer_id, car_id, rental_date, return_date, total_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissd", $customer_id, $car_id, $rental_date, $return_date, $total_price);
    $stmt->execute();

    // Redirect or show confirmation
    echo "<h3>Rental Confirmed! Total Price: $" . $total_price . "</h3>";

    $conn->close();
} else {
    // Show rental form
    $car_id = $_GET['car_id']; // Get car id from the URL
    echo '
    <div class="container mt-4">
        <h2>Rent a Car</h2>
        <form action="" method="POST">
            <input type="hidden" name="car_id" value="' . $car_id . '">
            <div class="form-group">
                <label for="customer_name">Your Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="rental_date">Rental Date</label>
                <input type="date" class="form-control" id="rental_date" name="rental_date" required>
            </div>
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Confirm Rental</button>
        </form>
    </div>';
}
?>
