<?php require_once "../../includes/conn.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Edit User</title>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>
    <?php include_once "../../includes/components/preloader.php"; ?>

    <?php include_once "../../includes/elements/sidebar.php"; ?>
    <?php
    if (!isset($_GET['user_id'])) {
        header("location: list.user.php");
        exit();
    }

    $user_id = $_GET['user_id'];

    $select_user = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
    $user = mysqli_fetch_array($select_user);
    ?>

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Edit User</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="../dashboard/dashboard.php">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Edit User
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== title-wrapper end ========== -->

                <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>" class="form-elements wrapper" method="POST">
                    <div class="form-elements-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- input style start -->
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Profile</h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-style-1">
                                                <label>Full Name</label>
                                                <input type="text" placeholder="Full Name" name="fullname" value="<?php echo $user['full_name']; ?>" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-style-1">
                                                <label>Username</label>
                                                <input type="text" placeholder="Username" name="username" value="<?php echo $user['username']; ?>" required/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-style-1">
                                                <label>Email</label>
                                                <input type="email" placeholder="Email" name="email" value="<?php echo $user['email']; ?>" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-style-1">
                                                <label>Password</label>
                                                <input type="password" placeholder="Password" name="password" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-25">Role</h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check radio-style mb-20">
                                                <input class="form-check-input" type="radio" value="1" id="roleradio-1" name="role"
                                                <?php if ($user['role'] == 1) echo "checked"; ?> required/>
                                                <label class="form-check-label" for="roleradio-1">
                                                    Admin</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check radio-style mb-20">
                                                <input class="form-check-input" type="radio" value="2" id="roleradio-2" name="role" 
                                                <?php if ($user['role'] == 2) echo "checked"; ?> required/>
                                                <label class="form-check-label" for="roleradio-2">
                                                    Member</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" style="height: 50px;"
                                                class="btn btn-primary" name="submit">Update    
                                                User</button>
                                        </div>
                                    </div>
                                    <!-- end input -->
                                </div>
                                <!-- end card -->
                                <!-- ======= input style end ======= -->
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </form>
                <!-- end input -->
            </div>
            <!-- End Row -->
            </div>
            <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <!-- ======== main-wrapper end =========== -->

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>