<?php 
    $queryProducts = mysqli_query($config, 
    "SELECT products.*, categories.name as categories_name FROM products 
    LEFT JOIN categories ON categories.id = products.id_category
    ");
    $rowProducts = mysqli_fetch_all($queryProducts, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-tittle mt-3">Data Product</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-products" class="btn btn-primary mb-3" >Tambah Product</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($queryProducts as $key => $row):?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $row['categories_name']?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['price'] ?></td>
                                <td><?= $row['qty'] ?></td>
                                <td><?= $row['description'] ?></td>
                                <td class="text-center">
                                    <a href="?page=tambah-products-majors&id=<?php echo $row['id']?>" class = "btn btn-warning" name="edit">Add Major</a>
                                    <a href="?page=tambah-products&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-products&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
                                    
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