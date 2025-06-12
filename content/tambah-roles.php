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

if(isset($_GET['add-role-menu'])){
    $id_roles = $_GET['add-role-menu'];

    $rowEditRoleMenus = [];
    $edit =[];
    $editRoleMenus = mysqli_query($config, "SELECT * FROM menu_roles WHERE id_roles = '$id_roles'");
    // $rowEditRoleMenus = mysqli_fetch_all($editRoleMenus, MYSQLI_ASSOC);
    while($editMenus = mysqli_fetch_assoc($editRoleMenus)){
        $rowEditRoleMenus[] = $editMenus['id_menus'];
    }
    
    
    $menus = mysqli_query($config, "SELECT * FROM menus ORDER BY parent_id, urutan");
    $rowMenus = [];
    while($m = mysqli_fetch_assoc($menus)){
        $rowMenus[] = $m;
    }
}

if(isset($_POST['save'])){
    $id_role = $_GET['add-role-menu'];
    $id_menus = $_POST['id_menus'] ?? [];

    // mysqli_query($config, "DELETE FROM menu_roles WHERE id_roles = '$id_role'");
    mysqli_query($config, "DELETE FROM menu_roles WHERE id_roles = '$id_role'");
    foreach ($id_menus as $m){
        $id_menu = $m;
        mysqli_query($config, "INSERT INTO menu_roles (id_roles, id_menus) VALUES ('$id_role', '$id_menu')");
    }
    header("location:?page=tambah-roles&add-role-menu=" . $id_role . "&tambah=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit Role' : 'Add Role' ?></h5>
                <?php if(isset($_GET['add-role-menu'])): ?>
                    <!-- Role x dapat menampilkan menu apa saja -->
                    <form action="" method="post">
                        <div class="mb-3">
                            <ul>
                                <?php foreach ($rowMenus as $mainMenu): ?>
                                <?php if($mainMenu['parent_id'] == 0 or $mainMenu ['parent_id'] == ''):?>
                                    <li>
                                        <label for="" class="form-label">
                                            <input <?php echo in_array($mainMenu['id'], $rowEditRoleMenus, true) ? 'checked' : ''?> type="checkbox" name="id_menus[]" value="<?= $mainMenu['id'] ?>">
                                            <?= $mainMenu['name']?>
                                        </label>
                                        <ul>
                                            <?php foreach ($rowMenus as $subMenu): ?>
                                        <?php if($subMenu['parent_id'] == $mainMenu['id']):?>
                                        <li>
                                            <input <?php echo in_array($subMenu['id'], $rowEditRoleMenus, true) ? 'checked' : ''?> type="checkbox" name="id_menus[]" value="<?= $subMenu['id'] ?>">
                                            <?= $subMenu['name']?>
                                        </li>
                                        <?php endif ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <?php endif ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-sm btn-primary" name="save">Save Change</button>
                        </div>

                    </form>
                <?php else:?>
                    <!-- Kalau ada parameter edit, dia bakal edit kalo gaada dia bakal nambah -->
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="">Role Name *</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Role" required value="<?= isset($_GET['edit'])? $rowEdit['name'] : '' ?>">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </div>
                        </form>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>