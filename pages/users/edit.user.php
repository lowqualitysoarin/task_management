<?php
require_once "../../includes/conn.php";
include_once "../../includes/session.start.php";
include_once "../../includes/utils/login.access.check.php";
include_once "../../includes/utils/user.utils.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon"/>
    <title>Task Management | Edit User</title>

    <style>
        :root {
            --primary: #5b4dff;
            --secondary: #3f8cff;
            --border: #e5e7eb;
            --muted: #64748b;
        }

        body {
            background: #f5f7ff;
            overflow-x: hidden;
        }

        .section {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 70px;
            border-radius: 18px;
            padding: 12px 25px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(91, 77, 255, .20);
        }

        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2px;
            color: #fff;
        }

        .header-subtitle {
            margin: 0;
            font-size: .85rem;
            opacity: .9;
        }

        .glass-card {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            margin-top: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
        }

        /* FORM */
        .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .section-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #eef2ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .section-head h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .section-head p {
            margin: 0;
            font-size: .8rem;
            color: var(--muted);
        }

        hr {
            margin: .8rem 0;
        }

        .mb-3 {
            margin-bottom: .75rem !important;
        }

        .form-label {
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .input-custom,
        textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 12px 12px 42px;
            font-size: .9rem;
            transition: .3s;
            background: #fff;
        }

        textarea {
            min-height: 120px;
            padding-left: 42px;
        }

        .input-custom:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(91, 77, 255, .12);
        }

        .input-custom {
            width: 100%;
            height: 45px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding-left: 42px;
            font-size: .9rem;
            transition: .3s;
        }

        .input-custom:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(91, 77, 255, .10);
        }

        /* ROLE DESIGN */
        .role-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .role-card {
            position: relative;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: .3s;
            background: #fff;
        }

        .role-card.active {
            border-color: var(--primary);
            background: #fafaff;
        }

        .role-card input {
            display: none;
        }

        .role-radio {
            position: absolute;
            right: 12px;
            top: 12px;
            width: 16px;
            height: 16px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
        }

        .role-card.active .role-radio {
            border-color: var(--primary);
        }

        .role-card.active .role-radio:after {
            content: "";
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            position: absolute;
            top: 3px;
            left: 3px;
        }

        .role-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .role-content {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .role-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .member-icon {
            background: #fff2eb;
            color: #5b4dff;
        }

        .role-details {
            flex: 1;
        }

        .role-access {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 3px;
        }

        .role-desc {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.4;
        }

        /* BUTTON */
        .btn-add {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin-top: 15px;
            transition: .3s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
        }

        @media(max-width:768px) {
            .role-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <?php include_once "../../includes/components/links.php"; ?>

    <style>
        :root{
            --primary:#5b5cf0;
            --primary-light:#ece9ff;
            --bg:#f6f8ff;
            --card:#ffffff;
            --border:#e7ebf3;
            --text:#0f172a;
            --muted:#64748b;
        }

        .edit-page{
            padding-bottom:30px;
        }

        .edit-hero{
            background:linear-gradient(135deg,#ffffff 0%,#fbfbff 100%);
            border:1px solid var(--border);
            border-radius:22px;
            box-shadow:0 12px 35px rgba(15,23,42,.06);
            overflow:hidden;
            position:relative;
            margin-bottom:24px;
        }

        .edit-hero::before{
            content:"";
            position:absolute;
            inset:auto -60px -60px auto;
            width:180px;
            height:180px;
            background:rgba(91,92,240,.06);
            border-radius:40px;
            transform:rotate(-12deg);
        }

        .edit-hero-inner{
            position:relative;
            z-index:1;
            padding:26px 28px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            flex-wrap:wrap;
        }

        .edit-title h2{
            margin:0;
            font-size:28px;
            font-weight:800;
            color:var(--text);
        }

        .edit-title p{
            margin:6px 0 0;
            color:var(--muted);
            font-size:14px;
        }

        .edit-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:9px 14px;
            border-radius:999px;
            background:var(--primary-light);
            color:var(--primary);
            font-weight:700;
            font-size:13px;
        }

        .form-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:22px;
            box-shadow:0 12px 35px rgba(15,23,42,.06);
            padding:26px;
            margin-bottom:24px;
        }

        .section-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:22px;
            padding-bottom:14px;
            border-bottom:1px solid #eef1f7;
        }

        .section-head h6{
            margin:0;
            font-size:16px;
            font-weight:800;
            color:var(--text);
        }

        .section-head span{
            color:var(--muted);
            font-size:13px;
        }

        .input-style-1{
            margin-bottom:18px;
        }

        .input-style-1 label{
            display:block;
            margin-bottom:8px;
            font-weight:700;
            color:var(--text);
            font-size:14px;
        }

        .input-style-1 input,
        .input-style-1 textarea,
        .input-style-1 .form-control{
            width:100%;
            border:1.5px solid #e5e7eb !important;
            border-radius:14px !important;
            background:#fafbff;
            padding:14px 16px;
            color:#334155;
            box-shadow:none !important;
        }

        .input-style-1 input:focus,
        .input-style-1 textarea:focus,
        .input-style-1 .form-control:focus{
            border-color:#c7d2fe !important;
            box-shadow:0 0 0 4px rgba(91,92,240,.08) !important;
            outline:none !important;
        }

        .profile-preview{
            display:flex;
            align-items:center;
            gap:16px;
            padding:16px;
            border:1px dashed #d9def0;
            border-radius:18px;
            background:#fbfcff;
            margin-bottom:18px;
        }

        .profile-image{
            width:84px;
            height:84px;
            border-radius:18px;
            object-fit:cover;
            border:4px solid #fff;
            box-shadow:0 10px 20px rgba(15,23,42,.08);
            background:#f8fafc;
            flex-shrink:0;
        }

        .profile-preview h6{
            margin:0 0 6px;
            font-size:16px;
            font-weight:800;
            color:var(--text);
        }

        .profile-preview p{
            margin:0;
            color:var(--muted);
            font-size:13px;
        }

        .radio-style{
            padding:14px 16px;
            border:1px solid #e5e7eb;
            border-radius:14px;
            background:#fafbff;
            transition:.2s;
            display:flex;
            align-items:center;
            gap:10px;
        }

        .radio-style:hover{
            border-color:#c7d2fe;
            box-shadow:0 8px 20px rgba(15,23,42,.04);
        }

        .radio-style input{
            accent-color:var(--primary);
        }

        .radio-style label{
            margin:0;
            font-weight:700;
            color:var(--text);
        }

        .action-row{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            margin-top:8px;
        }

        .btn-primary,
        .btn-danger{
            height:50px;
            border-radius:14px !important;
            padding:0 22px;
            font-weight:700;
            border:none !important;
            box-shadow:0 10px 20px rgba(15,23,42,.08);
            transition:.2s;
        }

        .btn-primary{
            background:linear-gradient(135deg,#4f46e5,#7c4dff) !important;
        }

        .btn-danger{
            background:linear-gradient(135deg,#dc2626,#ef4444) !important;
        }

        .btn-primary:hover,
        .btn-danger:hover{
            transform:translateY(-1px);
            box-shadow:0 14px 24px rgba(15,23,42,.12);
        }

        .file-help{
            margin-top:8px;
            color:var(--muted);
            font-size:12px;
        }

        @media (max-width:768px){
            .edit-hero-inner,
            .form-card{
                padding:20px;
            }

            .edit-title h2{
                font-size:22px;
            }

            .profile-preview{
                align-items:flex-start;
            }

            .action-row{
                flex-direction:column;
            }

            .action-row .btn,
            .action-row button{
                width:100%;
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
                    <div class="row">
                        <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>" method="POST">
                            <div class="glass-card">
                                <div class="section-head">
                                    <div class="section-icon">
                                        <i class="lni lni-user"></i>
                                    </div>

                                    <div>
                                        <h5>Profile Information</h5>
                                        <p>Enter the basic details of the user.</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <div class="input-group-custom">
                                            <i class="lni lni-user"></i>
                                            <input type="text" name="fullname" class="input-custom"
                                                value="<?php echo $user['full_name']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-group-custom">
                                            <i class="lni lni-at"></i>
                                            <input type="text" name="username" class="input-custom"
                                                value="<?php echo $user['username']; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <div class="input-group-custom">
                                            <i class="lni lni-envelope"></i>
                                            <input type="email" name="email" class="input-custom"
                                                value="<?php echo $user['email']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group-custom">
                                            <i class="lni lni-lock"></i>
                                            <input type="password" name="password" class="input-custom" required>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($_SESSION['role'] == 'Admin') { ?>
                                    <div class="section-head mt-4">
                                        <div class="section-icon">
                                            <i class="lni lni-shield"></i>
                                        </div>

                                        <div>
                                            <h5>Select Role</h5>
                                            <p>Choose the appropriate role for this user.</p>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="role-container">
                                        <label class="role-card <?php if ($user['role'] == 1)
                                            echo "active"; ?>">
                                            <input type="radio" name="role" value="1" <?php if ($user['role'] == 1)
                                                echo "checked"; ?> required>

                                            <div class="role-radio"></div>

                                            <div class="role-title">Admin</div>

                                            <div class="role-content">
                                                <div class="role-icon">
                                                    <i class="lni lni-crown"></i>
                                                </div>

                                                <div class="role-details">
                                                    <div class="role-access">Full system access</div>
                                                    <div class="role-desc">Can manage all users, settings and system data.
                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="role-card <?php if ($user['role'] == 2)
                                            echo "active"; ?>">
                                            <input type="radio" name="role" value="2" <?php if ($user['role'] == 2)
                                                echo "checked"; ?>required>

                                            <div class="role-radio"></div>

                                            <div class="role-title">Member</div>

                                            <div class="role-content">
                                                <div class="role-icon member-icon">
                                                    <i class="lni lni-users"></i>
                                                </div>

                                                <div class="role-details">
                                                    <div class="role-access">Limited access</div>
                                                    <div class="role-desc">Can view and manage assigned resources only.
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php } ?>

                                <button type="submit" name="submit" class="btn-add">
                                    <i class="lni lni-user"></i> Update User
                                </button>
                            </div>
                        </form>
                        <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>"
                            enctype="multipart/form-data" method="POST">
                            <div class="glass-card">
                                <div class="section-head">
                                    <div class="section-icon">
                                        <i class="lni lni-user"></i>
                                    </div>

                                    <div>
                                        <h5>Profile Image</h5>
                                        <p>Give this user's profile image</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="col-md-12 mb-3">
                                    <div class="ratio ratio-1x1 square-container mx-auto d-block">
                                        <img class="img-thumbnail rounded-circle"
                                            src="<?php echo get_user_profile_image($conn, $user['user_id']); ?>"
                                            alt="<?php echo $user['full_name']; ?>" />
                                    </div>
                                    <div class="input-style-1">
                                        <?php
                                        if (!isset($user['profile'])) {
                                            ?>
                                            <label class="form-label">Profile Image</label>
                                            <input type="file" name="profileimage"
                                                accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">
                                            <div class="small-note">Allowed: JPG, PNG, PDF, DOC, XLS</div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                    if (isset($user['profile'])) {
                                        ?>
                                        <button type="submit" class="col-md-12 btn btn-danger" style="height:50px;"
                                            name="deleteprofile">
                                            Delete Profile
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" name="submitprofile" class="btn-add">
                                            <i class="lni lni-user"></i> Update Profile
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                        <form action="ctrlData/ctrl.update.user.php?user_id=<?php echo $user_id; ?>" method="POST">
                            <div class="glass-card">
                                <div class="col-md-12 mb-3">
                                    <div class="section-head">
                                        <div class="section-icon">
                                            <i class="lni lni-user"></i>
                                        </div>

                                        <div>
                                            <h5>Profile Bio</h5>
                                            <p>A little description for the user</p>
                                        </div>
                                    </div>

                                    <hr>

                                    <label class="form-label">Bio</label>
                                    <div class="input-group-custom">
                                        <i class="lni lni-text-format"></i>
                                        <textarea name="bio" placeholder="Write your bio here"
                                            rows="4"><?php echo $user['bio']; ?></textarea>
                                    </div>

                                    <button type="submit" name="submitbio" class="btn-add">
                                        <i class="lni lni-bubble"></i> Update Bio
                                    </button>
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

    <script>
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function () {
                document.querySelectorAll('.role-card').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>

