<?php 
if(isset($_GET['delete'])){
    $id_majors = isset($_GET['delete'])? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "UPDATE majors SET deleted_at = 1 WHERE id = $id_majors");
    if($queryDelete){
        header("location:?page=majors&hapus=berhasil");
    }else{
        header("location:?page=majors&hapus=gagal");
    }
}

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $id_majors = isset($_GET['edit'])? $_GET['edit'] : '';
    if(!isset($_GET['edit'])){
        $insert = mysqli_query ($config, "INSERT INTO majors (name) VALUES ('$name')");
        header("location:?page=majors&tambah=berhasil");
    }else{
        $update = mysqli_query ($config, "UPDATE majors SET name='$name' WHERE id = $id_majors");
        header("location:?page=majors&ubah=berhasil");
    }
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
    // print_r($rowInstructorsMajors);
    // die;
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit Modul' : 'Add Modul' ?></h5>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Instructors Name</label>
                                <input readonly value="<?= $_SESSION['NAME']?>" type="text" class="form-control">
                                <input type="hidden" name="id_instructors" value="<?= $_SESSION['ID_USER']?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Modul Name</label>
                                <select name="id_major" id="" class="form-control">
                                    <option value="">Select One</option>
                                    <?php foreach($rowInstructorsMajors as $data):?>
                                        <option value="<?= $data['id_majors']?>"><?= $data['name']?></option>
                                    <?php endforeach?>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>