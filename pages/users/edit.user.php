<?php
require_once "../../includes/conn.php";
include_once "../../includes/session.start.php";
include_once "../../includes/utils/login.access.check.php";
include_once "../../includes/utils/user.utils.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Edit User</title>

    <?php include_once "../../includes/components/links.php"; ?>

    <style>
        :root {
            --primary: #5b5cf0;
            --primary-light: #ece9ff;
            --bg: #f6f8ff;
            --card: #ffffff;
            --border: #e7ebf3;
            --text: #0f172a;
            --muted: #64748b;
        }

        .edit-page {
            padding-bottom: 30px;
        }

        .edit-hero {
            background: linear-gradient(135deg, #ffffff 0%, #fbfbff 100%);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
            overflow: hidden;
            position: relative;
            margin-bottom: 24px;
        }

        .edit-hero::before {
            content: "";
            position: absolute;
            inset: auto -60px -60px auto;
            width: 180px;
            height: 180px;
            background: rgba(91, 92, 240, .06);
            border-radius: 40px;
            transform: rotate(-12deg);
        }

        .edit-hero-inner {
            position: relative;
            z-index: 1;
            padding: 26px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .edit-title h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: var(--text);
        }

        .edit-title p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .edit-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
            font-size: 13px;
        }

        .form-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
            padding: 26px;
            margin-bottom: 24px;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 22px;
            padding-bottom: 14px;
            border-bottom: 1px solid #eef1f7;
        }

        .section-head h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
        }

        .section-head span {
            color: var(--muted);
            font-size: 13px;
        }

        .input-style-1 {
            margin-bottom: 18px;
        }

        .input-style-1 label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--text);
            font-size: 14px;
        }

        .input-style-1 input,
        .input-style-1 textarea,
        .input-style-1 .form-control {
            width: 100%;
            border: 1.5px solid #e5e7eb !important;
            border-radius: 14px !important;
            background: #fafbff;
            padding: 14px 16px;
            color: #334155;
            box-shadow: none !important;
        }

        .input-style-1 input:focus,
        .input-style-1 textarea:focus,
        .input-style-1 .form-control:focus {
            border-color: #c7d2fe !important;
            box-shadow: 0 0 0 4px rgba(91, 92, 240, .08) !important;
            outline: none !important;
        }

        .profile-preview {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border: 1px dashed #d9def0;
            border-radius: 18px;
            background: #fbfcff;
            margin-bottom: 18px;
        }

        .profile-image {
            width: 84px;
            height: 84px;
            border-radius: 18px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .08);
            background: #f8fafc;
            flex-shrink: 0;
        }

        .profile-preview h6 {
            margin: 0 0 6px;
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
        }

        .profile-preview p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }

        .radio-style {
            padding: 14px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fafbff;
            transition: .2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .radio-style:hover {
            border-color: #c7d2fe;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .04);
        }

        .radio-style input {
            accent-color: var(--primary);
        }

        .radio-style label {
            margin: 0;
            font-weight: 700;
            color: var(--text);
        }

        .action-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .btn-primary,
        .btn-danger {
            height: 50px;
            border-radius: 14px !important;
            padding: 0 22px;
            font-weight: 700;
            border: none !important;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .08);
            transition: .2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c4dff) !important;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444) !important;
        }

        .btn-primary:hover,
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(15, 23, 42, .12);
        }

        .file-help {
            margin-top: 8px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width:768px) {

            .edit-hero-inner,
            .form-card {
                padding: 20px;
            }

            .edit-title h2 {
                font-size: 22px;
            }

            .profile-preview {
                align-items: flex-start;
            }

            .action-row {
                flex-direction: column;
            }

            .action-row .btn,
            .action-row button {
                width: 100%;
            }
        }
    </style>
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

    if ($_SESSION['role'] != 'Admin') {
        if ($_SESSION['user_id'] != $user_id) {
            header("location: ../dashboard/dashboard.php");
            exit();
        }
    }

    $select_user = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
    $user = mysqli_fetch_array($select_user);
    ?>

    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <section class="section edit-page">
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

                <div class="edit-hero">
                    <div class="edit-hero-inner">
                        <div class="edit-title">
                            <h2>Edit User Profile</h2>
                            <p>Update account details, role, profile image, and bio.</p>
                        </div>
                        <div class="edit-badge">
                            <i class="lni lni-pencil-alt"></i>
                            <?= $user['full_name']; ?>
                        </div>
                    </div>
                </div>

                <div class="form-elements-wrapper">
                    <div class="row g-4">

                        <div class="col-12">
                            <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>"
                                enctype="multipart/form-data" method="POST">
                                <div class="form-card">
                                    <div class="section-head">
                                        <h6>Profile Image</h6>
                                        <span>Upload or remove profile picture</span>
                                    </div>

                                    <div class="profile-preview">
                                        <img class="profile-image"
                                            src="<?php echo get_user_profile_image($conn, $user['user_id']); ?>"
                                            alt="<?php echo $user['full_name']; ?>" />
                                        <div>
                                            <h6><?php echo $user['full_name']; ?></h6>
                                            <p>Current profile image for this account</p>
                                        </div>
                                    </div>

                                    <div class="input-style-1">
                                        <?php if (!isset($user['profile'])) { ?>
                                            <label>Profile Image</label>
                                            <input class="form-control form-control-sm" type="file"
                                                accept=".png, .jpg, .jpeg" name="profileimage">
                                            <div class="file-help">
                                                Accepted formats: JPG, JPEG, PNG. Max size: 2MB.
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="action-row">
                                        <?php if (isset($user['profile'])) { ?>
                                            <button type="submit" class="btn btn-danger" name="deleteprofile">
                                                Delete Profile
                                            </button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-primary" name="submitprofile">
                                                Update Profile
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>" method="POST">
                                <div class="form-card">
                                    <div class="section-head">
                                        <h6>User Information</h6>
                                        <span>Basic account details</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-style-1">
                                                <label>Full Name</label>
                                                <input type="text" name="fullname"
                                                    value="<?php echo $user['full_name']; ?>" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-style-1">
                                                <label>Username</label>
                                                <input type="text" name="username"
                                                    value="<?php echo $user['username']; ?>" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="input-style-1">
                                                <label>Email</label>
                                                <input type="email" name="email" value="<?php echo $user['email']; ?>"
                                                    required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-style-1">
                                                <label>Password</label>
                                                <input type="password" name="password" required />
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($_SESSION['role'] == 'Admin') { ?>
                                        <div class="section-head mt-4">
                                            <h6>User Role</h6>
                                            <span>Choose access level</span>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-check radio-style">
                                                    <input type="radio" name="role" value="1" <?php if ($user['role'] == 1)
                                                        echo "checked"; ?> required />
                                                    <label>Admin</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check radio-style">
                                                    <input type="radio" name="role" value="2" <?php if ($user['role'] == 2)
                                                        echo "checked"; ?> required />
                                                    <label>Member</label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="action-row mt-4">
                                        <button type="submit" class="btn btn-primary" name="submit">
                                            Update User
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>" method="POST">
                                <div class="form-card">
                                    <div class="section-head">
                                        <h6>Bio</h6>
                                        <span>Short profile description</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-style-1">
                                                <label>Bio / Profile Description</label>
                                                <textarea class="text-start" placeholder="Write your bio here" rows="4"
                                                    name="bio"><?php echo $user['bio']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action-row">
                                        <button type="submit" class="btn btn-primary" name="submitbio">
                                            Update Bio
                                        </button>
                                    </div>
                                </div>
                            </form>
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