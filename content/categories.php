<?php 
    $queryCategories = mysqli_query($config, "SELECT * FROM categories");
    $rowCategories = mysqli_fetch_all($queryCategories, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-tittle mt-3">Data Categories</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-categories" class="btn btn-primary mb-3" >Add Categories</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" >
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Categories</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowCategories as $key => $row):?>
                            <tr>
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td><?= $row['name'] ?></td>
                                <td class="text-center">
                                    <a href="?page=tambah-categories&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-categories&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
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