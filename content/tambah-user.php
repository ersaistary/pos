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
$id_user = isset($_GET['add-user-role'])? $_GET['add-user-role']: '';

$queryRole= mysqli_query($config, "SELECT * FROM roles ORDER BY id DESC");
$rowRoles = mysqli_fetch_all($queryRole, MYSQLI_ASSOC);

$queryUserRole= mysqli_query($config, "SELECT user_roles.*, roles.name FROM user_roles 
LEFT JOIN roles ON user_roles.id_role = roles.id
ORDER BY user_roles.id DESC");
$rowUserRoles = mysqli_fetch_all($queryUserRole, MYSQLI_ASSOC);

if(isset($_POST['id_role'])){
    $id_role = $_POST['id_role'];
    $insert = mysqli_query($config, "INSERT INTO user_roles (id_role, id_user) VALUES ('$id_role', '$id_user')");
    header ("location:?page=tambah-user&add-user-role=" . $id_user . "&add-role=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <?php if(isset($_GET['add-user-role'])):
                    $title = "Add User Role";
                elseif(isset($_GET['edit'])):
                    $title= "Edit User";
                else:
                    $title = "Add User";
                endif
                ?>
                <h5 class="card-title"><?= $title ?></h5>
                <?php if(isset($_GET['add-user-role'])):?>
                    <div align="right" class="mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Role</button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowUserRoles as $key => $data):?>
                            <tr>
                                <td><?= $key + 1?></td>
                                <td><?= $data['name']?></td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <!-- kalau gaada add user role -->
                <?php else: ?>
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
                <?php endif?>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
          <div class="modal-body">
            <div class="mb-3">
                <label for="" class="form_label" >Role Name</label>
                <select name="id_role" id="" class="form-control">
                    <option value="">Select One</option>
                    <?php foreach ($rowRoles as $KEY => $data):?>
                        <option value="<?php echo $data['id'] ?>"><?php echo $data['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>
