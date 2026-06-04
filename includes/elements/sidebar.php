<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    .sidebar-nav-wrapper{
        background:#ffffff;
        border-right:1px solid #e7eaf3;
        box-shadow:8px 0 30px rgba(91,77,255,.06);
    }

    .navbar-logo{
        padding:24px 22px 18px;
        border-bottom:1px solid #edf1fb;
        background:linear-gradient(135deg, rgba(91,77,255,.08), rgba(63,140,255,.06));
    }

    .navbar-logo img{
        max-width:160px;
    }

    .sidebar-nav{
        padding:14px 12px 18px;
    }

    .sidebar-nav ul{
        list-style:none;
        padding:0;
        margin:0;
    }

    .sidebar-nav .nav-item{
        margin-bottom:6px;
    }

    .sidebar-nav .nav-item > a{
        display:flex;
        align-items:center;
        gap:12px;
        padding:14px 16px;
        border-radius:16px;
        color:#475569;
        text-decoration:none;
        transition:.25s;
        position:relative;
        overflow:hidden;
    }

    .sidebar-nav .nav-item > a::before{
        content:'';
        position:absolute;
        inset:0;
        background:linear-gradient(135deg,rgba(91,77,255,.10),rgba(63,140,255,.08));
        opacity:0;
        transition:.25s;
    }

    .sidebar-nav .nav-item > a:hover::before,
    .sidebar-nav .nav-item > a.active-link::before,
    .sidebar-nav .nav-item > a.current::before{
        opacity:1;
    }

    .sidebar-nav .nav-item > a:hover,
    .sidebar-nav .nav-item > a.active-link,
    .sidebar-nav .nav-item > a.current{
        color:#5b4dff;
        box-shadow:0 10px 24px rgba(91,77,255,.10);
        transform:translateX(3px);
    }

    .sidebar-nav .icon{
        width:40px;
        height:40px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#f1f5ff;
        color:#5b4dff;
        flex-shrink:0;
        position:relative;
        z-index:1;
        transition:.2s;
    }

    .sidebar-nav .nav-item > a:hover .icon,
    .sidebar-nav .nav-item > a.active-link .icon,
    .sidebar-nav .nav-item > a.current .icon{
        background:linear-gradient(135deg,#5b4dff,#3f8cff);
        color:#fff;
    }

    .sidebar-nav .text{
        position:relative;
        z-index:1;
        font-weight:600;
        font-size:14px;
    }

    .sidebar-nav .divider{
        display:block;
        padding:10px 10px 12px;
    }

    .sidebar-nav .divider hr{
        border-color:#e7eaf3;
        margin:0;
    }

    .nav-item-has-children > a{
        justify-content:flex-start;
    }

    .nav-item-has-children .dropdown-nav{
        padding:8px 0 0 14px;
        margin:0;
    }

    .nav-item-has-children .dropdown-nav li a{
        display:block;
        padding:11px 14px 11px 46px;
        border-radius:12px;
        color:#64748b;
        text-decoration:none;
        transition:.2s;
        position:relative;
    }

    .nav-item-has-children .dropdown-nav li a:hover{
        color:#5b4dff;
        background:#f7f8ff;
        transform:translateX(3px);
    }

    .icon-users{
        background:linear-gradient(135deg,#7c3aed,#a855f7) !important;
        color:#fff !important;
    }

    .icon-tasks{
        background:linear-gradient(135deg,#06b6d4,#3b82f6) !important;
        color:#fff !important;
    }

    .overlay{
        background:rgba(15,23,42,.18);
        backdrop-filter:blur(3px);
    }
</style>

<!-- ======== sidebar-nav start =========== -->
<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="../dashboard/dashboard.php">
            <img src="../../assets/images/logo/logo.svg" alt="logo" />
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                <a href="../dashboard/dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active-link current' : ''; ?>">
                    <span class="icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.74999 18.3333C12.2376 18.3333 15.1364 15.8128 15.7244 12.4941C15.8448 11.8143 15.2737 11.25 14.5833 11.25H9.99999C9.30966 11.25 8.74999 10.6903 8.74999 10V5.41666C8.74999 4.7263 8.18563 4.15512 7.50586 4.27556C4.18711 4.86357 1.66666 7.76243 1.66666 11.25C1.66666 15.162 4.83797 18.3333 8.74999 18.3333Z" />
                            <path d="M17.0833 10C17.7737 10 18.3432 9.43708 18.2408 8.75433C17.7005 5.14918 14.8508 2.29947 11.2457 1.75912C10.5629 1.6568 10 2.2263 10 2.91665V9.16666C10 9.62691 10.3731 10 10.8333 10H17.0833Z" />
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <span class="divider">
                <hr />
            </span>

            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
                $is_users_active = in_array($current_page, ['add.user.php','list.user.php']);
                $is_tasks_active = in_array($current_page, ['add.task.php','list.task.php']);
            ?>
                <li class="nav-item nav-item-has-children">
                    <a href="#0"
                       class="<?php echo $is_users_active ? 'active-link current' : 'collapsed'; ?>"
                       data-bs-toggle="collapse"
                       data-bs-target="#usersmenu"
                       aria-controls="usersmenu"
                       aria-expanded="<?php echo $is_users_active ? 'true' : 'false'; ?>"
                       aria-label="Toggle navigation">
                        <span class="icon icon-users">
                            <i class="lni lni-users"></i>
                        </span>
                        <span class="text">Users</span>
                    </a>

                    <ul id="usersmenu" class="collapse dropdown-nav <?php echo $is_users_active ? 'show' : ''; ?>">
                        <li>
                            <a href="../users/add.user.php">Add User</a>
                        </li>
                        <li>
                            <a href="../users/list.user.php">List Users</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-item-has-children">
                    <a href="#0"
                       class="<?php echo $is_tasks_active ? 'active-link current' : 'collapsed'; ?>"
                       data-bs-toggle="collapse"
                       data-bs-target="#tasksmenu"
                       aria-controls="tasksmenu"
                       aria-expanded="<?php echo $is_tasks_active ? 'true' : 'false'; ?>"
                       aria-label="Toggle navigation">
                        <span class="icon icon-tasks">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.16666 3.33335C4.16666 2.41288 4.91285 1.66669 5.83332 1.66669H14.1667C15.0872 1.66669 15.8333 2.41288 15.8333 3.33335V16.6667C15.8333 17.5872 15.0872 18.3334 14.1667 18.3334H5.83332C4.91285 18.3334 4.16666 17.5872 4.16666 16.6667V3.33335ZM6.04166 5.00002C6.04166 5.3452 6.32148 5.62502 6.66666 5.62502H13.3333C13.6785 5.62502 13.9583 5.3452 13.9583 5.00002C13.9583 4.65485 13.6785 4.37502 13.3333 4.37502H6.66666C6.32148 4.37502 6.04166 4.65485 6.04166 5.00002ZM6.66666 6.87502C6.32148 6.87502 6.04166 7.15485 6.04166 7.50002C6.04166 7.8452 6.32148 8.12502 6.66666 8.12502H13.3333C13.6785 8.12502 13.9583 7.8452 13.9583 7.50002C13.9583 7.15485 13.6785 6.87502 13.3333 6.87502H6.66666ZM6.04166 10C6.04166 10.3452 6.32148 10.625 6.66666 10.625H9.99999C10.3452 10.625 10.625 10.3452 10.625 10C10.625 9.65485 10.3452 9.37502 9.99999 9.37502H6.66666C6.32148 9.37502 6.04166 9.65485 6.04166 10ZM9.99999 16.6667C10.9205 16.6667 11.6667 15.9205 11.6667 15C11.6667 14.0795 10.9205 13.3334 9.99999 13.3334C9.07949 13.3334 8.33332 14.0795 8.33332 15C8.33332 15.9205 9.07949 16.6667 9.99999 16.6667Z" />
                            </svg>
                        </span>
                        <span class="text">Tasks</span>
                    </a>

                    <ul id="tasksmenu" class="collapse dropdown-nav <?php echo $is_tasks_active ? 'show' : ''; ?>">
                        <li>
                            <a href="../tasks/add.task.php">Add Task</a>
                        </li>
                        <li>
                            <a href="../tasks/list.task.php">List Tasks</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->

