<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to view your detection.'); window.location='login';</script>";
    exit();
}

// Your encryption key (must be same as used in encryptData)
define('ENCRYPTION_KEY', 'your-32-char-random-string-here123456');

// Decrypt function (must exactly match your encryption)
function decryptData($ciphertext_base64) {
    $key = ENCRYPTION_KEY;
    $c = base64_decode($ciphertext_base64);
    if ($c === false) return null; // invalid base64
    
    $ivlen = openssl_cipher_iv_length("AES-256-CBC");
    $iv = substr($c, 0, $ivlen);
    $ciphertext_raw = substr($c, $ivlen);
    
    $original_plaintext = openssl_decrypt($ciphertext_raw, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);
    return $original_plaintext;
}

// Fetch encrypted data directly, no AES_DECRYPT in SQL
$sql = "SELECT ph, timestamp FROM modern_new_data ORDER BY timestamp DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detection Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background-color: #007bff !important;
            color: white !important;
            font-weight: bold;
            text-align: center;
        }
        td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        #resultText {
            font-weight: bold;
        }
        .modal-header {
            background-color: #17a2b8;
            color: white;
        }
        .modal-body {
            background-color: #f8f9fa;
            color: #333;
            font-size: 18px;
        }
        .modal-footer {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center text-primary">Sensor Data</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>pH</th>
                <th>Recorded Date</th>
                <th>Check</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { 
                $decryptedPh = decryptData($row['ph']);
                if ($decryptedPh === null || $decryptedPh === false || $decryptedPh === '') {
                    $decryptedPh = "No Data";
                }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($decryptedPh); ?></td>
                <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                <td>
                    <button class="btn btn-success" onclick='checkOrganic(<?php echo json_encode($decryptedPh); ?>)'>Check</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Detection Result</h5>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
            <div class="modal-body">
                <p id="resultText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    function checkOrganic(ph) {
        let result = "Not Organic";
        const phNum = parseFloat(ph);
        if (!isNaN(phNum) && phNum >= 5.5 && phNum <= 7.5) {
            result = "Organic";
        }
        document.getElementById("resultText").innerText = "This data is classified as: " + result;
        var modal = new bootstrap.Modal(document.getElementById('resultModal'));
        modal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$result->free();
$conn->close();
?>
