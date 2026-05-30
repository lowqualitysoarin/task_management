<?php 
include "../../includes/conn.php";

if(!isset($_GET['id'])){
    die("Task ID not found.");
}

$task_id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query($conn, "
    SELECT tasks_tbl.*, users_tbl.full_name
    FROM tasks_tbl
    LEFT JOIN users_tbl 
    ON tasks_tbl.assigned_user_id = users_tbl.user_id
    WHERE task_id = '$task_id'
");

$task = mysqli_fetch_assoc($query);

if(!$task){
    die("Task not found.");
}

// STATUS
switch($task['task_status']){
    case 1:
        $statusText="Pending";
        $statusClass="pending";
    break;

    case 2:
        $statusText="In Progress";
        $statusClass="ongoing";
    break;

    case 3:
        $statusText="Completed";
        $statusClass="done";
    break;

    case 4:
        $statusText="Incomplete";
        $statusClass="urgent";
    break;

    default:
        $statusText="Unknown";
        $statusClass="pending";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Task View</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

<style>

/* =========================
   GLOBAL
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f7fb;
    color:#1f2937;
}

/* =========================
   WRAPPER
========================= */

.wrapper{
    max-width:1400px;
    margin:auto;
    padding:30px;
}

/* =========================
   TOPBAR
========================= */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.back-btn{
    text-decoration:none;
    color:#555;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:8px;
}

.back-btn:hover{
    color:#4f46e5;
}

/* =========================
   HEADER
========================= */

.header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:30px;
    flex-wrap:wrap;
}

.title-area h1{
    font-size:38px;
    margin-bottom:10px;
}

.title-area p{
    color:#6b7280;
    font-size:15px;
    line-height:1.7;
}

/* STATUS BADGE */

.status-badge{
    padding:14px 24px;
    border-radius:14px;
    color:#fff;
    font-weight:bold;
    font-size:15px;
    min-width:180px;
    text-align:center;
}

.pending{
    background:#f59e0b;
}

.ongoing{
    background:#4f46e5;
}

.done{
    background:#10b981;
}

.urgent{
    background:#ef4444;
}

/* =========================
   TAGS
========================= */

.tags{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:25px;
}

.tag{
    background:#eef2ff;
    color:#4f46e5;
    padding:10px 16px;
    border-radius:12px;
    font-size:13px;
    font-weight:600;
}

/* =========================
   GRID
========================= */

.content-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
}

@media(max-width:992px){
    .content-grid{
        grid-template-columns:1fr;
    }
}

/* =========================
   CARD
========================= */

.card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    margin-bottom:25px;
}

.card-title{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:20px;
    font-size:20px;
    font-weight:bold;
}

.card-title i{
    color:#4f46e5;
    font-size:22px;
}

/* =========================
   DESCRIPTION
========================= */

.description{
    line-height:1.9;
    color:#4b5563;
    font-size:15px;
}

/* =========================
   INFO LIST
========================= */

.info-list{
    display:flex;
    flex-direction:column;
    gap:20px;
}

.info-item{
    display:flex;
    justify-content:space-between;
    gap:15px;
    border-bottom:1px solid #eee;
    padding-bottom:15px;
}

.info-item:last-child{
    border:none;
    padding-bottom:0;
}

.info-label{
    color:#6b7280;
    font-size:14px;
}

.info-value{
    font-weight:600;
    text-align:right;
}

/* =========================
   IMAGE GALLERY
========================= */

.gallery{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
    gap:18px;
}

.image-card{
    background:#f9fafb;
    border-radius:18px;
    overflow:hidden;
    transition:0.3s;
    cursor:pointer;
    border:1px solid #ececec;
}

.image-card:hover{
    transform:translateY(-5px);
}

.image-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.image-info{
    padding:12px;
}

.image-name{
    font-size:13px;
    font-weight:600;
    margin-bottom:4px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.image-size{
    font-size:12px;
    color:#888;
}

/* =========================
   EMPTY IMAGE
========================= */

.no-image{
    background:#f9fafb;
    border:2px dashed #ddd;
    border-radius:16px;
    padding:50px;
    text-align:center;
    color:#9ca3af;
}

.no-image i{
    font-size:55px;
    margin-bottom:10px;
}

/* =========================
   LIGHTBOX
========================= */

.lightbox{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.9);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
    padding:20px;
}

.lightbox img{
    max-width:90%;
    max-height:90%;
    border-radius:15px;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .wrapper{
        padding:20px;
    }

    .title-area h1{
        font-size:28px;
    }

    .status-badge{
        width:100%;
    }

}

</style>
</head>

<body>

<div class="wrapper">

    <!-- TOPBAR -->
    <div class="topbar">
        <a href="../dashboard/dashboard.php" class="back-btn">
            <i class="las la-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- HEADER -->
    <div class="header">

        <div class="title-area">

            <h1>
                <?php echo htmlspecialchars($task['task_name']); ?>
            </h1>

            <p>
                Detailed task overview and attachment preview for assigned members.
            </p>

        </div>

        <div class="status-badge <?php echo $statusClass; ?>">
            <?php echo $statusText; ?>
        </div>

    </div>

    <!-- TAGS -->
    <div class="tags">

        <div class="tag">
            Task #<?php echo $task['task_id']; ?>
        </div>

        <div class="tag">
            Assigned Task
        </div>

        <div class="tag">
            Project Management
        </div>

    </div>

    <!-- GRID -->
    <div class="content-grid">

        <!-- LEFT -->
        <div>

            <!-- DESCRIPTION -->
            <div class="card">

                <div class="card-title">
                    <i class="las la-file-alt"></i>
                    Description
                </div>

                <div class="description">
                    <?php echo nl2br(htmlspecialchars($task['task_description'])); ?>
                </div>

            </div>

            <!-- ATTACHMENTS -->
            <div class="card">

                <div class="card-title">
                    <i class="las la-paperclip"></i>
                    Attachments
                </div>

                <?php if(!empty($task['task_image'])) { ?>

                    <div class="gallery">

                        <div class="image-card"
                             onclick="openImage('../../uploads/<?php echo $task['task_image']; ?>')">

                            <img src="../../uploads/<?php echo $task['task_image']; ?>">

                            <div class="image-info">

                                <div class="image-name">
                                    <?php echo $task['task_image']; ?>
                                </div>

                                <div class="image-size">
                                    Uploaded Image
                                </div>

                            </div>

                        </div>

                    </div>

                <?php } else { ?>

                    <div class="no-image">

                        <i class="las la-image"></i>

                        <p>No attachment uploaded.</p>

                    </div>

                <?php } ?>

            </div>

        </div>

        <!-- RIGHT -->
        <div>

            <!-- TASK INFO -->
            <div class="card">

                <div class="card-title">
                    <i class="las la-info-circle"></i>
                    Task Information
                </div>

                <div class="info-list">

                    <div class="info-item">
                        <div class="info-label">Assigned Member</div>
                        <div class="info-value">
                            <?php echo $task['full_name'] ?: 'No Assignee'; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Task ID</div>
                        <div class="info-value">
                            #<?php echo $task['task_id']; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <?php echo $statusText; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Attachment</div>
                        <div class="info-value">
                            <?php echo !empty($task['task_image']) ? 'Available' : 'None'; ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" onclick="closeImage()">
    <img id="preview-image">
</div>

<script>

function openImage(src){

    document.getElementById("lightbox").style.display = "flex";

    document.getElementById("preview-image").src = src;
}

function closeImage(){

    document.getElementById("lightbox").style.display = "none";
}

</script>

</body>
</html>