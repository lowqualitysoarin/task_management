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
    <title>Task Management | List Users</title>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>

    <?php include_once "../../includes/components/preloader.php"; ?>
    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <main class="main-wrapper">

        <?php include_once "../../includes/elements/navbar.php"; ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php } ?>

        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Error!</strong> <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php } ?>

        <!-- PAGE -->
        <section class="section">
            <div class="container-fluid">

                <!-- TITLE -->
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
                                        <li class="breadcrumb-item active">List Users</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- TABLE -->
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
                                </thead>

                                <tbody>

                                    <?php
                                    $users = mysqli_query($conn, "
    SELECT * FROM users_tbl 
    LEFT JOIN roles_tbl 
    ON roles_tbl.role_id = users_tbl.role
");

                                    while ($user = mysqli_fetch_array($users)) {
                                        ?>

                                        <tr>

                                            <!-- USER -->
                                            <td class="min-width">
                                                <div class="lead">
                                                    <div class="lead-image">
                                                        <img src="<?= get_user_profile_image($conn, $user['user_id']); ?>"
                                                            alt="<?= $user['full_name']; ?>" />
                                                    </div>
                                                    <div class="lead-text">
                                                        <p><?= $user['full_name']; ?></p>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- USERNAME -->
                                            <td class="min-width">
                                                <p><?= $user['username']; ?></p>
                                            </td>

                                            <!-- EMAIL -->
                                            <td class="min-width">
                                                <p><?= $user['email']; ?></p>
                                            </td>

                                            <!-- ROLE -->
                                            <td class="min-width">
                                                <p><?= $user['role']; ?></p>
                                            </td>

                                            <!-- ACTION -->
                                            <td>
                                                <div class="action">

                                                    <a class="text-success lni lni-eye m-1"
                                                        href="../profile/profile.php?user_id=<?php echo $user['user_id']; ?>">
                                                    </a>


                                                    <!-- EDIT -->
                                                    <a href="edit.user.php?user_id=<?= $user['user_id']; ?>"
                                                        class="text-primary">
                                                        <i class="lni lni-pencil"></i>
                                                    </a>

                                                    <!-- DELETE BUTTON -->
                                                    <button type="button" class="text-danger border-0 bg-transparent"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteUserModal<?= $user['user_id']; ?>">
                                                        <i class="lni lni-trash-can"></i>
                                                    </button>

                                                </div>
                                            </td>

                                        </tr>

                                        <!-- DELETE MODAL -->
                                        <div class="modal fade" id="deleteUserModal<?= $user['user_id']; ?>" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger">Delete User</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure you want to delete this user?

                                                        <br><br>

                                                        <strong><?= htmlspecialchars($user['full_name']); ?></strong>

                                                        <br><br>

                                                        This action cannot be undone.
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Cancel
                                                        </button>

                                                        <a href="ctrlData/ctrl.delete.user.php?user_id=<?= $user['user_id']; ?>"
                                                            class="btn btn-danger">
                                                            Yes, Delete
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </section>

        <?php include_once "../../includes/elements/footer.php"; ?>

    </main>

    <?php include_once "../../includes/components/scripts.php"; ?>

</body>

</html>