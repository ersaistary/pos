<?php 
    $queryMajors = mysqli_query($config, "SELECT * FROM majors WHERE deleted_at = 0");
    $rowMajors = mysqli_fetch_all($queryMajors, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-tittle mt-3">Data User</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-majors" class="btn btn-primary mb-3" >Tambah majors</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Majors</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($queryMajors as $key => $row):?>
                            <tr>
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td><?= $row['name'] ?></td>
                                <td class="text-center">
                                    <a href="?page=tambah-majors&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-majors&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
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