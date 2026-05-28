<?php require_once "../../includes/conn.php"; ?>
<?php include "../../includes/session.start.php" ?>

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

/* ROLE CHECK (Admin OR owner only) */
if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['user_id'] != $user_id) {
        header("location: ../dashboard/dashboard.php");
        exit();
    }
}

/* FETCH USER */
$select_user = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
$user = mysqli_fetch_array($select_user);

?>

<main class="main-wrapper">

    <?php include_once "../../includes/elements/navbar.php"; ?>

    <section class="section">
        <div class="container-fluid">

            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>Edit User</h2>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="../dashboard/dashboard.php">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit User</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>" 
                  method="POST"
                  class="form-elements wrapper">

                <div class="form-elements-wrapper">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card-style mb-30">

                                <h6 class="mb-25">Profile</h6>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-style-1">
                                            <label>Full Name</label>
                                            <input type="text" name="fullname" value="<?php echo $user['full_name']; ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col">
                                        <div class="input-style-1">
                                            <label>Username</label>
                                            <input type="text" name="username" value="<?php echo $user['username']; ?>" required />
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="input-style-1">
                                            <label>Email</label>
                                            <input type="email" name="email" value="<?php echo $user['email']; ?>" required />
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-style-1">
                                            <label>Password</label>
                                            <input type="password" name="password" required />
                                        </div>
                                    </div>
                                </div>

                                <?php if ($_SESSION['role'] == 'Admin') { ?>

                                <h6 class="mb-25">Role</h6>

                                <div class="row">

                                    <div class="col">
                                        <div class="form-check radio-style mb-20">
                                            <input type="radio" name="role" value="1"
                                                <?php if ($user['role'] == 1) echo "checked"; ?> required />
                                            <label>Admin</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-check radio-style mb-20">
                                            <input type="radio" name="role" value="2"
                                                <?php if ($user['role'] == 2) echo "checked"; ?> required />
                                            <label>Member</label>
                                        </div>
                                    </div>

                                </div>

                                <?php } ?>

                                <button type="submit" class="btn btn-primary" style="height:50px;" name="submit">
                                    Update User
                                </button>

                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </section>

    <?php include_once "../../includes/elements/footer.php"; ?>

</main>

<?php include_once "../../includes/components/scripts.php"; ?>

</body>
</html>