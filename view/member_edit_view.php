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


$member = $memberRepo->getById($_GET['user_id']);


$m_user_id = $member[0]['id'];
$m_name = $member[0]['name'];
$m_sname = $member[0]['sname'];
$m_email = $member[0]['email'];
$m_bus_id = $member[0]['bus_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไข</title>
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
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?user_id=" . $m_user_id; ?>">
            <section class="vh-100 gradient-custom">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                                <div class="card-body p-5 text-center">
                                    <div class="mb-md-2 mt-md-4 pb-5">
                                        <h2 class="fw-bold mb-2 text-uppercase">แก้ไขข้อมูลสมาชิก</h2>
                                        <p class="text-white-50 mb-5"></p>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInputName"
                                                placeholder="your name" name="name" required
                                                value="<?php echo $m_name ?>">
                                            <label for="floatingInputName" class="text-dark">ชื่อ</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInputLastName"
                                                placeholder="your lastname" name="sname" required
                                                value="<?php echo $m_sname ?>">
                                            <label for="floatingInputLastName" class="text-dark">นามสกุล</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInputEmail"
                                                placeholder="email address" name="email" required
                                                value="<?php echo $m_email ?>">
                                            <label for="floatingInputEmail" class="text-dark">อีเมล์</label>
                                        </div>

                                        <input type="hidden" name="user_id" required
                                            value="<?php echo $_GET['user_id'] ?>">

                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="buses">รถบัส</label>
                                            <select class="form-select form-select-lg" id="buses" name="bus_id"
                                                required>
                                                <!-- <option value=-1>กรุณาเลือก</option> -->
                                                <?php for ($i = 0; $i < count($buses); $i++) { ?>
                                                    <option <?php if ($buses[$i]['id'] == $m_bus_id) { ?> selected <?php } ?>
                                                        value=<?php echo $buses[$i]['id'] ?>><?php echo $buses[$i]['bus_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <button class="btn btn-outline-light btn-lg px-5 mt-5" type="submit"
                                            name="submit">แก้ไขข้อมูล</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>



    <?php

    if (isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $sname = $_POST['sname'];
        $email = $_POST['email'];
        $bus_id = $_POST['bus_id'];
        $result = $memberRepo->updateMember($user_id, $name, $sname, $email, $bus_id);
        if ($result == TRUE) {
            echo " 
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                title: 'แก้ไขข้อมูลสำเร็จ',
                text: '',
                icon: 'success',
                confirmButtonText: 'ตกลง'
                }).then(function () {
                window.location.href = 'member_view.php';
                });
            </script>
        ";


        }

    }
    ?>

</body>

</html>