<?php
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE users SET deleted_at = 1 WHERE id = $id_user");
    if ($queryDelete) {
        header("location:?page=user&hapus=berhasil");
    } else {
        header("location:?page=user&hapus=gagal");
    }
}

if (isset($_GET['edit'])) {
    $id_user = $_GET['edit'];
    $selectEdit = mysqli_query($config, "SELECT * FROM users WHERE id = $id_user");
    $rowEdit = mysqli_fetch_assoc($selectEdit); 
}

if (isset($_POST['name'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    
    if (isset($_GET['edit'])) {
        $id_user = $_GET['edit'];
        if (!empty($_POST['password'])) {
            $password = sha1($_POST['password']);
            $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$id_user'";
        } else {
            $sql = "UPDATE users SET name='$name', email='$email' WHERE id='$id_user'";
        }
        $update = mysqli_query($config, $sql);
        header("location:?page=user&ubah=berhasil");

    } else {
        $password = sha1($_POST['password']);
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        $insert = mysqli_query($config, $sql);
        header("location:?page=user&tambah=berhasil");
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit User' : 'Add User' ?></h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Full Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your name" required value="<?= isset($_GET['edit']) ? $rowEdit['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Email *</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required value="<?= isset($_GET['edit']) ? $rowEdit['email'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Password *</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" <?= isset($_GET['edit']) ? '' : 'required' ?>>
                        <?php if (isset($_GET['edit'])): ?>
                            <small>*If you want to change your password, fill this field.</small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
