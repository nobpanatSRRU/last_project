<?php
session_start();
if ($_SESSION["logged"] != 1) {
    header('Location: login_view.php');
}

require_once("../db/db.php");
require_once("../repositories/bus.php");

$db = new AppDababase();
$busRepo = new BusRepo($db->connect());
$buses = $busRepo->getAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลรถบัส</title>
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
                                        <h2 class="fw-bold mb-2 text-uppercase">เพิ่มข้อมูลรถบัส</h2>
                                        <p class="text-white-50 mb-5"></p>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInputName"
                                                placeholder="your name" name="name" required>
                                            <label for="floatingInputName" class="text-dark">ชื่อรถบัส</label>
                                        </div>
                                        <button class="btn btn-outline-light btn-lg px-5 mt-5" type="submit"
                                            name="submit">เพิ่มข้อมูล</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                            <table class="table table-dark table-hover">
                                <thead class="align-middle text-center">
                                    <tr>
                                        <th scope="col">รหัสรถบัส</th>
                                        <th scope="col">ชื่อรถบัส</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle text-center">
                                    <?php
                                    for ($i = 0; $i < count($buses); $i++) { ?>
                                        <tr>
                                            <th scope="row">
                                                <?php echo $buses[$i]['id'] ?>
                                            </th>
                                            <td scope="row">
                                                <?php echo $buses[$i]['bus_name'] ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>


    <?php

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $result = $busRepo->insert($name);
        if ($result == TRUE) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                title: 'บันทึกข้อมูลสำเร็จ',
                 text: '',
                icon: 'success',
                confirmButtonText: 'ตกลง'
                }).then(function () {
                    window.location.href = 'new_bus_info_view.php';
                });
            </script>
        ";
        }

    }
    ?>

</body>

</html>