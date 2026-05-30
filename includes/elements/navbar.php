<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-15">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- profile start -->
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <img class="image"
                                        src="<?php echo get_user_profile_image($conn, $_SESSION['user_id']); ?>"
                                        alt="<?php echo $_SESSION['fullname']; ?>" />
                                    <div>
                                        <h6 class="fw-500">
                                            <?php echo $_SESSION['fullname']; ?>
                                        </h6>
                                        <p>
                                            <?php echo $_SESSION['role']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <!-- EDIT PROFILE -->
                            <li>
                                <a href="../profile/profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">
                                    <i class="lni lni-user"></i>
                                    Profile
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../login/ctrlData/ctrl.logout.php">
                                    <i class="lni lni-exit"></i>
                                    Sign Out
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- profile end -->
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ========== header end ========== -->