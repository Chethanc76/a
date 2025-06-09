<?php include 'header.php'; ?>


<div class="container" style="max-width: 500px; margin-top: 50px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Card Start -->
            <div class="card" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); background-color:rgb(252, 233, 139); padding: 20px;">
                <div class="card-body">
                    <h4 class="text-center mb-4">Login</h4>

                    <?php

                    if (isset($_SESSION['success_message'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                        unset($_SESSION['success_message']);
                    }

                    if (isset($_SESSION['error_message'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                        unset($_SESSION['error_message']); 
                    }
                    ?>

                    <form method="POST" action="login_process.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                   
                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="register">Register here</a></p>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
