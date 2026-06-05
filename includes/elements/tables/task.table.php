<div class="table-wrapper table-responsive">
    <table class="table" data-toggle="table" data-search="true" data-filter-control="true">
        <thead>
            <tr>
                <th data-sortable="true">Task</th>
                <th data-sortable="true">Tags</th>
                <th data-sortable="true">Description</th>
                <th data-sortable="true">Status</th>
                <th data-sortable="true">Assigned Members</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = "
            SELECT tasks_tbl.*, task_status_tbl.status
            FROM tasks_tbl
            LEFT JOIN task_status_tbl ON task_status_tbl.status_id = tasks_tbl.task_status
            ";

            $tasks = mysqli_query($conn, $query);
            while ($task = mysqli_fetch_array($tasks)) {
                $status_color = match ((int) $task['task_status']) {
                    1 => "info-btn",
                    2 => "active-btn",
                    3 => "success-btn",
                    4 => "close-btn",
                    default => "secondary-btn"
                };

                if (can_view_task($conn, $task['task_id'], $user_id, $role)) {
                    $task_id = $task['task_id'];
                    ?>
                    <tr>
                        <td>
                            <p class="m-1 fw-bold"><?php echo $task['task_name']; ?></p>
                        </td>
                        <td>
                            <div class="tag-wrap">
                                <?php
                                $select_tag_tasks = mysqli_query($conn, "SELECT * FROM task_tags_tbl LEFT JOIN tags_tbl ON tags_tbl.tag_id = task_tags_tbl.tag_id WHERE task_id = '$task_id'");
                                if (mysqli_num_rows($select_tag_tasks) == 0) {
                                    ?>
                                    <span class="no-tags">No tags</span>
                                    <?php
                                } else {
                                    while ($tag = mysqli_fetch_array($select_tag_tasks)) {
                                        ?>
                                        <span class="task-tag">
                                            <?php echo $tag['tag']; ?>
                                        </span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </td>
                        <td>
                            <p class="m-1"><?php echo $task['task_description']; ?></p>
                        </td>
                        <td>
                            <span class="status-btn <?php echo $status_color; ?>">
                                <?php echo $task['status']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php
                                $select_members = mysqli_query($conn, "SELECT * FROM task_members_tbl LEFT JOIN users_tbl ON users_tbl.user_id = task_members_tbl.user_id WHERE task_id = '$task_id'");
                                while ($row = mysqli_fetch_array($select_members)) {
                                    ?>
                                    <a class="member-img" href="/task_management/pages/profile/profile.php?user_id=<?= $row['user_id']; ?>">
                                        <img src="<?php echo get_user_profile_image($conn, $row['user_id']); ?>"
                                            alt="<?php echo $row['full_name']; ?>" title="<?php echo $row['full_name']; ?>" />
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                        <td>
                            <div class="action">
                                <a class="action-btn view-btn" href="../tasks/task.view.php?id=<?php echo $task['task_id']; ?>">
                                    <i class="lni lni-eye"></i>
                                </a>
                                <a class="action-btn edit-btn" href="#" data-bs-toggle="modal"
                                    data-bs-target="#status-modal-<?php echo $task['task_id']; ?>">
                                    <i class="lni lni-popup"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade status-modal" id="status-modal-<?php echo $task['task_id']; ?>" tabindex="-1"
                        data-bs-container="body" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <form action="ctrlData/ctrl.update.status.php?task_id=<?php echo $task['task_id']; ?>"
                                method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title-wrap">
                                            <div class="modal-title-icon">
                                                <i class="lni lni-dashboard"></i>
                                            </div>
                                            <div class="modal-title-text">
                                                <h5>Project Status</h5>
                                                <p>Update task progress with one click</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-body">
                                        <div class="task-summary">
                                            <label>Task</label>
                                            <p class="task-name"><?php echo $task['task_name']; ?></p>

                                            <div class="current-status">
                                                <span>Current Status:</span>
                                                <span class="status-btn <?php echo $status_color; ?>">
                                                    <?php echo $task['status']; ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="status-options">
                                            <?php
                                            $status_list = mysqli_query($conn, "SELECT * FROM task_status_tbl");
                                            while ($st = mysqli_fetch_array($status_list)) {
                                                ?>
                                                <div class="form-check">
                                                    <label class="status-option">
                                                        <input type="radio" name="taskstatus"
                                                            value="<?php echo $st['status_id']; ?>" required <?php if ($task['task_status'] == $st['status_id'])
                                                                   echo "checked"; ?>>
                                                        <div class="option-content">
                                                            <strong><?php echo $st['status']; ?></strong>
                                                            <small>Select this to update status</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="submit" class="btn btn-save text-white">Save
                                            Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>