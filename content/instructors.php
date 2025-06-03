<?php 
    $queryInstructors = mysqli_query($config, "SELECT * FROM instructors WHERE deleted_at = 0");
    $rowInstructors = mysqli_fetch_all($queryInstructors, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-tittle mt-3">Data User</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-instructors" class="btn btn-primary mb-3" >Tambah instructors</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Education</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($queryInstructors as $key => $row):?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['gender'] == 1 ? 'Woman' : 'Man' ?></td>
                                <td><?= $row['education'] ?></td>
                                <td><?= $row['phone'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['address'] ?></td>
                                <td class="text-center">
                                    <a href="?page=tambah-instructors&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-instructors&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>