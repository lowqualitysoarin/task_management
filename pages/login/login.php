<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Login</title>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>
    <!-- ========== signin-section start ========== -->
    <div class="container-fluid g-0 vh-100 d-flex flex-column">
        <div class="row g-0 auth-row vh-100">
            <div class="col-lg-6">
                <div class="auth-cover-wrapper bg-primary-100">
                    <div class="auth-cover">
                        <div class="title text-center">
                            <h1 class="text-primary mb-10">Welcome Back</h1>
                            <p class="text-medium">
                                Sign in to your Existing account to continue
                            </p>
                        </div>
                        <div class="cover-image">
                            <img src="../../assets/images/auth/signin-image.svg" alt="" />
                        </div>
                        <div class="shape-image">
                            <img src="../../assets/images/auth/shape.svg" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6 align-items-center justify-content-center d-flex">
                <div class="signin-wrapper">
                    <div class="form-wrapper">
                        <h6 class="mb-15">Login Page</h6>
                        <p class="text-sm mb-25">
                            Start creating the best possible user experience for you
                            customers.
                        </p>


                        <form action="ctrlData/ctrl.login.php" method="POST">

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control"
                                            placeholder="Username" />
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->


                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="*********" />
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-12">
                                <div class="button-group d-flex justify-content-center flex-wrap">
                                    <button type="submit" name="submit"
                                        class="main-btn primary-btn btn-hover w-100 text-center">Login</button>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>

                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== signin-section end ========== -->

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>