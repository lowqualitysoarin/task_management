<?php require_once "../../includes/conn.php"; ?>
<?php include_once "../../includes/session.start.php"; ?>
<?php include_once "../../includes/utils/login.access.check.php"; ?>
<?php include_once "../../includes/utils/admin.access.check.php"; ?>
<?php include_once "../../includes/utils/user.utils.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User | Task Management</title>

    <?php include_once "../../includes/components/links.php"; ?>
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">

    <style>
        :root {
            --primary: #5b4dff;
            --secondary: #3f8cff;
            --border: #e5e7eb;
            --muted: #64748b;
        }

        body {
            background: #f5f7ff;
            overflow-x: hidden;
        }

        .section {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 70px;
            border-radius: 18px;
            padding: 12px 25px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(91, 77, 255, .20);
        }

        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2px;
            color: #fff;
        }

        .header-subtitle {
            margin: 0;
            font-size: .85rem;
            opacity: .9;
        }

        .glass-card {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            margin-top: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
        }

        /* FORM */
        .section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .section-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #eef2ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .section-head h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .section-head p {
            margin: 0;
            font-size: .8rem;
            color: var(--muted);
        }

        hr {
            margin: .8rem 0;
        }

        .mb-3 {
            margin-bottom: .75rem !important;
        }

        .form-label {
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .input-custom {
            width: 100%;
            height: 45px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding-left: 42px;
            font-size: .9rem;
            transition: .3s;
        }

        .input-custom:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(91, 77, 255, .10);
        }

        /* ROLE DESIGN */
        .role-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .role-card {
            position: relative;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: .3s;
            background: #fff;
        }

        .role-card.active {
            border-color: var(--primary);
            background: #fafaff;
        }

        .role-card input {
            display: none;
        }

        .role-radio {
            position: absolute;
            right: 12px;
            top: 12px;
            width: 16px;
            height: 16px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
        }

        .role-card.active .role-radio {
            border-color: var(--primary);
        }

        .role-card.active .role-radio:after {
            content: "";
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            position: absolute;
            top: 3px;
            left: 3px;
        }

        .role-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .role-content {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .role-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .member-icon {
            background: #fff2eb;
            color: #5b4dff;
        }

        .role-details {
            flex: 1;
        }

        .role-access {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 3px;
        }

        .role-desc {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.4;
        }

        /* BUTTON */
        .btn-add {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin-top: 15px;
            transition: .3s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
        }

        @media(max-width:768px) {
            .role-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include_once "../../includes/components/preloader.php"; ?>
    <?php include_once "../../includes/elements/sidebar.php"; ?>

    <main class="main-wrapper">

        <?php include_once "../../includes/elements/navbar.php"; ?>

        <section class="section">
            <div class="container-fluid">

                <div class="page-header">
                    <div class="header-icon">
                        <i class="lni lni-user"></i>
                    </div>

                    <div>
                        <h2 class="header-title">Add New User</h2>
                        <p class="header-subtitle">
                            Create a new admin or member account ✨
                        </p>
                    </div>
                </div>

                <div class="glass-card">
                    <form action="ctrlData/ctrl.add.user.php" method="POST">
                        <div class="section-head">
                            <div class="section-icon">
                                <i class="lni lni-user"></i>
                            </div>

                            <div>
                                <h5>Profile Information</h5>
                                <p>Enter the basic details of the user.</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <div class="input-group-custom">
                                    <i class="lni lni-user"></i>
                                    <input type="text" name="fullname" class="input-custom" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group-custom">
                                    <i class="lni lni-at"></i>
                                    <input type="text" name="username" class="input-custom" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group-custom">
                                    <i class="lni lni-envelope"></i>
                                    <input type="email" name="email" class="input-custom" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group-custom">
                                    <i class="lni lni-lock"></i>
                                    <input type="password" name="password" class="input-custom" required>
                                </div>
                            </div>
                        </div>

                        <div class="section-head mt-4">
                            <div class="section-icon">
                                <i class="lni lni-shield"></i>
                            </div>

                            <div>
                                <h5>Select Role</h5>
                                <p>Choose the appropriate role for this user.</p>
                            </div>
                        </div>

                        <hr>

                        <div class="role-container">
                            <label class="role-card active">
                                <input type="radio" name="role" value="1" checked>

                                <div class="role-radio"></div>

                                <div class="role-title">Admin</div>

                                <div class="role-content">

                                    <div class="role-icon">
                                        <i class="lni lni-crown"></i>
                                    </div>

                                    <div class="role-details">
                                        <div class="role-access">Full system access</div>
                                        <div class="role-desc">Can manage all users, settings and system data.</div>
                                    </div>

                                </div>
                            </label>

                            <label class="role-card">
                                <input type="radio" name="role" value="2">

                                <div class="role-radio"></div>

                                <div class="role-title">Member</div>

                                <div class="role-content">

                                    <div class="role-icon member-icon">
                                        <i class="lni lni-users"></i>
                                    </div>

                                    <div class="role-details">
                                        <div class="role-access">Limited access</div>
                                        <div class="role-desc">Can view and manage assigned resources only.</div>
                                    </div>

                                </div>
                            </label>

                        </div>

                        <button type="submit" name="submit" class="btn-add">
                            <i class="lni lni-user"></i> Add User
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <?php include_once "../../includes/elements/footer.php"; ?>

    </main>

    <?php include_once "../../includes/components/scripts.php"; ?>

    <script>
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function () {
                document.querySelectorAll('.role-card').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>

</body>

</html>