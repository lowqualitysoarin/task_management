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
                closeModal();
            });

    }

</script>