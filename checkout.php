<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to proceed.'); window.location='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

define('ENCRYPTION_KEY', '78ct8RYGMsOKtNvB');

function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY, true);
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY, true);
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}

// Fetch user details
$user_sql = "SELECT name, phone_number, address FROM modern_new_users WHERE id = ?";
$stmt = $conn->prepare($user_sql);
$user = ['name' => '', 'phone_number' => '', 'address' => ''];

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    }
    $stmt->close();
}

// Fetch cart items
$cart_sql = "SELECT c.id as cart_id, p.id as product_id, p.title, p.price, p.image_path 
             FROM modern_new_cart c 
             JOIN modern_new_products p ON c.product_id = p.id 
             WHERE c.user_id = ?";
$stmt = $conn->prepare($cart_sql);
$cart_items = [];
$total_price = 0;

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_price += $row['price'];
    }
    $stmt->close();
}

// Handle order submission
// Handle order submission
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = isset($_POST['card_number']) ? trim($_POST['card_number']) : '';
    $expiry_date = isset($_POST['expiry_date']) ? trim($_POST['expiry_date']) : '';
    $cvv = isset($_POST['cvv']) ? trim($_POST['cvv']) : '';

    if (empty($user['address'])) {
        $errors['address'] = "Please enter your address.";
    }

    // Card validation
    if (empty($card_number) || empty($expiry_date) || empty($cvv)) {
        $errors['payment'] = "Please provide valid card details.";
    } else {
        if (!preg_match('/^\d{16}$/', $card_number)) {
            $errors['card_number'] = "Card number must be 16 digits.";
        }

        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry_date)) {
            $errors['expiry_date'] = "Expiry date must be in MM/YY format.";
        }

        if (!preg_match('/^\d{3}$/', $cvv)) {
            $errors['cvv'] = "CVV must be 3 digits.";
        }

        if (empty($errors)) {
            $order_sql = "INSERT INTO modern_new_orders (user_id, total_price, name, address, phone, payment_method, status, created_at) 
                          VALUES (?, ?, ?, ?, ?, 'Credit/Debit Card', 'Pending', NOW())";
            $stmt = $conn->prepare($order_sql);

            if ($stmt) {
                $stmt->bind_param("idsss", $user_id, $total_price, $user['name'], $user['address'], $user['phone_number']);
                if ($stmt->execute()) {
                    $order_id = $stmt->insert_id;
                    $_SESSION['order_id'] = $order_id;
                    // Insert order items
                    foreach ($cart_items as $item) {
                        $order_item_sql = "INSERT INTO modern_new_order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, 1)";
                        $stmt = $conn->prepare($order_item_sql);
                        if ($stmt) {
                            $stmt->bind_param("iid", $order_id, $item['product_id'], $item['price']);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }

                   
                    $payment_method = 'Credit/Debit Card';
                    
                    // Encrypt the card details first
                    $encrypted_card_number = encryptData($card_number);
                    $encrypted_expiry_date = encryptData($expiry_date);
                    $encrypted_cvv = encryptData($cvv);
                    
                    // Prepare the SQL statement
                    $payment_sql = "INSERT INTO modern_new_payment_details (order_id, card_number, expiry_date, cvv, payment_method) 
                                    VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($payment_sql);
                    
                    if ($stmt) {
                        // Bind parameters: "i" for order_id (integer), "b" for varbinary data, and "s" for payment_method (string)
                        $stmt->bind_param("issss", $order_id, $encrypted_card_number, $encrypted_expiry_date, $encrypted_cvv, $payment_method);
                        $stmt->execute();
                        $stmt->close();
                    }


                    // Clear cart
                    $clear_cart_sql = "DELETE FROM modern_new_cart WHERE user_id = ?";
                    $stmt = $conn->prepare($clear_cart_sql);
                    if ($stmt) {
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $stmt->close();
                    }

                    echo "<script>alert('Order placed successfully!'); window.location='order_success';</script>";
                    exit();
                } else {
                    echo "<script>alert('Order failed. Please try again.');</script>";
                }
            }
        }
    }
}




$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
      
       
 body {
          
            background: linear-gradient(135deg, #F8BBD0, #9C27B0); 
 }
        input.invalid {
            border: 2px solid red;
        }

        .error-message {
            color: red;
            font-size: 18px;
        }

    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center mb-4">🛒 Checkout</h2>

        <div class="row g-3">
            <!-- Order Summary - Left Column -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white text-center">
                        Order Summary
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($cart_items as $item) : ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                    <span>₹<?php echo number_format($item['price'], 2); ?></span>
                                </li>
                            <?php endforeach; ?>
                            <li class="list-group-item d-flex justify-content-between fw-bold bg-light">
                                Total
                                <span>₹<?php echo number_format($total_price, 2); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- User Details - Center Column -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white text-center">
                        User Details
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></li>
                            <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></li>
                            <li class="list-group-item"><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment Details - Right Column -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header bg-warning text-dark text-center">
                        Payment Method
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div id="card_details" class="mt-3">
                                <h6 class="text-primary">Card Details</h6>
                                <div class="mb-2">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" value="<?php echo isset($card_number) ? htmlspecialchars($card_number) : ''; ?>">
                                    <?php if (isset($errors['card_number'])): ?>
                                        <div class="error-message"><?php echo $errors['card_number']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY" value="<?php echo isset($expiry_date) ? htmlspecialchars($expiry_date) : ''; ?>">
                                    <?php if (isset($errors['expiry_date'])): ?>
                                        <div class="error-message"><?php echo $errors['expiry_date']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">CVV</label>
                                    <input type="password" name="cvv" class="form-control" placeholder="123" value="<?php echo isset($cvv) ? htmlspecialchars($cvv) : ''; ?>">
                                    <?php if (isset($errors['cvv'])): ?>
                                        <div class="error-message"><?php echo $errors['cvv']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (isset($errors['payment'])): ?>
                                <div class="error-message"><?php echo $errors['payment']; ?></div>
                            <?php endif; ?>

                            <button type="submit" class="btn btn-success w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
