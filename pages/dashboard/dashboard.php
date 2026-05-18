<?php include "../../includes/conn.php"; ?>
<?php include "../../includes/session.start.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Dashboard</title>

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
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="#0">Dashboard</a>
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
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon info">
                                <i class="lni lni-cart-full"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Pending Tasks</h6>
                                <h3 class="text-bold mb-10">
                                    <?php
                                    $select_pending_tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_status = '1'");
                                    $pending_tasks_count = mysqli_num_rows($select_pending_tasks);
                                    echo $pending_tasks_count;
                                    ?>
                                </h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon primary">
                                <i class="lni lni-dollar"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">In-Progress Tasks</h6>
                                <h3 class="text-bold mb-10">
                                    <?php
                                    $select_inprogress_tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_status = '2'");
                                    $inprogress_tasks_count = mysqli_num_rows($select_inprogress_tasks);
                                    echo $inprogress_tasks_count;
                                    ?>
                                </h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon success">
                                <i class="lni lni-credit-cards"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Completed Tasks</h6>
                                <h3 class="text-bold mb-10">
                                    <?php
                                    $select_completed_tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_status = '3'");
                                    $completed_tasks_count = mysqli_num_rows($select_completed_tasks);
                                    echo $completed_tasks_count;
                                    ?>
                                </h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon danger">
                                <i class="lni lni-cross-circle"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Incomplete Tasks</h6>
                                <h3 class="text-bold mb-10">
                                    <?php
                                    $select_incompleted_tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_status = '4'");
                                    $incompleted_tasks_count = mysqli_num_rows($select_incompleted_tasks);
                                    echo $incompleted_tasks_count;
                                    ?>
                                </h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">

                            <h6 class="mb-10">Overview</h6>

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
                                        $query = "SELECT * FROM tasks_tbl LEFT JOIN task_status_tbl ON task_status_tbl.status_id = tasks_tbl.task_status LEFT JOIN users_tbl ON users_tbl.user_id = tasks_tbl.assigned_user_id";
                                        if ($_SESSION['role'] == "Member") {
                                            $user_id = $_SESSION['user_id'];
                                            $query .= " WHERE assigned_user_id = '$user_id'";
                                        }

                                        $tasks = mysqli_query($conn, $query );
                                        while ($task = mysqli_fetch_array($tasks)) {
                                            ?>
                                            <tr>
                                                <td class="min-width">
                                                    <p>
                                                        <?php echo $task['task_name']; ?>
                                                    </p>
                                                </td>
                                                <td class="min-width">
                                                    <p>
                                                        <?php echo $task['task_description']; ?>
                                                    </p>
                                                </td>
                                                <td class="min-width">
                                                    <?php
                                                    $status_color = match ((int) $task['task_status']) {
                                                        1 => "info-btn",
                                                        2 => "active-btn",
                                                        3 => "success-btn",
                                                        4 => "close-btn",
                                                    };
                                                    ?>
                                                    <span class="status-btn <?php echo $status_color; ?>">
                                                        <?php echo $task['status']; ?>
                                                    </span>
                                                </td>
                                                <td class="min-width">
                                                    <p>
                                                        <?php
                                                        $assigned_member = "None";
                                                        if (isset($task['assigned_user_id']) && (int) $task['assigned_user_id'] != 0) {
                                                            $assigned_member = $task['full_name'];
                                                        }
                                                        echo $assigned_member;
                                                        ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="action">
                                                        <!-- Trigger Button -->
                                                        <a class="text-primary lni lni-popup" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#status-modal-<?php echo $task['task_id']; ?>"></a>
                                                    </div>
                                                </td>
                                                <!-- Modal Container -->
                                                <form
                                                    action="ctrlData/ctrl.update.status.php?task_id=<?php echo $task['task_id']; ?>"
                                                    method="POST">
                                                    <div class="modal fade" id="status-modal-<?php echo $task['task_id']; ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary">
                                                                    <h5 class="modal-title text-white">Project Status</h5>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>Task: </strong>
                                                                        <span>
                                                                            <?php echo $task['task_name']; ?>
                                                                        </span>
                                                                    </p>
                                                                    <p><strong>Assigned Member: </strong>
                                                                        <span>
                                                                            <?php echo $task['full_name']; ?>
                                                                        </span>
                                                                    </p>
                                                                    <p><strong>Current Status: </strong>
                                                                        <span
                                                                            class="status-btn <?php echo $status_color; ?>">
                                                                            <?php echo $task['status']; ?>
                                                                        </span>
                                                                    </p>
                                                                    <hr>
                                                                    <p><strong>Set Status</strong></p>
                                                                    <div class="row mb-2">
                                                                        <?php
                                                                        $task_statuses = mysqli_query($conn, "SELECT * FROM task_status_tbl");
                                                                        while ($task_status = mysqli_fetch_array($task_statuses)) {
                                                                            ?>
                                                                            <div class="col">
                                                                                <div class="form-check radio-style mb-20">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        value="<?php echo $task_status['status_id'] ?>"
                                                                                        id="statusradio-<?php echo $task_status['status_id'] ?>"
                                                                                        name="taskstatus" required <?php if ($task['task_status'] == $task_status['status_id'])
                                                                                            echo "checked"; ?> />
                                                                                    <label class="form-check-label"
                                                                                        for="statusradio-<?php echo $task_status['status_id'] ?>">
                                                                                        <?php echo $task_status['status'] ?>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        name="submit">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
                </div>

            </div>
        </section>

        <?php include_once "../../includes/elements/footer.php"; ?>

    </main>

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>