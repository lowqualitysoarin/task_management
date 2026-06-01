<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Task Management | Register</title>

    <?php include_once "../../includes/components/links.php"; ?>

               </head>
            <style>
            .signin-wrapper{
             width:100%;
             max-width:450px;
           }

           .input-style-1{
              margin-bottom:8px !important;
           }

           .input-style-1 label{
           margin-bottom:3px;
           font-size:14px;
          }

          .input-style-1 input{
           height:45px !important;
          }

         .cover-image img{
           max-width:70%;
          display:block;
        margin:auto;
         }

          .form-wrapper h6{
              margin-bottom:5px !important;
         }

            .form-wrapper .text-sm{
              margin-bottom:12px !important;
           }

               #passwordfeedback{
               margin-top:3px;
               margin-bottom:0;
               font-size:12px;
             }
            </style>
          </head>
<body>
    <!-- ========== signin-section start ========== -->
     <div class="container-fluid g-0 min-vh-100">
    <div class="row g-0 min-vh-100">
            <div class="col-lg-6">
                <div class="auth-cover-wrapper bg-primary-100">
                    <div class="auth-cover">
                        <div class="title text-center">
                            <h1 class="text-primary mb-10">Welcome!</h1>
                            <p class="text-medium">
                                Create an account to continue
                            </p>
                        </div>
                        <div class="cover-image">
                            <img src="../../assets/images/auth/signin-image.svg" alt="" />
                        </div>
                        <div class="shape-image">
                            <img src="../../assets/images/auth/shape.svg" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6 align-items-center justify-content-center d-flex">
                <div class="signin-wrapper col-md-7">
                    <div class="form-wrapper">
                        <h6 class="mb-15">Register Page</h6>
                        <p class="text-sm mb-25">
                            Please fill out the fields to continue creating your account.
                        </p>

                        <?php if (isset($_SESSION['error_username'])) { ?>
                            <div class="alert alert-danger mb-3">
                                Username already exists!
                            </div>
                            <?php unset($_SESSION['error_username']); ?>
                        <?php } ?>

                        <form action="ctrlData/ctrl.register.php" method="POST">

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Full Name</label>
                                        <input type="text" name="fullname" class="form-control"
                                            placeholder="Fullname" required/>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control"
                                            placeholder="Username" required/>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Email@mail.com" required/>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="*********" id="password" required/>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="form-group">
                                <div class="col-12">
                                    <div class="input-style-1">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" id="confirmpassword" required/>
                                        <p id="passwordfeedback"></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-12">
                           <div class="button-group d-flex justify-content-center flex-wrap">
                              <button type="submit" name="submit" id="submit"
                               class="main-btn primary-btn btn-hover w-100 text-center">
                               Register
                         </button>
                     </div>

                     <div class="text-center mt-3">
                         <p class="mb-0">
                           Already have an account?
                        <a href="../login/login.php" class="text-primary">
                         Login Here
                     </a>
                     </p>
                  </div>
               </div>
                            <!-- end row -->
                        </form>

                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== signin-section end ========== -->

    <script>
        const passInput = document.getElementById("password");
        const confirmInput = document.getElementById("confirmpassword");
        const submitBtn = document.getElementById("submit");
        const passFeedback = document.getElementById("passwordfeedback");

        function validatePassword() {
            const passValue = passInput.value;
            const confirmValue = confirmInput.value;

            if (confirmValue === "") {
                passFeedback.innerText = "";
                passFeedback.className = "form-text mt-2";
                confirmInput.className = "form-control"
                submitBtn.disabled = true;
                return;
            }

            const matchState = passValue !== confirmValue;
            passFeedback.innerText = matchState ? "Passwords Mismatch" : "";
            passFeedback.className = matchState ? "form-text mt-2 text-danger" : "form-text mt-2";
            confirmInput.className = matchState ? "form-control border border-danger" : "form-control"
            submitBtn.disabled = matchState;
        }

        passInput.addEventListener('input', validatePassword);
        confirmInput.addEventListener('input', validatePassword);
    </script>

    <?php include_once "../../includes/components/scripts.php"; ?>
</body>

</html>