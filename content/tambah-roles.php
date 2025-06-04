<?php 
if(isset($_GET['delete'])){
    $id_roles = isset($_GET['delete'])? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "UPDATE roles SET deleted_at = 1 WHERE id = $id_roles");
    if($queryDelete){
        header("location:?page=roles&hapus=berhasil");
    }else{
        header("location:?page=roles&hapus=gagal");
    }
}

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $id_roles = isset($_GET['edit'])? $_GET['edit'] : '';
    if(!isset($_GET['edit'])){
        $insert = mysqli_query ($config, "INSERT INTO roles (name) VALUES ('$name')");
        header("location:?page=roles&tambah=berhasil");
    }else{
        $update = mysqli_query ($config, "UPDATE roles SET name='$name' WHERE id = $id_roles");
        header("location:?page=roles&ubah=berhasil");
    }
}


if(isset($_GET['edit'])){
    $id_roles = isset($_GET['edit'])? $_GET['edit'] : '';
    $selectEdit = mysqli_query($config, "SELECT * FROM roles WHERE id=$id_roles");
    $rowEdit = mysqli_fetch_assoc($selectEdit); 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit Role' : 'Add Role' ?></h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Role Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Role" required value="<?= isset($_GET['edit'])? $rowEdit['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>