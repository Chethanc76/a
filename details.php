<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';

if (!isset($_GET['product_id'])) {
    die("Invalid Product!");
}

$product_id = intval($_GET['product_id']);

// Fetch Product Details
$sql = "SELECT * FROM modern_new_products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found!");
}

$product = $result->fetch_assoc();

define('ENCRYPTION_KEY', 'your-32-char-random-string-here123456');

function decryptData($ciphertext_base64) {
    $key = ENCRYPTION_KEY;
    $c = base64_decode($ciphertext_base64);
    if ($c === false) return null;
    
    $ivlen = openssl_cipher_iv_length("AES-256-CBC");
    $iv = substr($c, 0, $ivlen);
    $ciphertext_raw = substr($c, $ivlen);
    
    $original_plaintext = openssl_decrypt($ciphertext_raw, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);
    return $original_plaintext;
}

$sensor_sql =  "SELECT ph, timestamp FROM modern_new_data ORDER BY timestamp DESC";

$stmt = $conn->prepare($sensor_sql);
$stmt->execute();
$sensor_result = $stmt->get_result();

// Continue your code to display or process $sensor_result
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['title']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
           
          background: linear-gradient(135deg, #f2d7d5, #fad0c4, #f7a1b5, #e8c1d5) !important;
            font-family: 'Arial', sans-serif;
           
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
        }

        .product-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .product-description {
            font-size: 16px;
            color: black;
          
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 24px;
            color: #008000;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-image {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .btn-primary, .btn-secondary {
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
             border:none;
            font-weight: bold;
           color:white;
        }

        .btn-primary:hover {
            background-color: black !important;
           border:none;
            font-weight: bold;
           color:white;
        }

        .btn-secondary {
            background-color: #6c757d;
            border:none;
            font-weight: bold;
           color:white;
        }

        .btn-secondary:hover {
             background-color: orange !important;
           border:none;
            font-weight: bold;
           color:white;
        }

        .table {
            background-color: white!important;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: blue !important;
            color: white;
            text-align: center;
             font-weight: bold;
            padding: 15px;
        }

        .table td {
            text-align: center;
            background-color: white !important;
            color: black;
            font-weight: bold;
            padding: 10px;
        }

       

        .table-bordered {
            border: none;
        }

        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="product-card">
                    <img src="./admin/<?php echo htmlspecialchars($product['image_path']); ?>" class="product-image" alt="Product Image">
                </div>
            </div>
            <div class="col-md-7">
                <div class="product-title"><?php echo htmlspecialchars($product['title']); ?></div>
                <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <div class="product-price">Price: ₹<?php echo number_format($product['price'], 2); ?></div>

                <div class="d-flex mt-3">
                    <form method="POST" class="me-2">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                    </form>

                    <a href="index" class="btn btn-secondary">Back to Products</a>
                </div>
            </div>
        </div>

       
        <h3 class="mt-5 text-center">Real-Time Sensor Data</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                       
                        <th>PH</th>
                        <th>Recorded Date</th>
                    </tr>
                </thead>
               <tbody>
<?php 
while ($row = $sensor_result->fetch_assoc()) { 
    $decryptedPh = decryptData($row['ph']);
    
    // Debug output
    if ($decryptedPh === null || $decryptedPh === false || $decryptedPh === '') {
        // Show raw encrypted data for debugging
        $debug = htmlspecialchars($row['ph']);
        $decryptedPh = "No Data (Encrypted: $debug)";
    }
?>
<tr>
    <td><?php echo $decryptedPh; ?></td>
    <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
</tr>
<?php } ?>
</tbody>

            </table>
        </div>
    </div>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    if (!isset($_SESSION['user_id'])) {

    echo "<script>alert('You need to login first!'); window.location='login';</script>";
    exit(); 
}

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Check if the product is already in the cart
    $check_cart_sql = "SELECT * FROM modern_new_cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_cart_sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Product already added to cart'); window.location='cart';</script>";
    } else {
        // Add product to cart
        $add_cart_sql = "INSERT INTO modern_new_cart (user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($add_cart_sql);
        $stmt->bind_param("ii", $user_id, $product_id);

        if ($stmt->execute()) {
            echo "<script>alert('Product added to cart'); window.location='cart';</script>";
        } else {
            echo "<script>alert('Failed to add to cart');</script>";
        }
    }
    $stmt->close();
    $conn->close();
}
?>
