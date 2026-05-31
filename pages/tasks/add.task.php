<?php require_once "../../includes/conn.php"; ?>
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
    <title>Task Management | Add Task</title>

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

                <form action="ctrlData/ctrl.add.task.php" class="form-elements wrapper" method="POST"
                    enctype="multipart/form-data">
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
                                                <input type="text" placeholder="Task Name" name="taskname" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-style-3">
                                                <label>Task Description</label>
                                                <div class="input-style-3">
                                                    <textarea type="text" placeholder="Task Description"
                                                        name="taskdescription" rows="5"></textarea>
                                                    <span class="icon"><i class="lni lni-text-format"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="input-style-1">
                                                <label>Attachment</label>

                                                <input type="file" name="attachment"
                                                    accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">

                                                <small class="text-muted">
                                                    Allowed: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-25">Assign Member</h6>
                                    <div class="row">
                                        <div class="col mb-1">
                                            <div class="select-style-1">
                                                <label>Select Member</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary col-md-2" style="height: 50px;"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Select Assignees
                                                    </button>
                                                    <ul class="dropdown-menu overflow-auto" style="max-height: 200px;">
                                                        <?php
                                                        $select_users = mysqli_query($conn, "SELECT * FROM users_tbl LEFT JOIN roles_tbl ON roles_tbl.role_id = users_tbl.role");
                                                        while ($user = mysqli_fetch_array($select_users)) {
                                                            if ($user['role'] != "Admin") {
                                                                ?>
                                                                <li>
                                                                    <?php
                                                                    $checkbox_id = "assignee" . (string) $user['user_id'];
                                                                    ?>
                                                                    <div class="form-check form-check-inline m-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="<?php echo $checkbox_id; ?>"
                                                                            value="<?php echo $user['user_id']; ?>"
                                                                            name="assignees[]">
                                                                        <label for="<?php echo $checkbox_id; ?>"
                                                                            class="form-check-label"><?php echo $user['full_name']; ?></label>
                                                                    </div>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" style="height: 50px;" class="btn btn-primary col-md-1"
                                                name="submit">Add
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
        </section>
        <!-- ========== section end ========== -->

        <?php include_once "../../includes/elements/footer.php"; ?>
    </main>
    <!-- ======== main-wrapper end =========== -->

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>