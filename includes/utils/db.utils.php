<?php
function is_member_assigned_in_task($conn, $user_id, $task): bool
{
    $task_members = [];
    $task_id = $task['task_id'];

    $select_task_members = mysqli_query($conn, "SELECT user_id FROM task_members_tbl WHERE task_id = '$task_id'");
    while ($row = mysqli_fetch_array($select_task_members)) {
        $task_members[] = $row['user_id'];
    }

    if (in_array($user_id, $task_members)) {
        return true;
    }
    return false;
}

function get_member_tasks($conn, $user_id) : array {
    $out = [];
    $tasks = mysqli_query($conn, "SELECT * FROM tasks_tbl LEFT JOIN task_status_tbl ON task_status_tbl.status_id = tasks_tbl.task_status");
    while ($task = mysqli_fetch_array($tasks)) {
        if (is_member_assigned_in_task($conn, $user_id, $task)) {
            $out[] = $task;
        }
    }
    return $out;
}

function can_view_task($conn, $task_id, $user_id, $role): bool
{
    if ($role == "Admin")
        return true;

    $task_members = [];
    $select_task_members = mysqli_query($conn, "SELECT * FROM task_members_tbl LEFT JOIN users_tbl ON users_tbl.user_id = task_members_tbl.user_id WHERE task_members_tbl.task_id = '$task_id'");
    while ($row = mysqli_fetch_array($select_task_members)) {
        $task_members[] = $row['user_id'];
    }

    return in_array($user_id, $task_members);
}