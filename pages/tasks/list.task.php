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
<title>List Tasks</title>

<?php include_once "../../includes/components/links.php"; ?>

<style>

/* =========================
   DESIGN SYSTEM 
========================= */
:root{
    --primary:#5b4dff;
    --secondary:#3f8cff;
    --border:#e5e7eb;
    --muted:#64748b;
}

body{
    background:#f5f7ff;
}

/* =========================
   PAGE HEADER 
========================= */
.page-header{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    border-radius:18px;
    padding:20px 25px;
    color:#fff;
    display:flex;
    align-items:center;
    gap:15px;
    box-shadow:0 10px 25px rgba(91,77,255,.20);
    margin-top:20px;
}

.header-icon{
    width:60px;
    height:60px;
    border-radius:16px;
    background:rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}


.header-title{
    font-size:1.5rem;
    font-weight:700;
    margin:0;
    color:#ffffff;
    letter-spacing:.3px;
}

.header-subtitle{
    margin:0;
    font-size:.85rem;
    color:rgba(255,255,255,.85);
}

/* =========================
   MAIN CARD
========================= */
.glass-card{
    background:#fff;
    border-radius:18px;
    padding:18px;
    margin-top:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

/* =========================
   TABLE
========================= */
.table{
    border-collapse:separate;
    border-spacing:0 12px;
}

.table thead th{
    font-size:12px;
    color:#94a3b8; 
    text-transform:uppercase;
    letter-spacing:.5px;
    border:none !important;
    padding:10px;
}

.table tbody tr{
    background:#fff;
    box-shadow:0 6px 18px rgba(0,0,0,.05);
    border-radius:14px;
    transition:.2s ease;
}

.table tbody tr:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(0,0,0,.08);
}

.table td{
    border:none !important;
    vertical-align:middle;
    padding:14px;
}

/* =========================
   TASK TEXT STYLE 
========================= */
.task-name{
    font-weight:600;
    color:#1f2937; 
}

.task-desc{
    font-size:13px;
    color:#64748b;
}

/* =========================
   STATUS BADGE
========================= */
.status-btn{
    padding:5px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.info-btn{ background:rgba(91,77,255,.12); color:var(--primary); }
.active-btn{ background:rgba(63,140,255,.12); color:var(--secondary); }
.success-btn{ background:rgba(34,197,94,.12); color:#22c55e; }
.close-btn{ background:rgba(239,68,68,.12); color:#ef4444; }

/* =========================
   MEMBERS 
========================= */
.member-img{
    width:34px;
    height:34px;
    border-radius:50%;
    border:2px solid #eef2ff;
    margin-left:-6px;
    transition:.2s;
}

.member-img:first-child{
    margin-left:0;
}

/* =========================
   ACTION BUTTONS 
========================= */
.action{
    display:flex;
    align-items:center;
    gap:10px;
}

.action-btn{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    transition:.2s ease;
    text-decoration:none;
}

.action-btn:hover{
    transform:translateY(-2px);
}

.view{ background:#ecfdf5; color:#10b981; }
.edit{ background:#eff6ff; color:#3b82f6; }
.delete{ background:#fef2f2; color:#ef4444; border:none; }

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
        <i class="lni lni-list"></i>
    </div>

    <div>
        <h2 class="header-title">List Tasks</h2>
        <p class="header-subtitle">Manage tasks, status and assigned team members</p>
    </div>
</div>

<!-- TABLE -->
<div class="glass-card">

<div class="table-responsive">
<table class="table">

<thead>
<tr>
    <th>Task</th>
    <th>Description</th>
    <th>Status</th>
    <th>Members</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$tasks = mysqli_query($conn,"
SELECT * FROM tasks_tbl
LEFT JOIN task_status_tbl
ON task_status_tbl.status_id = tasks_tbl.task_status
");

while ($task = mysqli_fetch_array($tasks)) {
?>

<tr>

<td>
<div class="task-name"><?= $task['task_name']; ?></div>
</td>

<td>
<div class="task-desc"><?= $task['task_description']; ?></div>
</td>

<td>
<?php
$status_color = match ((int)$task['task_status']) {
    1 => "info-btn",
    2 => "active-btn",
    3 => "success-btn",
    4 => "close-btn",
};
?>
<span class="status-btn <?= $status_color; ?>">
    <?= $task['status']; ?>
</span>
</td>

<td>
<div class="d-flex align-items-center">

<?php
$task_id = $task['task_id'];

$select_members = mysqli_query($conn,"
SELECT * FROM task_members_tbl 
LEFT JOIN users_tbl 
ON users_tbl.user_id = task_members_tbl.user_id
WHERE task_id = '$task_id'
");

while ($row = mysqli_fetch_array($select_members)) {
?>
    <img class="member-img"
         src="<?= get_user_profile_image($conn,$row['user_id']); ?>"
         title="<?= $row['full_name']; ?>">
<?php } ?>

</div>
</td>

<td>

<div class="action">

<a class="action-btn view"
   href="task.view.php?id=<?= $task['task_id']; ?>">
   <i class="lni lni-eye"></i>
</a>

<a class="action-btn edit"
   href="edit.task.php?task_id=<?= $task['task_id']; ?>">
   <i class="lni lni-pencil"></i>
</a>

<a class="action-btn delete"
   href="ctrlData/ctrl.delete.task.php?task_id=<?= $task['task_id']; ?>">
   <i class="lni lni-trash-can"></i>
</a>

</div>

</td>

</tr>

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