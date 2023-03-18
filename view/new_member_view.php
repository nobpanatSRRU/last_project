<?php
session_start();
if ($_SESSION["logged"] != 1) {
    header('Location: login_view.php');
}

require_once("../db/db.php");
require_once("../repositories/bus.php");
require_once("../repositories/members.php");

$db = new AppDababase();
$busRepo = new BusRepo($db->connect());
$buses = $busRepo->getAll();

$memberRepo = new Members($db->connect());

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <?php
        require_once("../components/navbar.php");
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <section class="vh-100 gradient-custom">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                                <div class="card-body p-5 text-center">
                                    <div class="mb-md-2 mt-md-4 pb-5">
                                        <h2 class="fw-bold mb-2 text-uppercase">เพิ่มข้อมูลสมาชิก</h2>
                                        <p class="text-white-50 mb-5"></p>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInputName"
                                                placeholder="your name" name="name" required>
                                            <label for="floatingInputName" class="text-dark">ชื่อ</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInputLastName"
                                                placeholder="your lastname" name="sname" required>
                                            <label for="floatingInputLastName" class="text-dark">นามสกุล</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInputEmail"
                                                placeholder="email address" name="email" required>
                                            <label for="floatingInputEmail" class="text-dark">อีเมล์</label>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="buses">รถบัส</label>
                                            <select class="form-select form-select-lg" id="buses" name="bus_id"
                                                required>
                                                <!-- <option value=-1>กรุณาเลือก</option> -->
                                                <?php for ($i = 0; $i < count($buses); $i++) { ?>
                                                    <option value=<?php echo $buses[$i]['id'] ?>><?php echo $buses[$i]['bus_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <button class="btn btn-outline-light btn-lg px-5 mt-5" type="submit"
                                            name="submit">เพิ่มข้อมูล</button>
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
            $name = $_POST['name'];
            $sname = $_POST['sname'];
            $email = $_POST['email'];
            $bus_id = $_POST['bus_id'];
            $result = $memberRepo->insertMember($name, $sname, $email, $bus_id);
            if ($result == TRUE) {
                echo "
                 <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                    title: 'บันทึกข้อมูลสำเร็จ',
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'ตกลง'
                    }).then(function (result) {
                    window.location.href = 'member_view.php';
                });
                </script>
        ";
            }

        }
        ?>
    </div>

</body>

</html>