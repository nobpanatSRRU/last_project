<?php
session_start();
require_once("../db/db.php");
require_once("../repositories/authorize.php");
$db = new AppDababase();
$auth = new Authorize($db->connect());
if ($_SESSION["logged"] == 1) {
    header('Location: member_view.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #6a11cb;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style>
</head>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-2 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">เข้าสู่ระบบ</h2>
                                    <p class="text-white-50 mb-5">ลงชื่อเข้าใช้งานระบบด้วยชื่อผู้ใช้และรหัสผ่าน</p>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="your username" name="username" required>
                                        <label for="floatingInput" class="text-dark">ชื่อผู้ใช้</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password" name="password" required>
                                        <label for="floatingPassword" class="text-dark">รหัสผ่าน</label>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5 mt-5" type="submit"
                                        name="submit">ลงชื่อเข้าใช้</button>
                                </div>

                                <div>
                                    <h5 class="mb-2">เฉพาะเจ้าหน้าที่</a>
                                    </h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>




    <?php

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $logged = $auth->login($username, $password);
        if ($logged) {
            header("Location: member_view.php");
            exit();
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                title: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
                text: 'กรุณาตรวจสอบข้อมูล',
                icon: 'error',
                confirmButtonText: 'ตกลง'
                })
            </script>
        ";
        }
    }
    ?>



</body>

</html>