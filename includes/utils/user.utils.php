<?php
function get_user_profile_image($conn, $user_id) : string {
    $all_users = mysqli_query($conn, "SELECT * FROM users_tbl WHERE user_id = '$user_id'");
    $user = mysqli_fetch_array($all_users);

    if (!isset($user['profile'])) {
        return "../../assets/images/lead/lead-1.png";
    }
    return "/task_management/uploads/profiles/" . $user['profile'];
}