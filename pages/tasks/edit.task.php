<?php include "../../includes/conn.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Add Task</title>

    <?php include_once "../../includes/components/links.php"; ?>
</head>

<body>
    <?php include_once "../../includes/components/preloader.php"; ?>

    <?php include_once "../../includes/elements/sidebar.php"; ?>
    <?php
    if (!isset($_GET['task_id'])) {
        header("location: ../list.task.php");
        exit();
    }

    $task_id = $_GET['task_id'];

    $select_task = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_id = '$task_id'");
    $task = mysqli_fetch_array($select_task);
    ?>

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
                                <h2>Add Task</h2>
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
                                            Add Task
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

                <form action="ctrlData/ctrl.update.task.php?task_id=<?php echo $task_id; ?>"
                    class="form-elements wrapper" method="POST">
                    <div class="form-elements-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- input style start -->
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Task</h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-style-1">
                                                <label>Task Name</label>
                                                <input type="text" placeholder="Task Name" name="taskname"
                                                    value="<?php echo $task['task_name']; ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Task Description</label>
                                            <div class="input-style-3">
                                                <textarea type="text" placeholder="Task Description"
                                                    name="taskdescription"
                                                    rows="5"><?php echo $task['task_description']; ?></textarea>
                                                <span class="icon"><i class="lni lni-text-format"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-25">Assign Member</h6>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <div class="select-style-1">
                                                <label>Select Member</label>
                                                <div class="select-position">
                                                    <select class="light-bg" name="assignedmember">
                                                        <option value="0" <?php if ($task['assigned_user_id'] == 0) echo "checked"; ?>>None</option>
                                                        <?php
                                                        $select_users = mysqli_query($conn, "SELECT * FROM users_tbl LEFT JOIN roles_tbl ON roles_tbl.role_id = users_tbl.role");
                                                        while ($user = mysqli_fetch_array($select_users)) {
                                                            if ($user['role'] != "Admin") {
                                                                ?>
                                                                <option value="<?php echo $user['user_id']; ?>" <?php
                                                                   if ($task['assigned_user_id'] == $user['user_id'])
                                                                       echo "checked";
                                                                   ?>>
                                                                    <?php echo $user['full_name'] ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-25">Status</h6>
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
                                                        <?php echo $task_status['status'] ?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" style="height: 50px;  " class="btn btn-primary"
                                                name="submit">Update
                                                Task</button>
                                        </div>
                                    </div>
                                    <!-- end input -->
                                </div>
                                <!-- end card -->
                                <!-- ======= input style end ======= -->
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </form>
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