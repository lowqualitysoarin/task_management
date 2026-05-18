<?php include "../../includes/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<style>
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background: #fff;
        margin: 5% auto;
        width: 40%;
        border-radius: 10px;
        overflow: hidden;
        animation: modalZoom 0.3s;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    }

    .custom-modal-header {
        padding: 15px 20px;
        background: #365CF5;
        color: #fff;
        position: relative;
    }

    .close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 26px;
        cursor: pointer;
        transition: 0.2s;
    }

    .close:hover {
        color: #ffdddd;
        transform: scale(1.1);
    }

    .custom-modal-body {
        padding: 20px;
    }

    .custom-modal-footer {
        padding: 15px 20px;
        text-align: right;
    }

    .modal-close-btn {
        background: #e74c3c;
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    @keyframes modalZoom {
        from {
            transform: scale(0.7);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .custom-modal-content {
            width: 90%;
        }
    }
</style>

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
                            <div class="icon purple">
                                <i class="lni lni-cart-full"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">New Orders</h6>
                                <h3 class="text-bold mb-10">34567</h3>
                                <p class="text-sm text-success">
                                    <i class="lni lni-arrow-up"></i> +2.00%
                                    <span class="text-gray">(30 days)</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon success">
                                <i class="lni lni-dollar"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Total Income</h6>
                                <h3 class="text-bold mb-10">$74,567</h3>
                                <p class="text-sm text-success">
                                    <i class="lni lni-arrow-up"></i> +5.45%
                                    <span class="text-gray">Increased</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon primary">
                                <i class="lni lni-credit-cards"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Total Expense</h6>
                                <h3 class="text-bold mb-10">$24,567</h3>
                                <p class="text-sm text-danger">
                                    <i class="lni lni-arrow-down"></i> -2.00%
                                    <span class="text-gray">Expense</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon orange">
                                <i class="lni lni-user"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">New User</h6>
                                <h3 class="text-bold mb-10">34567</h3>
                                <p class="text-sm text-danger">
                                    <i class="lni lni-arrow-down"></i> -25.00%
                                    <span class="text-gray"> Earning</span>
                                </p>
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
                                                <h6>#</h6>
                                            </th>
                                            <th>
                                                <h6>Name</h6>
                                            </th>
                                            <th>
                                                <h6>Email</h6>
                                            </th>
                                            <th>
                                                <h6>Project</h6>
                                            </th>
                                            <th>
                                                <h6>Status</h6>
                                            </th>
                                            <th>
                                                <h6>Action</h6>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td>
                                                <div class="employee-image">
                                                    <img src="../../assets/images/lead/lead-1.png">
                                                </div>
                                            </td>

                                            <td>
                                                <p>Esther Howard</p>
                                            </td>
                                            <td>
                                                <p><a href="#">yourmail@gmail.com</a></p>
                                            </td>
                                            <td>
                                                <p>Admin Dashboard Design</p>
                                            </td>

                                            <td>
                                                <span class="status-btn active-btn"
                                                    id="currentStatusText-1">Active</span>
                                            </td>

                                            <td>
                                                <div class="action">
                                                    <button class="text-primary border-0 bg-transparent"
                                                        onclick="openModal(1, 'Esther Howard', 'Admin Dashboard Design', 1)">
                                                        <i class="lni lni-popup"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= MODAL ================= -->
        <div id="statusModal" class="custom-modal">

            <div class="custom-modal-content">

                <div class="custom-modal-header">
                    <p class="close" onclick="closeModal()">&times;</p>
                    <h4 class="text-white">Project Status</h4>
                </div>

                <div class="custom-modal-body">

                    <input type="hidden" id="task_id">

                    <p><strong>Employee:</strong> <span id="emp_name"></span></p>
                    <p><strong>Project:</strong> <span id="project_name"></span></p>

                    <div class="mb-3">
                        <strong>Current Status:</strong>
                        <span class="status-btn active-btn" id="modalCurrentStatus">Active</span>
                    </div>

                    <hr>

                    <div class="row">

                        <?php
                        $task_statuses = mysqli_query($conn, "SELECT * FROM task_status_tbl");

                        while ($task_status = mysqli_fetch_array($task_statuses)) {
                            ?>

                            <div class="col-md-6">
                                <div class="form-check radio-style mb-20">

                                    <input class="form-check-input" type="radio" name="taskstatus"
                                        value="<?php echo $task_status['status_id']; ?>"
                                        id="status-<?php echo $task_status['status_id']; ?>">

                                    <label class="form-check-label" for="status-<?php echo $task_status['status_id']; ?>">

                                        <?php echo $task_status['status']; ?>
                                    </label>

                                </div>
                            </div>

                        <?php } ?>

                    </div>

                </div>

                <div class="custom-modal-footer">

                    <button class="main-btn success-btn btn-hover" onclick="updateStatus()">
                        Update Status
                    </button>

                    <button class="main-btn primary-btn btn-hover" onclick="closeModal()">
                        Close
                    </button>

                </div>

            </div>
        </div>

        <?php include_once "../../includes/elements/footer.php"; ?>

    </main>

    <?php include_once "../../includes/components/scripts.php"; ?>

    <script>

        const modal = document.getElementById("statusModal");

        function openModal(task_id, emp_name, project_name, current_status) {

            modal.style.display = "block";

            document.getElementById("task_id").value = task_id;
            document.getElementById("emp_name").innerText = emp_name;
            document.getElementById("project_name").innerText = project_name;

            document.getElementById("modalCurrentStatus").innerText = "Loading...";

            let radios = document.getElementsByName("taskstatus");

            radios.forEach(r => {
                r.checked = (r.value == current_status);
            });

            document.getElementById("modalCurrentStatus").innerText = "Current Selected";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target === modal) {
                closeModal();
            }
        }

        function updateStatus() {

            let task_id = document.getElementById("task_id").value;
            let selected = document.querySelector('input[name="taskstatus"]:checked');

            if (!selected) {
                alert("Please select a status.");
                return;
            }

            let status_id = selected.value;

            fetch("update_status.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "task_id=" + task_id + "&status_id=" + status_id
            })
                .then(res => res.text())
                .then(response => {

                    // update UI instantly (no reload)
                    document.getElementById("currentStatusText-" + task_id).innerText =
                        selected.nextElementSibling.innerText;

                    closeModal();
                });

        }

    </script>
</body>

</html>