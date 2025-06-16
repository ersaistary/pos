<?php 
if (isset($_GET['delete'])) {
    $id_products = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM products WHERE id = $id_products");
    if ($queryDelete) {
        header("location:?page=product&hapus=berhasil");
        exit;
    } else {
        header("location:?page=product&hapus=gagal");
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id_products = $_GET['edit'];
    $selectEdit = mysqli_query($config, "SELECT * FROM products WHERE id = $id_products");
    $rowEdit = mysqli_fetch_assoc($selectEdit);
}

if (isset($_POST['name'])) {
    $id_category = $_POST['id_category'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $description = $_POST['description'];

    $id_products = isset($_GET['edit']) ? $_GET['edit'] : '';
    
    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO products (id_category, name, price, qty, description) VALUES ('$id_category', '$name', '$price', '$qty', '$description')");
        header("location:?page=product&tambah=berhasil");
        exit;
    } else {
        $update = mysqli_query($config, "UPDATE products SET id_category='$id_category', name='$name', price='$price', qty='$qty', description='$description' WHERE id = $id_products");
        header("location:?page=product&ubah=berhasil");
        exit;
    }
}

$queryCategory = mysqli_query ($config, "SELECT * FROM categories");
$rowCategories = mysqli_fetch_all ($queryCategory, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit products' : 'Add products' ?></h5>

                <form action="" method="post">              
                    <!-- categories v2 -->
                     <div class="mb-3">
                        <label for="name">Category *</label>
                        <select name="id_category" class="form-control">
                            <option value="">Select one category</option>
                            <?php foreach ($rowCategories as $key => $data):?>
                                <option value="<?= $data['id']?>" 
                                    <?= isset($_GET['edit']) && $rowEdit['id_category'] == $data['id'] ? 'selected' : '' ?>>
                                    <?= $data['name']?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- name -->
                    <div class="mb-3">
                        <label for="">Name *</label>
                        <br>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name " required value="<?= isset($_GET['edit']) ? $rowEdit['name'] : '' ?>">
                    </div>
                    
                    <!-- price -->
                    <div class="mb-3">
                        
                        <label for="price">Price *</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" required 
                            value="<?= isset($_GET['edit']) ? $rowEdit['price'] : '' ?>">
                    </div>
                    
                    <!-- qty -->
                    <div class="mb-3">
                        <label for="qty">Quantity *</label>
                        <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter quantity" required 
                            value="<?= isset($_GET['edit']) ? $rowEdit['qty'] : '' ?>">
                    </div>

                    <!-- description -->
                     <div class="mb-3">
                        <label for="">Description *</label>
                        <textarea name="description" id="" class="form-control" <?= isset($_GET['edit']) ? '' : 'required' ?>><?= isset($_GET['edit']) ? $rowEdit['description'] : '' ?></textarea>
                    </div>                    
                    <!-- Submit button -->
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
