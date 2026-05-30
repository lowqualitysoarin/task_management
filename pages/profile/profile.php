<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Profile</title>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>
    <?php include_once "../../includes/components/preloader.php"; ?>

    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <?php
        $user_id = $_GET['user_id'];
        if (!isset($user_id)) {
            header("Location: ../dashboard/dashboard.php");
            exit();
        }

        $select_user = mysqli_query($conn, "SELECT * FROM users_tbl LEFT JOIN roles_tbl on users_tbl.role = roles_tbl.role_id WHERE user_id = '$user_id'");
        $user = mysqli_fetch_array($select_user);
        ?>

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Profile</h2>
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
                                            Profile
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
                <div class="row">
                    <div class="card-style settings-card-1 mb-30">
                        <div class="title mb-30 d-flex justify-content-between align-items-center">
                            <h6><?php echo $user['full_name'] . "'s"; ?> Profile</h6>
                            <?php
                            if ($user['user_id'] == $_SESSION['user_id']) {
                                ?>
                                <a class="border-0 bg-transparent text-black"
                                    href="../users/edit.user.php?user_id=<?php echo $user['user_id']; ?>">
                                    <i class="lni lni-pencil-alt"></i>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="profile-info">
                            <div class="d-flex align-items-center mb-30">
                                <img class="profile-image"
                                    src="<?php echo get_user_profile_image($conn, $user['user_id']); ?>"
                                    alt="<?php echo $user['full_name']; ?>" />
                                <div class="profile-meta">
                                    <h5 class="text-bold text-dark mb-10"><?php echo $user['full_name']; ?></h5>
                                    <p class="text-sm text-gray"><?php echo $user['role']; ?></p>
                                </div>
                            </div>
                            <div class="input-style-1">
                                <label>Username</label>
                                <input type="text" value="<?php echo $user['username']; ?>" readonly />
                            </div>
                            <div class="input-style-1">
                                <label>Email</label>
                                <input type="email" value="<?php echo $user['email']; ?>" readonly />
                            </div>
                            <div class="input-style-1">
                                <label>Bio</label>
                                <textarea rows="4" readonly>
                                    <?php echo $user['bio']; ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <!-- End Row -->
        </section>
        <!-- ========== section end ========== -->

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <!-- ======== main-wrapper end =========== -->

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>