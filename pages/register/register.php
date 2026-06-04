<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Task Management | Register</title>

    <?php include_once "../../includes/components/links.php"; ?>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        html,
        body {
            height: 100%;
        }

        .auth-cover-wrapper,
        .auth-cover {
            height: 100%;
        }

        .login-side {
            background:
                radial-gradient(circle at top left,
                    rgba(79, 70, 229, .12),
                    transparent 35%),
                radial-gradient(circle at bottom right,
                    rgba(59, 130, 246, .15),
                    transparent 35%),
                #f4f7ff;

            position: relative;
            overflow: hidden;
        }

        .login-side::before {
            content: "";
            position: absolute;

            width: 350px;
            height: 350px;

            border-radius: 50%;

            background: rgba(99, 102, 241, .12);

            top: -120px;
            right: -120px;

            filter: blur(50px);
        }

        .login-side::after {
            content: "";
            position: absolute;

            width: 280px;
            height: 280px;

            border-radius: 50%;

            background: rgba(59, 130, 246, .12);

            bottom: -80px;
            left: -80px;

            filter: blur(50px);
        }

        .glass-card {
            position: relative;
            z-index: 5;

            width: 100%;
            max-width: 500px;

            padding: 40px;

            border-radius: 28px;

            background: rgba(255, 255, 255, .65);

            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, .5);

            box-shadow:
                0 20px 50px rgba(0, 0, 0, .08),
                0 5px 15px rgba(99, 102, 241, .08);
        }

        .logo-circle {
            width: 90px;
            height: 90px;

            margin: auto;
            margin-bottom: 25px;

            border-radius: 50%;

            background: linear-gradient(
                135deg,
                #4f46e5,
                #3b82f6);

            display: flex;
            justify-content: center;
            align-items: center;

            box-shadow:
                0 10px 25px rgba(79, 70, 229, .3);
        }

        .logo-circle i {
            color: white;
            font-size: 34px;
        }

        .form-title {
            text-align: center;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-desc {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .input-label {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            display: block;
        }

        .glass-input {
            position: relative;
            margin-bottom: 18px;
        }

        .glass-input i.field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .glass-input input {
            width: 100%;
            height: 55px;

            border: 1px solid #e2e8f0;
            border-radius: 14px;

            background: rgba(255, 255, 255, .80);

            padding-left: 48px;
            padding-right: 48px;

            transition: .3s;
        }

        .glass-input input:focus {
            outline: none;

            border-color: #4f46e5;

            box-shadow:
                0 0 0 4px rgba(79, 70, 229, .12);
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            z-index: 2;
        }

        .register-btn {
            width: 100%;
            height: 55px;

            border: none;
            border-radius: 14px;

            background: linear-gradient(
                135deg,
                #4f46e5,
                #3b82f6);

            color: white;
            font-weight: 600;

            transition: .3s;
        }

        .register-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 10px 20px rgba(79, 70, 229, .25);
        }

        .extra-links {
            margin-top: 18px;
            text-align: center;
            color: #64748b;
        }

        .extra-links a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        #passwordfeedback {
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container-fluid g-0 min-vh-100">
<div class="row g-0 min-vh-100">

    <div class="col-lg-6">
        <div class="auth-cover-wrapper bg-primary-100">
            <div class="auth-cover">

                <div class="title text-center">
                    <h1 class="text-primary mb-10">
                        Welcome!
                    </h1>

                    <p class="text-medium">
                        Create an account to continue
                    </p>
                </div>

                <div class="cover-image">
                    <img src="../../assets/images/auth/signin-image.svg" alt="">
                </div>

                <div class="shape-image">
                    <img src="../../assets/images/auth/shape.svg" alt="">
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6 d-flex justify-content-center align-items-center login-side">

        <div class="glass-card">

            <div class="logo-circle">
                <i class="fa-solid fa-user-plus"></i>
            </div>

            <h4 class="form-title">
                Register Page
            </h4>

            <p class="form-desc">
                Please fill out the fields to continue creating your account.
            </p>

            <?php if (isset($_SESSION['error_username'])) { ?>
                <div class="alert alert-danger mb-3">
                    Username already exists!
                </div>
                <?php unset($_SESSION['error_username']); ?>
            <?php } ?>

            <form action="ctrlData/ctrl.register.php" method="POST">
                <label class="input-label">Full Name</label>
                <div class="glass-input">
                    <i class="fa-solid fa-user field-icon"></i>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                </div>

                <label class="input-label">Username</label>
                <div class="glass-input">
                    <i class="fa-solid fa-at field-icon"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <label class="input-label">Email</label>
                <div class="glass-input">
                    <i class="fa-solid fa-envelope field-icon"></i>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <label class="input-label">Password</label>
                <div class="glass-input">
                    <i class="fa-solid fa-lock field-icon"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                </div>

                <label class="input-label">Confirm Password</label>
                <div class="glass-input">
                    <i class="fa-solid fa-lock field-icon"></i>
                    <input type="password" id="confirmpassword" placeholder="Confirm Password" required>
                    <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword"></i>
                </div>

                <p id="passwordfeedback"></p>

                <button type="submit" name="submit" id="submit" class="register-btn">
                    Register
                </button>

                <div class="extra-links">
                    Already have an account?
                    <a href="../login/login.php">
                        Login Here
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
</div>

<script>
    const passInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirmpassword");
    const submitBtn = document.getElementById("submit");
    const passFeedback = document.getElementById("passwordfeedback");

    const togglePassword = document.getElementById("togglePassword");
    const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

    function validatePassword() {
        const passValue = passInput.value;
        const confirmValue = confirmInput.value;

        if (confirmValue === "") {
            passFeedback.innerText = "";
            submitBtn.disabled = true;
            return;
        }

        const mismatch = passValue !== confirmValue;

        passFeedback.innerText = mismatch ? "Passwords do not match" : "";
        passFeedback.style.color = mismatch ? "red" : "green";

        submitBtn.disabled = mismatch;
    }

    passInput.addEventListener("input", validatePassword);
    confirmInput.addEventListener("input", validatePassword);

    togglePassword.addEventListener("click", function () {
        const type = passInput.getAttribute("type") === "password" ? "text" : "password";
        passInput.setAttribute("type", type);
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });

    toggleConfirmPassword.addEventListener("click", function () {
        const type = confirmInput.getAttribute("type") === "password" ? "text" : "password";
        confirmInput.setAttribute("type", type);
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
</script>

<?php include_once "../../includes/components/scripts.php"; ?>

</body>
</html>

