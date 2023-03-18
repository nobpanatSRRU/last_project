<?php
session_start();
if ($_SESSION["logged"] != 1) {
    header('Location: login_view.php');
}

require_once("../db/db.php");
require_once("../repositories/members.php");

$db = new AppDababase();
$memberObj = new Members($db->connect());
$members = $memberObj->getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลสมาชิก</title>
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
        <div class="mt-3">
            <table class="table table-dark table-hover">
                <thead class="align-middle text-center">
                    <tr>
                        <th scope="col">รหัสสมาชิก</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">นามสกุล</th>
                        <th scope="col">อีเมล์</th>
                        <th scope="col">ชื่อรถบัส</th>
                        <th scope=""></th>
                    </tr>
                </thead>
                <tbody class="align-middle text-center">
                    <?php
                    for ($i = 0; $i < count($members); $i++) { ?>
                        <tr>
                            <th scope="row">
                                <?php echo $members[$i]['mem_id'] ?>
                            </th>
                            <td scope="row">
                                <?php echo $members[$i]['mem_name'] ?>
                            </td>
                            <td>
                                <?php echo $members[$i]['mem_sname'] ?>
                            </td>
                            <td>
                                <?php echo $members[$i]['mem_email'] ?>
                            </td>
                            <td>
                                <?php echo $members[$i]['bus_name'] ?>
                            </td>
                            <td>
                                <a href="member_edit_view.php?user_id=<?php echo $members[$i]['mem_id'] ?>"
                                    class="btn btn-outline-warning">แก้ไข</a>
                                <button href="#" onclick="ondeleteButtonPressed(<?php echo $members[$i]['mem_id'] ?>)"
                                    class="btn btn-outline-danger">ลบ</button>
                            </td>
                        </tr>
                    <?php }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function ondeleteButtonPressed(userId) {
            Swal.fire({
                title: 'ต้องการลบข้อมูลใช่หรือไม่?',
                text: '',
                icon: 'error',
                confirmButtonText: 'ตกลง',
                showCancelButton: true,
                cancelButtonText: 'ยกเลิก',
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        data: 'user_id=' + userId,
                        url: "member_view.php",
                        method: 'POST', // or GET
                        success: function (msg) {
                            location.reload();
                        }
                    });
                }
            });
        }
    </script>
    <?php

    if (isset($_POST)) {
        $user_id = $_POST['user_id'];
        $memberObj->deleteMember($user_id);
    }
    ?>


</body>

</html>