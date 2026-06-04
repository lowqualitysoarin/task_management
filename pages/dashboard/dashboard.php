<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon"/>
    <title>Task Management | Dashboard</title>

    <?php include_once "../../includes/components/links.php"; ?>

    <style>
        :root{
            --primary:#5b4dff;
            --secondary:#3f8cff;
            --success:#22c55e;
            --danger:#ef4444;
            --muted:#64748b;
        }

        body{
            background:#f5f7ff;
        }

        .dashboard-card{
            background:white;
            border-radius:20px;
            padding:22px;
            position:relative;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.06);
            transition:.3s;
            display:flex;
            align-items:center;
            gap:16px;
        }

        .dashboard-card:hover{
            transform:translateY(-5px);
            box-shadow:0 18px 40px rgba(91,77,255,.12);
        }

        .dashboard-card::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:4px;
            background:linear-gradient(90deg,#5b4dff,#3f8cff);
        }

        .dashboard-card .icon-box{
            width:62px;
            height:62px;
            border-radius:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:26px;
            flex-shrink:0;
            color:white;
            box-shadow:0 10px 25px rgba(0,0,0,.12);
        }

        .dashboard-card .content h6{
            margin:0 0 6px 0;
            color:#64748b;
            font-size:14px;
            font-weight:600;
        }

        .dashboard-card .content h3{
            margin:0;
            font-size:30px;
            font-weight:800;
            color:#0f172a;
        }

        .icon-pending{ background:linear-gradient(135deg,#f59e0b,#fbbf24); }
        .icon-progress{ background:linear-gradient(135deg,#3b82f6,#60a5fa); }
        .icon-completed{ background:linear-gradient(135deg,#22c55e,#4ade80); }
        .icon-incomplete{ background:linear-gradient(135deg,#ef4444,#f87171); }

        .glass-card{
            background:white;
            border-radius:20px;
            padding:25px;
            box-shadow:0 10px 30px rgba(0,0,0,.05);
        }

        .table{
            border-collapse:separate;
            border-spacing:0 12px;
        }

        .table thead th{
            border:none !important;
            color:#64748b;
            text-transform:uppercase;
            font-size:12px;
            letter-spacing:.5px;
        }

        .table tbody tr{
            background:white;
            box-shadow:0 5px 20px rgba(0,0,0,.04);
            transition:.2s;
        }

        .table tbody tr:hover{
            transform:translateY(-2px);
        }

        .table td{
            border:none !important;
            vertical-align:middle;
        }

        .action{
            display:flex;
            gap:8px;
        }

        .action-btn{
            width:38px;
            height:38px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            text-decoration:none;
            transition:.2s;
        }

        .action-btn:hover{
            transform:translateY(-2px);
        }

        .view-btn{
            background:#ecfdf5;
            color:#10b981;
        }

        .edit-btn{
            background:#eff6ff;
            color:#3b82f6;
        }

        .status-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:6px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
        }

        .info-btn{ background:#e0f2fe; color:#0284c7; }
        .active-btn{ background:#dbeafe; color:#2563eb; }
        .success-btn{ background:#dcfce7; color:#16a34a; }
        .close-btn{ background:#fee2e2; color:#dc2626; }
        .secondary-btn{ background:#e2e8f0; color:#475569; }

        .status-modal .modal-content{
            border:0;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 25px 70px rgba(15,23,42,.18);
        }

        .status-modal .modal-header{
            background:linear-gradient(135deg,#5b4dff,#3f8cff);
            border:0;
            padding:20px 24px;
            position:relative;
        }

        .status-modal .modal-header::after{
            content:'';
            position:absolute;
            inset:0;
            background:radial-gradient(circle at top right, rgba(255,255,255,.18), transparent 35%);
            pointer-events:none;
        }

        .status-modal .modal-title-wrap{
            display:flex;
            align-items:center;
            gap:14px;
            color:#fff;
        }

        .status-modal .modal-title-icon{
            width:46px;
            height:46px;
            border-radius:14px;
            background:rgba(255,255,255,.16);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
            flex-shrink:0;
        }

        .status-modal .modal-title-text h5{
            margin:0;
            font-weight:700;
            color:#fff;
        }

        .status-modal .modal-title-text p{
            margin:2px 0 0 0;
            font-size:13px;
            opacity:.9;
        }

        .status-modal .modal-body{
            padding:26px 24px;
            background:linear-gradient(180deg,#ffffff 0%, #f8faff 100%);
        }

        .status-modal .task-summary{
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:16px 18px;
            box-shadow:0 8px 24px rgba(15,23,42,.04);
            margin-bottom:18px;
        }

        .status-modal .task-summary label{
            display:block;
            font-size:12px;
            font-weight:700;
            color:#64748b;
            text-transform:uppercase;
            letter-spacing:.5px;
            margin-bottom:6px;
        }

        .status-modal .task-summary .task-name{
            font-size:16px;
            font-weight:700;
            color:#0f172a;
            margin:0;
        }

        .status-modal .current-status{
            margin-top:14px;
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .status-modal .current-status span:first-child{
            font-weight:700;
            color:#334155;
        }

        .status-modal .status-options{
            display:grid;
            grid-template-columns:repeat(2, minmax(0,1fr));
            gap:12px;
        }

        .status-modal .form-check{
            margin:0;
            padding:0;
        }

        .status-modal .status-option{
            position:relative;
            display:flex;
            align-items:center;
            gap:12px;
            width:100%;
            padding:14px 16px;
            border:1px solid #e5e7eb;
            border-radius:16px;
            background:#fff;
            cursor:pointer;
            transition:.2s;
            box-shadow:0 8px 20px rgba(15,23,42,.03);
        }

        .status-modal .status-option:hover{
            transform:translateY(-2px);
            border-color:#c7d2fe;
            box-shadow:0 12px 28px rgba(91,77,255,.10);
        }

        .status-modal .status-option input{
            width:18px;
            height:18px;
            margin:0;
            accent-color:#5b4dff;
        }

        .status-modal .status-option .option-content{
            display:flex;
            flex-direction:column;
            line-height:1.2;
        }

        .status-modal .status-option .option-content strong{
            font-size:14px;
            color:#0f172a;
        }

        .status-modal .status-option .option-content small{
            font-size:12px;
            color:#64748b;
            margin-top:3px;
        }

        .status-modal .modal-footer{
            border:0;
            padding:18px 24px 24px;
            background:#f8faff;
            gap:10px;
        }

        .status-modal .btn-cancel{
            background:#e2e8f0;
            border:0;
            color:#334155;
            border-radius:12px;
            padding:10px 18px;
            font-weight:600;
        }

        .status-modal .btn-save{
            background:linear-gradient(135deg,#5b4dff,#3f8cff);
            border:0;
            border-radius:12px;
            padding:10px 18px;
            font-weight:700;
            box-shadow:0 10px 24px rgba(91,77,255,.22);
        }

        .status-modal .btn-save:hover,
        .status-modal .btn-cancel:hover{
            transform:translateY(-1px);
        }

        @media (max-width: 576px){
            .status-modal .status-options{
                grid-template-columns:1fr;
            }
        }
    </style>
</head>

<body>
    <?php include_once "../../includes/components/preloader.php"; ?>
    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <main class="main-wrapper">
        <?php include_once "../../includes/elements/navbar.php"; ?>

        <section class="section">
            <div class="container-fluid">
                <?php if (isset($_SESSION['success_login'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>Login Successful!</strong>
                        Welcome back, <?php echo $_SESSION['fullname']; ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success_login']); ?>
                <?php } ?>

                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>Success!</strong>
                        <?php echo $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php } ?>

                <div class="title-wrapper pt-30 mb-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2>Dashboard</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    $stats = [
                        ["1", "Pending Tasks", "icon-pending", "lni-cart-full"],
                        ["2", "In-Progress Tasks", "icon-progress", "lni-dollar"],
                        ["3", "Completed Tasks", "icon-completed", "lni-credit-cards"],
                        ["4", "Incomplete Tasks", "icon-incomplete", "lni-cross-circle"]
                    ];

                    foreach ($stats as $s) {
                        $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_status = '$s[0]'"));
                    ?>
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="dashboard-card mb-30">
                                <div class="icon-box <?php echo $s[2]; ?>">
                                    <i class="lni <?php echo $s[3]; ?>"></i>
                                </div>
                                <div class="content">
                                    <h6><?php echo $s[1]; ?></h6>
                                    <h3><?php echo $count; ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="glass-card mb-30">
                    <h6>Overview</h6>

                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Assigned Member</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                            $query = "
                                SELECT tasks_tbl.*, task_status_tbl.status
                                FROM tasks_tbl
                                LEFT JOIN task_status_tbl ON task_status_tbl.status_id = tasks_tbl.task_status
                            ";

                            function can_view_task($conn, $task_id, $user_id, $role): bool
                            {
                                if ($role == "Admin") return true;

                                $task_members = [];
                                $select_task_members = mysqli_query($conn, "SELECT * FROM task_members_tbl LEFT JOIN users_tbl ON users_tbl.user_id = task_members_tbl.user_id WHERE task_members_tbl.task_id = '$task_id'");
                                while ($row = mysqli_fetch_array($select_task_members)) {
                                    $task_members[] = $row['user_id'];
                                }

                                return in_array($user_id, $task_members);
                            }

                            $user_id = $_SESSION['user_id'];
                            $role = $_SESSION['role'];

                            $tasks = mysqli_query($conn, $query);
                            while ($task = mysqli_fetch_array($tasks)) {
                                $status_color = match ((int)$task['task_status']) {
                                    1 => "info-btn",
                                    2 => "active-btn",
                                    3 => "success-btn",
                                    4 => "close-btn",
                                    default => "secondary-btn"
                                };

                                if (can_view_task($conn, $task['task_id'], $user_id, $role)) {
                            ?>
                                <tr>
                                    <td><?php echo $task['task_name']; ?></td>
                                    <td><?php echo $task['task_description']; ?></td>
                                    <td>
                                        <span class="status-btn <?php echo $status_color; ?>">
                                            <?php echo $task['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php
                                            $task_id = $task['task_id'];
                                            $select_members = mysqli_query($conn, "SELECT * FROM task_members_tbl LEFT JOIN users_tbl ON users_tbl.user_id = task_members_tbl.user_id WHERE task_id = '$task_id'");
                                            while ($row = mysqli_fetch_array($select_members)) {
                                            ?>
                                                <div class="text-center mx-1">
                                                    <img class="rounded rounded-circle"
                                                         src="<?php echo get_user_profile_image($conn, $row['user_id']); ?>"
                                                         alt="<?php echo $row['full_name']; ?>"
                                                         title="<?php echo $row['full_name']; ?>"
                                                         style="width: 35px; height: 35px;"/>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action">
                                            <a class="action-btn view-btn"
                                               href="../tasks/task.view.php?id=<?php echo $task['task_id']; ?>">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <a class="action-btn edit-btn" href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#status-modal-<?php echo $task['task_id']; ?>">
                                                <i class="lni lni-popup"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <form action="ctrlData/ctrl.update.status.php?task_id=<?php echo $task['task_id']; ?>" method="POST">
                                    <div class="modal fade status-modal" id="status-modal-<?php echo $task['task_id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title-wrap">
                                                        <div class="modal-title-icon">
                                                            <i class="lni lni-dashboard"></i>
                                                        </div>
                                                        <div class="modal-title-text">
                                                            <h5>Project Status</h5>
                                                            <p>Update task progress with one click</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="task-summary">
                                                        <label>Task</label>
                                                        <p class="task-name"><?php echo $task['task_name']; ?></p>

                                                        <div class="current-status">
                                                            <span>Current Status:</span>
                                                            <span class="status-btn <?php echo $status_color; ?>">
                                                                <?php echo $task['status']; ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="status-options">
                                                        <?php
                                                        $status_list = mysqli_query($conn, "SELECT * FROM task_status_tbl");
                                                        while ($st = mysqli_fetch_array($status_list)) {
                                                        ?>
                                                            <div class="form-check">
                                                                <label class="status-option">
                                                                    <input type="radio" name="taskstatus"
                                                                           value="<?php echo $st['status_id']; ?>" required
                                                                           <?php if ($task['task_status'] == $st['status_id']) echo "checked"; ?>>
                                                                    <div class="option-content">
                                                                        <strong><?php echo $st['status']; ?></strong>
                                                                        <small>Select this to update status</small>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-save">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>
</html>

