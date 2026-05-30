<?php include "../../includes/conn.php"; ?>
<?php include "../../includes/session.start.php"; ?>

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

<bodyx>

<?php include_once "../../includes/components/preloader.php"; ?>
<?php include_once "../../includes/elements/sidebar.php"; ?>

<main class="main-wrapper">

<?php include_once "../../includes/elements/navbar.php"; ?>

<section class="section">
<div class="container-fluid">
    <?php if(isset($_SESSION['success_login'])) { ?>
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>Login Successful!</strong>
    Welcome back, <?php echo $_SESSION['fullname']; ?>.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success_login']); ?>
<?php } ?>

<?php if(isset($_SESSION['success'])) { ?>
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <strong>Success!</strong>
    <?php echo $_SESSION['success']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); ?>
<?php } ?>

<!-- TITLE -->
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Dashboard</h2>
        </div>
    </div>
</div>

<!-- STATS -->
<div class="row">

<?php
$stats = [
    ["1", "Pending Tasks", "info", "lni-cart-full"],
    ["2", "In-Progress Tasks", "primary", "lni-dollar"],
    ["3", "Completed Tasks", "success", "lni-credit-cards"],
    ["4", "Incomplete Tasks", "danger", "lni-cross-circle"]
];

foreach ($stats as $s) {
    $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_status = '$s[0]'"));
?>
<div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="icon-card mb-30">
        <div class="icon <?php echo $s[2]; ?>">
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

<!-- TABLE -->
<div class="card-style mb-30">
<h6>Overview</h6>

<div class="table-wrapper table-responsive">
<table class="table">

<thead>
<tr>
    <th>Task</th>
    <th>Description</th>
    <th>Status</th>
    <th>Assigned Member</th>
    <th>View Task</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$query = "
SELECT tasks_tbl.*, task_status_tbl.status, users_tbl.full_name
FROM tasks_tbl
LEFT JOIN task_status_tbl ON task_status_tbl.status_id = tasks_tbl.task_status
LEFT JOIN users_tbl ON users_tbl.user_id = tasks_tbl.assigned_user_id
";

if (isset($_SESSION['role']) && $_SESSION['role'] == "Member") {
    $user_id = $_SESSION['user_id'];
    $query .= " WHERE assigned_user_id = '$user_id'";
}

$tasks = mysqli_query($conn, $query);

while ($task = mysqli_fetch_array($tasks)) {

$status_color = match ((int)$task['task_status']) {
    1 => "info-btn",
    2 => "active-btn",
    3 => "success-btn",
    4 => "close-btn",
    default => "secondary-btn"
};

$assigned_member = (!empty($task['full_name'])) ? $task['full_name'] : "None";
?>

<tr>

    <td><?php echo $task['task_name']; ?></td>

    <td><?php echo $task['task_description']; ?></td>

    <td>
        <span class="status-btn <?php echo $status_color; ?>">
            <?php echo $task['status']; ?>
        </span>
    </td>

    <td><?php echo $assigned_member; ?></td>

    <!-- VIEW TASK (ICON ONLY) -->
    <td>
        <div class="action">
            <a class="text-success lni lni-eye"
               href="../tasks/task.view.php?id=<?php echo $task['task_id']; ?>">
            </a>
        </div>
    </td>

    <!-- ACTION ONLY -->
    <td>
        <div class="action">
            <a class="text-primary lni lni-popup"
               href="#"
               data-bs-toggle="modal"
               data-bs-target="#status-modal-<?php echo $task['task_id']; ?>">
            </a>
        </div>
    </td>

</tr>

<!-- STATUS MODAL -->
<form action="ctrlData/ctrl.update.status.php?task_id=<?php echo $task['task_id']; ?>" method="POST">

<div class="modal fade" id="status-modal-<?php echo $task['task_id']; ?>" tabindex="-1">

<div class="modal-dialog modal-dialog-centered modal-lg">

<div class="modal-content">

<div class="modal-header bg-primary">
    <h5 class="modal-title text-white">Project Status</h5>
</div>

<div class="modal-body">

<p><strong>Task:</strong> <?php echo $task['task_name']; ?></p>

<p><strong>Assigned:</strong> <?php echo $assigned_member; ?></p>

<p><strong>Status:</strong>
    <span class="status-btn <?php echo $status_color; ?>">
        <?php echo $task['status']; ?>
    </span>
</p>

<hr>

<?php
$status_list = mysqli_query($conn, "SELECT * FROM task_status_tbl");
while ($st = mysqli_fetch_array($status_list)) {
?>
<div class="form-check">
    <input type="radio"
           name="taskstatus"
           value="<?php echo $st['status_id']; ?>"
           required
           <?php if ($task['task_status'] == $st['status_id']) echo "checked"; ?>>
    <label><?php echo $st['status']; ?></label>
</div>
<?php } ?>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" name="submit" class="btn btn-primary">Save</button>
</div>

</div>

</div>

</div>

</form>

<?php } ?>

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