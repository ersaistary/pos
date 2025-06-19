<?php
$query= mysqli_query($config, "SELECT transactions.*, users.name FROM transactions
LEFT JOIN users ON transactions.id_user = users.id
ORDER BY transactions.id DESC");
$rowQuery = mysqli_fetch_all($query, MYSQLI_ASSOC);

if(isset($_POST['add_transaction'])){
    header("location:?page=tambah-pos");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($config, "DELETE FROM transactions WHERE id = '$id'");
    header("location:?page=pos&delete=success");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- <?php if(isset($_GET['add-user-role'])):
                    $title = "Add User Role";
                elseif(isset($_GET['edit'])):
                    $title= "Edit User";
                else:
                    $title = "Add User";
                endif
                ?> -->
                <h5 class="card-title"><?= $title ?></h5>
                <?php //if(isset($_GET['add-user-role'])):?>
                    <div align="right" class="mb-3">
                        <form action="" method="post">
                            <button class="btn btn-primary" name="add_transaction">Add Transaction</button>

                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Transaction</th>
                                <th>Cashier Name</th>
                                <th>Sub Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowQuery as $key => $data):?>
                            <tr>
                                <td><?= $key + 1?></td>
                                <td><?= $data['no_transaction']?></td>
                                <td><?= $data['name']?></td>
                                <td><?= "Rp " . $data['sub_total']?></td>
                                <td>
                                    <a href="?page=print-pos&print=<?= $data['id'] ?>" class="btn btn-primary btn-sm">Print</a>
                                    <a href="?page=pos&delete=<?= $data['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <!-- kalau gaada add user role -->
                <?php// else: ?>
                <!-- <form action="" method="post">
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
                        <?php// if (isset($_GET['edit'])): ?>
                            <small>*If you want to change your password, fill this field.</small>
                        <?php //endif; ?>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="save" value="Save">
                    </div>
                </form> -->
                <?php //endif?>
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
