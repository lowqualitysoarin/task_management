<?php require_once '../../includes/conn.php'; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/admin.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>List Users</title>

    <?php include_once "../../includes/components/links.php"; ?>

    <style>
        :root {
            --primary: #5b4dff;
            --secondary: #3f8cff;
            --border: #e5e7eb;
            --muted: #64748b;
        }

        body {
            background: #f5f7ff;
        }


        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 18px;
            padding: 20px 25px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(91, 77, 255, .20);
            margin-top: 20px;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .header-subtitle {
            margin: 0;
            font-size: .85rem;
            color: rgba(255, 255, 255, .85);
        }

        /* =========================
   MAIN CARD
========================= */
        .glass-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            margin-top: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }


        .table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .table thead th {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: none !important;
            padding: 12px;
        }

        .table tbody tr {
            background: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .05);
            border-radius: 14px;
            transition: .2s ease;
        }

        .table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, .08);
        }

        .table td {
            border: none !important;
            vertical-align: middle;
            padding: 14px;
        }


        .user-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-box img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid #eef2ff;
            object-fit: cover;
        }

        .user-name {
            font-weight: 700;
            color: #1f2937;
            /* soft black */
        }

        .user-role-text {
            font-size: 12px;
            color: #64748b;
        }

        /* =========================
   ROLE BADGE
========================= */
        .role-badge {
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .admin {
            background: rgba(91, 77, 255, .12);
            color: var(--primary);
        }

        .member {
            background: rgba(63, 140, 255, .12);
            color: var(--secondary);
        }

        /* =========================
   ACTION BUTTONS 
========================= */
        .action {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: .2s ease;
            text-decoration: none;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .view {
            background: #ecfdf5;
            color: #10b981;
        }

        .edit {
            background: #eff6ff;
            color: #3b82f6;
        }

        .delete {
            background: #fef2f2;
            color: #ef4444;
            border: none;
        }
    </style>
</head>

<body>

    <?php include_once "../../includes/components/preloader.php"; ?>
    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <main class="main-wrapper">

        <?php include_once "../../includes/elements/navbar.php"; ?>

        <div class="container-fluid">

            <!-- HEADER -->
            <div class="page-header">
                <div class="header-icon">
                    <i class="lni lni-users"></i>
                </div>

                <div>
                    <h2 class="header-title">List Users</h2>
                    <p class="header-subtitle">Manage system users and permissions</p>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="glass-card">
                <div class="table-responsive">
                    <table class="table" data-toggle="table" data-search="true" data-filter-control="true">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
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
                                    <td>
                                        <div class="user-box">
                                            <img src="<?= get_user_profile_image($conn, $user['user_id']); ?>">
                                            <div>
                                                <div class="user-name"><?= $user['full_name']; ?></div>
                                                <div class="user-role-text">@<?= $user['username']; ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td><?= $user['username']; ?></td>

                                    <td><?= $user['email']; ?></td>

                                    <td>
                                        <span
                                            class="role-badge <?= strtolower($user['role']) == 'admin' ? 'admin' : 'member'; ?>">
                                            <?= $user['role']; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action">
                                            <a class="action-btn view"
                                                href="../profile/profile.php?user_id=<?= $user['user_id']; ?>">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <a class="action-btn edit"
                                                href="edit.user.php?user_id=<?= $user['user_id']; ?>">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <button class="action-btn delete" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal<?= $user['user_id']; ?>">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- DELETE MODAL (UNCHANGED FUNCTION) -->
                                <div class="modal fade" id="deleteUserModal<?= $user['user_id']; ?>">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger">Delete User</h5>
                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Are you sure you want to delete <b><?= $user['full_name']; ?></b>?
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger"
                                                    href="ctrlData/ctrl.delete.user.php?user_id=<?= $user['user_id']; ?>">
                                                    Delete
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
        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <?php include_once "../../includes/components/scripts.php"; ?>
</body>
</html>