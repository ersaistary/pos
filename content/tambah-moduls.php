<?php 
if(isset($_GET['delete'])){
    $id = isset($_GET['delete'])? $_GET['delete'] : '';
    // query untuk mengambil name dari path 
    $queryModulsDetails = mysqli_query($config, "SELECT file FROM moduls_details WHERE id_moduls = '$id'");
    $rowModulsDetails = mysqli_fetch_assoc($queryModulsDetails);
    unlink("uploads/". $rowModulsDetails['file']); // menghapus file dari folder uploads

    $queryDelete = mysqli_query($config, "DELETE FROM moduls_details WHERE id_moduls = '$id'");
    $queryDelete = mysqli_query($config, "DELETE FROM moduls WHERE id = '$id'");
    if($queryDelete){
        header("location:?page=moduls&hapus=berhasil");
    }else{
        header("location:?page=moduls&hapus=gagal");
    }
}

$id = isset($_GET['edit'])? $_GET['edit'] : '';

if(isset($_POST['save'])){
    $id_instructors = $_POST['id_instructors'];
    $id_majors = $_POST['id_major'];
    $name = $_POST['name'];

    $insert = mysqli_query ($config, "INSERT INTO `moduls`(id_majors, id_instructors, name) VALUES ('$id_majors','$id_instructors','$name')");
    if($insert){
        $id_moduls = mysqli_insert_id($config);
        foreach ($_FILES['file']['name'] as $index => $file){
            if ($_FILES['file']['error'][$index] == 0){
                $name = basename($_FILES['file']['name'][$index]);
                $fileName= uniqid() . "-" . $name;
                $path = "uploads/";
                $targetPath = $path . $fileName;

                if(move_uploaded_file($_FILES['file']['tmp_name'][$index], $targetPath)){
                    $insertFile = mysqli_query($config, "INSERT INTO `moduls_details`(id_moduls, file) VALUES ('$id_moduls','$fileName')");
                }
            }
        }
        header("location:?page=moduls&tambah=berhasil");
    }
    // $id_majors = isset($_GET['edit'])? $_GET['edit'] : '';
}


if(isset($_GET['edit'])){
    $id_majors = isset($_GET['edit'])? $_GET['edit'] : '';
    $selectEdit = mysqli_query($config, "SELECT * FROM majors WHERE id=$id_majors");
    $rowEdit = mysqli_fetch_assoc($selectEdit); 
}

$id_instructors = isset($_SESSION['ID_USER'])? $_SESSION['ID_USER'] : '';
$queryInstructorsMajors = mysqli_query($config, "SELECT majors.name, instructors_majors.* FROM instructors_majors
LEFT JOIN majors ON majors.id = instructors_majors.id_majors
WHERE instructors_majors.id_instructors = '$id_instructors'");

$rowInstructorsMajors = mysqli_fetch_all ($queryInstructorsMajors, MYSQLI_ASSOC);

$id_moduls = isset($_GET['detail'])? $_GET['detail'] : '';
$queryModuls= mysqli_query($config, "SELECT majors.name as majors_name, instructors.name as instructors_name, moduls.* 
    FROM moduls 
    LEFT JOIN majors ON majors.id = moduls.id_majors
    LEFT JOIN instructors ON instructors.id = moduls.id_instructors WHERE moduls.id = '$id_moduls'");
$rowModuls = mysqli_fetch_assoc($queryModuls);

$queryDetailsModuls= mysqli_query($config, "SELECT * FROM moduls_details WHERE id_moduls = '$id_moduls'");
$rowDetailsModuls = mysqli_fetch_all($queryDetailsModuls, MYSQLI_ASSOC);

if(isset($_GET['download'])){
    $file = $_GET['download'];
    $filePath = "uploads/" . $file;
    if(file_exists($filePath)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header("Content-Length:" . filesize($filePath) . "");
        ob_clean();
        flush();
        readfile($filePath);
        exit;
    }
    
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['detail']) ? 'Detail Modul' : 'Add Modul' ?></h5>

                <?php if(isset($_GET['detail'])): ?>
                    <table class="table table-striped">
                        <tr>
                            <th>Modul Name</th>
                            <th>:</th>
                            <td><?= $rowModuls['name']?></td>
                            <th>Modul Name</th>
                            <th>:</th>
                            <td><?= $rowModuls['majors_name']?></td>
                        </tr>
                        <tr>
                            <td>Instructors</td>
                            <td>:</td>
                            <td><?= $rowModuls['instructors_name']?></td>
                    </table>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rowDetailsModuls as $key => $data): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <a target="_blank" href="?page=tambah-moduls&download=<?= urlencode($data['file'])?>" >
                                        <?php echo $data['file']?>
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <!-- form tambah modul -->
                    <form action="" method="post" enctype = "multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Instructors Name</label>
                                    <input readonly value="<?= $_SESSION['NAME']?>" type="text" class="form-control">
                                    <input type="hidden" name="id_instructors" value="<?= $_SESSION['ID_USER']?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Modul Name *</label>
                                    <input type="text" name="name" class="form-control" value="" placeholder="Enter Modul Name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Major Name</label>
                                    <select name="id_major" id="" class="form-control" required>
                                        <option value="">Select One</option>
                                        <?php foreach($rowInstructorsMajors as $data):?>
                                            <option value="<?= $data['id_majors']?>"><?= $data['name']?></option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                            </div>
                            <div align="right" class="mb-3">
                                <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                            </div>
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-success" name="save" value="Save">
                        </div>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Javascript -->
<script>
    // variabel
    // var ketika nilainya tidak ada maka tidak error.
    // let harus mempunyai nilai
    // const tidak boleh diubah nilainya

    // Menggunakan id
    // const button = document.getElementById('addRow');

    // Menggunakan class
    // const button = document.getElementsByClassName('addRow');

    // Menggunakan querySelector
    const button = document.querySelector('.addRow'); 
    const tbody = document.querySelector('#myTable tbody'); // untuk mengambil tbody dari table dengan id myTable
    // kalau mau gampang pake slector aja kalau manggil kelas pakai titik (.), kalau pakai id pakai pagar (#)

    // button.textContent = 'Tambah Baris'; // mengubah text content dari button
    // button.style.color = 'red'; // mengubah warna text content dari button
    // button.style.backgroundColor = 'yellow'; // mengubah warna background dari button

    button.addEventListener('click', function() {
        // alert ('Tombol Add Row Diklik');
        const tr = document.createElement('tr'); // membuat elemen tr baru
        tr.innerHTML = 
        `<td> <input type='file' name='file[]'> </td>
        <td>Delete</td>`;
        tbody.appendChild(tr); // menambahkan elemen tr ke tbody
    });
</script>