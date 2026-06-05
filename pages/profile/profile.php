<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>
<?php include_once "../../includes/utils/db.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Profile</title>

    <?php include_once "../../includes/components/links.php"; ?>

    <style>
        :root {
            --primary: #5b5cf0;
            --primary-light: #ece9ff;
            --border: #e7ebf3;
            --text: #1e2a56;
            --muted: #6b7280;
            --bg: #f6f8ff;
        }

        .profile-wrap {
            padding-bottom: 30px;
        }

        .profile-shell {
            position: relative;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 14px 40px rgba(15, 23, 42, .06);
        }

        .profile-shell::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 120px;
            background: linear-gradient(180deg, #f8f7ff 0%, #ffffff 100%);
            pointer-events: none;
        }

        .profile-topbar {
            position: relative;
            padding: 24px 28px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #eef1f7;
            z-index: 2;
        }

        .profile-title-group h6 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        .profile-title-group p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .profile-action-link {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4f46e5, #7c4dff);
            border: none;
            color: #fff !important;
            text-decoration: none;
            transition: .2s;
            flex-shrink: 0;
            box-shadow: 0 10px 20px rgba(91, 92, 240, .22);
        }

        .profile-action-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(91, 92, 240, .26);
        }

        .profile-content {
            position: relative;
            padding: 28px;
        }

        .profile-head {
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 18px;
            border-radius: 20px;
            background: linear-gradient(180deg, #ffffff 0%, #fbfbff 100%);
            border: 1px solid #eef1f7;
            margin-bottom: 24px;
        }

        .profile-image {
            width: 112px;
            height: 112px;
            border-radius: 22px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
            background: #f8fafc;
            flex-shrink: 0;
        }

        .profile-meta h5 {
            margin: 0 0 8px;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .profile-meta .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .profile-meta .profile-note {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            max-width: 620px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .profile-field {
            background: #fff;
            border: 1px solid #eef1f7;
            border-radius: 18px;
            padding: 18px;
            transition: .2s;
        }

        .profile-field:hover {
            border-color: #dce2f2;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .04);
        }

        .profile-field.full {
            grid-column: 1 / -1;
        }

        .profile-field label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-weight: 700;
            color: var(--text);
            font-size: 14px;
        }

        .profile-input,
        .profile-textarea {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
            background: #fafbff;
            color: #334155;
            box-shadow: none;
        }

        .profile-input:focus,
        .profile-textarea:focus {
            outline: none;
            border-color: #c7d2fe;
            box-shadow: 0 0 0 4px rgba(91, 92, 240, .08);
        }

        .profile-textarea {
            resize: none;
            min-height: 120px;
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .table thead th {
            border: none !important;
            color: #64748b;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: .5px;
        }

        .table tbody tr {
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .04);
            transition: .2s;
        }

        .table tbody tr:hover {
            transform: translateY(-2px);
        }

        .table td {
            border: none !important;
            vertical-align: middle;
        }

        .action {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .2s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .view-btn {
            background: #ecfdf5;
            color: #10b981;
        }

        .edit-btn {
            background: #eff6ff;
            color: #3b82f6;
        }

        .status-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .tag-wrap {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            min-width: 140px;
        }

        .task-tag {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(91, 77, 255, .12);
            color: var(--primary);
            white-space: nowrap;
        }

        .no-tags {
            color: #94a3b8;
            font-size: 13px;
            white-space: nowrap;
        }

        .info-btn {
            background: #e0f2fe;
            color: #0284c7;
        }

        .active-btn {
            background: #dbeafe;
            color: #2563eb;
        }

        .success-btn {
            background: #dcfce7;
            color: #16a34a;
        }

        .close-btn {
            background: #fee2e2;
            color: #dc2626;
        }

        .secondary-btn {
            background: #e2e8f0;
            color: #475569;
        }

        .status-modal .modal-content {
            border: 0;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(15, 23, 42, .18);
        }

        .status-modal .modal-header {
            background: linear-gradient(135deg, #5b4dff, #3f8cff);
            border: 0;
            padding: 20px 24px;
            position: relative;
        }

        .status-modal .modal-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, .18), transparent 35%);
            pointer-events: none;
        }

        .status-modal .modal-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
        }

        .status-modal .modal-title-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .status-modal .modal-title-text h5 {
            margin: 0;
            font-weight: 700;
            color: #fff;
        }

        .status-modal .modal-title-text p {
            margin: 2px 0 0 0;
            font-size: 13px;
            opacity: .9;
        }

        .status-modal .modal-body {
            padding: 26px 24px;
            background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
        }

        .status-modal .task-summary {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 16px 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
            margin-bottom: 18px;
        }

        .status-modal .task-summary label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .status-modal .task-summary .task-name {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .status-modal .current-status {
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-modal .current-status span:first-child {
            font-weight: 700;
            color: #334155;
        }

        .status-modal .status-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .status-modal .form-check {
            margin: 0;
            padding: 0;
        }

        .status-modal .status-option {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #fff;
            cursor: pointer;
            transition: .2s;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .03);
        }

        .status-modal .status-option:hover {
            transform: translateY(-2px);
            border-color: #c7d2fe;
            box-shadow: 0 12px 28px rgba(91, 77, 255, .10);
        }

        .status-modal .status-option input {
            width: 18px;
            height: 18px;
            margin: 0;
            accent-color: #5b4dff;
        }

        .status-modal .status-option .option-content {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .status-modal .status-option .option-content strong {
            font-size: 14px;
            color: #0f172a;
        }

        .status-modal .status-option .option-content small {
            font-size: 12px;
            color: #64748b;
            margin-top: 3px;
        }

        .status-modal .modal-footer {
            border: 0;
            padding: 18px 24px 24px;
            background: #f8faff;
            gap: 10px;
        }

        .status-modal .btn-cancel {
            background: #e2e8f0;
            border: 0;
            color: #334155;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
        }

        .status-modal .btn-save {
            background: linear-gradient(135deg, #5b4dff, #3f8cff);
            border: 0;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(91, 77, 255, .22);
        }

        .status-modal .btn-save:hover,
        .status-modal .btn-cancel:hover {
            transform: translateY(-1px);
        }

        .member-img {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-left: -6px;
            transition: .2s;
            vertical-align: middle;
        }

        .member-img:first-child {
            margin-left: 0;
        }

        .member-img img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #eef2ff;
            object-fit: cover;
            display: block;
        }

        .member-img:hover {
            transform: translateY(-2px);
            position: relative;
            z-index: 10;
        }

        @media (max-width: 768px) {

            .status-modal .status-options {
                grid-template-columns: 1fr;
            }

            .profile-topbar,
            .profile-content {
                padding: 20px;
            }

            .profile-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-image {
                width: 96px;
                height: 96px;
                border-radius: 18px;
            }

            .profile-meta h5 {
                font-size: 20px;
            }

            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php include_once "../../includes/components/preloader.php"; ?>
    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <?php
        if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
            header("Location: ../dashboard/dashboard.php");
            exit();
        }

        $user_id = $_GET['user_id'];
        $select_user = mysqli_query(
            $conn,
            "SELECT * FROM users_tbl LEFT JOIN roles_tbl ON users_tbl.role = roles_tbl.role_id WHERE user_id = '$user_id'"
        );
        $user = mysqli_fetch_array($select_user);
        ?>

        <section class="section profile-wrap">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Profile</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="../dashboard/dashboard.php">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="profile-shell mb-30">
                            <div class="profile-topbar">
                                <div class="profile-title-group">
                                    <h6><?= $user['full_name'] . "'s"; ?> Profile</h6>
                                    <p>View account details and profile information</p>
                                </div>

                                <?php if ($user['user_id'] == $_SESSION['user_id']): ?>
                                    <a href="../users/edit.user.php?user_id=<?= $user['user_id']; ?>"
                                        class="profile-action-link">
                                        <i class="lni lni-pencil-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="profile-content">
                                <div class="profile-head">
                                    <img class="profile-image"
                                        src="<?= get_user_profile_image($conn, $user['user_id']); ?>"
                                        alt="<?= $user['full_name']; ?>" />

                                    <div class="profile-meta">
                                        <h5><?= $user['full_name']; ?></h5>
                                        <div class="role-badge">
                                            <?php
                                            if ($user['role'] == "Admin") {
                                                ?>
                                                <i class="lni lni-shield"></i>
                                                <?php
                                            } else {
                                                ?>
                                                <i class="lni lni-user"></i>
                                                <?php
                                            }
                                            ?>
                                            <?= $user['role']; ?>
                                        </div>
                                        <p class="profile-note">
                                            <?= !empty($user['bio']) ? $user['bio'] : 'Passionate about productivity and building great things. ✨'; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="profile-grid">
                                    <div class="profile-field">
                                        <label><i class="lni lni-user"></i> Username</label>
                                        <input type="text" class="profile-input" value="<?= $user['username']; ?>"
                                            readonly />
                                    </div>

                                    <div class="profile-field">
                                        <label><i class="lni lni-envelope"></i> Email</label>
                                        <input type="email" class="profile-input" value="<?= $user['email']; ?>"
                                            readonly />
                                    </div>

                                    <div class="profile-field full">
                                        <label><i class="lni lni-pencil"></i> Bio</label>
                                        <textarea class="profile-textarea" readonly><?= $user['bio']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($_SESSION['role'] == "Admin" && $user['role'] != "Admin") {
                            ?>
                            <div class="profile-shell">
                                <div class="profile-topbar">
                                    <div class="profile-title-group">
                                        <h6><?= $user['full_name'] . "'s"; ?> Tasks</h6>
                                        <p>Tasks assigned to this user</p>
                                    </div>

                                    <?php if ($user['user_id'] == $_SESSION['user_id']): ?>
                                        <a href="../users/edit.user.php?user_id=<?= $user['user_id']; ?>"
                                            class="profile-action-link">
                                            <i class="lni lni-pencil-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="profile-content">
                                    <?php
                                    $user_id = $user['user_id'];
                                    $role = $user['role'];

                                    include_once "../../includes/elements/tables/task.table.php";
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>