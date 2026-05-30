<?php require_once '../../includes/conn.php'; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/admin.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Add User</title>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>

<?php include_once "../../includes/components/preloader.php"; ?>
<?php include_once "../../includes/elements/sidebar.php"; ?>

<!-- ======== main-wrapper start =========== -->
<main class="main-wrapper">
    <?php include_once "../../includes/elements/navbar.php"; ?>

    <!-- SUCCESS ALERT -->
    <?php if(isset($_SESSION['success'])) { ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <strong>Success!</strong>
        <?php echo $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php } ?>
<!-- ✅ TOASTR SUCCESS MESSAGE -->
<?php if (isset($_SESSION['success'])) { ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    toastr.success("<?php echo $_SESSION['success']; ?>");
});
</script>
<?php unset($_SESSION['success']); ?>
<?php } ?>

<!-- ========== section start ========== -->
<section class="section">
<div class="container-fluid">

<!-- title -->
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="title">
                <h2>List Users</h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../dashboard/dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            List Users
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

                <div class="row">
                    <div class="card-style mb-30">
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <h6>User</h6>
                                        </th>
                                        <th>
                                            <h6>Username</h6>
                                        </th>
                                        <th>
                                            <h6>Email</h6>
                                        </th>
                                        <th>
                                            <h6>Role</h6>
                                        </th>
                                        <th>
                                            <h6>Action</h6>
                                        </th>
                                    </tr>
                                    <!-- end table row-->
                                </thead>
                                <tbody>
                                    <!-- end table row -->
                                    <?php
                                    $users = mysqli_query($conn, "SELECT * FROM users_tbl LEFT JOIN roles_tbl ON roles_tbl.role_id = users_tbl.role");
                                    while ($user = mysqli_fetch_array($users)) {
                                        ?>
                                        <tr>
                                            <td class="min-width">
                                                <div class="lead">
                                                    <div class="lead-image">
                                                        <img src="<?php echo get_user_profile_image($conn, $user['user_id']); ?>" alt="<?php echo $user['full_name']; ?>"/>
                                                    </div>
                                                    <div class="lead-text">
                                                        <p><?php echo $user['full_name']; ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="min-width">
                                                <p><?php echo $user['username']; ?></p>
                                            </td>
                                            <td class="min-width">
                                                <p><?php echo $user['email']; ?></p>
                                            </td>
                                            <td class="min-width">
                                                <p><?php echo $user['role']; ?></p>
                                            </td>
                                            <td>
                                                <div class="action">
                                                    <button class="text-primary">
                                                        <a href="edit.user.php?user_id=<?php echo $user['user_id']; ?>"
                                                            class="lni lni-pencil"></a>
                                                    </button>
                                                    <button class="text-danger">
                                                        <a href="ctrlData/ctrl.delete.user.php?user_id=<?php echo $user['user_id']; ?>"
                                                            class="lni lni-trash-can"></a>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- end table -->
                        </div>
                    </div>
                </div>
                <!-- end input -->
            </div>
            <!-- End Row -->
            </div>
            <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

<?php include_once "../../includes/elements/footer.php"; ?>
</main>

<?php include_once "../../includes/components/scripts.php"; ?>

</body>
</html>