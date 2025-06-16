<?php 
if(isset($_GET['delete'])){
    $id_Categories = isset($_GET['delete'])? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "DELETE FROM categories WHERE id = $id_categories");
    if($queryDelete){
        header("location:?page=categories&hapus=berhasil");
    }else{
        header("location:?page=categories&hapus=gagal");
    }
}

if(isset($_POST['name'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $id_categories = isset($_GET['edit'])? $_GET['edit'] : '';
    if(!isset($_GET['edit'])){
        $insert = mysqli_query ($config, "INSERT INTO categories (name) VALUES ('$name')");
        header("location:?page=categories&tambah=berhasil");
    }else{
        $update = mysqli_query ($config, "UPDATE categories SET name='$name' WHERE id = $id_categories");
        header("location:?page=categories&ubah=berhasil");
    }
}


if(isset($_GET['edit'])){
    $id_categories = isset($_GET['edit'])? $_GET['edit'] : '';
    $selectEdit = mysqli_query($config, "SELECT * FROM categories WHERE id=$id_categories");
    $rowEdit = mysqli_fetch_assoc($selectEdit); 
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit Categories' : 'Add Categories' ?></h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Categories *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter categories" required value="<?= isset($_GET['edit'])? $rowEdit['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>