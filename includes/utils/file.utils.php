<?php
function preview_file($file, $folder_path) {
    if (empty($file)) {
        # No file to display
        ?>
        <div class="no-image">
            <i class="las la-image"></i>
            <p>No attachment uploaded.</p>
        </div>
        <?php
        return;
    }

    $allowed_img_files = [
        'jpg',
        'jpeg',
        'png',
        'gif'
    ];

    $allowed_files = [
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx'
    ];

    $file_path = $folder_path . $file;
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if (in_array($extension, $allowed_img_files) || in_array($extension, $allowed_files)) {
        if (in_array($extension, $allowed_img_files)) {
            # Preview Image
            ?>
            <img class="img-thumbnail mx-auto d-block" src="<?php echo $file_path; ?>" style="height: 50%; width 50%;">
            <?php
        } else if (in_array($extension, $allowed_files)) {
            # Preview File
            ?>
            <a href="<?php echo $file_path; ?>" target="_blank"
                class="btn btn-success">
                View Attachment
            </a>
            <?php
        }
    }
}
?>