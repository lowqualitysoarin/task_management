<?php
function get_user_profile_image($conn, $user_id) : string {
    $all_users = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
    $user = mysqli_fetch_array($all_users);

    if (!isset($user['profile'])) {
        return "../../assets/images/lead/lead-1.png";
    }
    return "/task_management/" . $user['profile'];
}

function get_task_attachment_image($conn, $task_id) : string {
    $all_tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl WHERE task_id = '$task_id'");
    $task = mysqli_fetch_array($all_tasks);

    if (isset($task['task_image'])) {
        return "/task_management/uploads/attachments/" .  $task['task_image'];
    }
    return null;
}