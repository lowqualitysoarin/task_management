<?php require_once '../../includes/conn.php'; ?>

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

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>List Users</h2>
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
                                            List Users
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
                    <div class="card-style mb-30">
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <h6>Task</h6>
                                        </th>
                                        <th>
                                            <h6>Task Description</h6>
                                        </th>
                                        <th>
                                            <h6>Status</h6>
                                        </th>
                                        <th>
                                            <h6>Assigned Member</h6>
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
                                    $tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl LEFT JOIN task_status_tbl ON task_status_tbl.status_id = tasks_tbl.task_status LEFT JOIN users_tbl ON users_tbl.user_id = tasks_tbl.assigned_user_id");
                                    while ($task = mysqli_fetch_array($tasks)) {
                                        ?>
                                        <tr>
                                            <td class="min-width">
                                                <p><?php echo $task['task_name']; ?></p>
                                            </td>
                                            <td class="min-width">
                                                <p><?php echo $task['task_description']; ?></p>
                                            </td>
                                            <td class="min-width">
                                                <?php
                                                $status_color = match ((int)$task['task_status']) {
                                                    1 => "info-btn",
                                                    2 => "active-btn",
                                                    3 => "success-btn",
                                                    4 => "close-btn",
                                                };
                                                ?>
                                                <span class="status-btn <?php echo $status_color; ?>"><?php echo $task['status']; ?></span>
                                            </td>
                                            <td class="min-width">
                                                <p>
                                                    <?php
                                                    if (isset($task['assigned_user_id']) && (int)$task['assigned_user_id'] != 0) {
                                                        echo $task['full_name'];
                                                    } else {
                                                        echo "None";
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                            <td>
                                                <div class="action">
                                                    <button class="text-primary">
                                                        <a href="edit.task.php?task_id=<?php echo $task['task_id']; ?>"
                                                            class="lni lni-pencil"></a>
                                                    </button>
                                                    <button class="text-danger">
                                                        <a href="ctrlData/ctrl.delete.task.php?task_id=<?php echo $task['task_id']; ?>"
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
    <!-- ======== main-wrapper end =========== -->

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>