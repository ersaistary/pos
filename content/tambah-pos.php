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

$queryUserRole= mysqli_query($config, "SELECT user_roles.*, roles.name FROM user_roles 
LEFT JOIN roles ON user_roles.id_role = roles.id
ORDER BY user_roles.id DESC");
$rowUserRoles = mysqli_fetch_all($queryUserRole, MYSQLI_ASSOC);

if(isset($_POST['id_role'])){
    $id_role = $_POST['id_role'];
    $insert = mysqli_query($config, "INSERT INTO user_roles (id_role, id_user) VALUES ('$id_role', '$id_user')");
    header ("location:?page=tambah-user&add-user-role=" . $id_user . "&add-role=berhasil");
}

$queryProducts= mysqli_query($config, "SELECT * FROM products ORDER BY id DESC");
$rowProducts = mysqli_fetch_all($queryProducts, MYSQLI_ASSOC);

// BUAT NO TRANSACTION
$queryNoTrans = mysqli_query($config, "SELECT MAX(id) as id_trans FROM transactions");
$rowNoTrans = mysqli_fetch_assoc($queryNoTrans);
$id_trans = $rowNoTrans['id_trans'];
$id_trans++;
$increment_number = sprintf("%03d", $id_trans);
// $no_transaction= "TR" . "-" . date("dmy") . "-"  . str_pad("0", $id_trans, STR_PAD_LEFT);
$no_transaction= "TR" . "-" . date("dmy") . "-"  . $increment_number;


if(isset($_POST['save'])){
    $id_product = $_POST['id_product'];
    $id_user = $_POST['id_user'];
    $grand_total = $_POST['grand_total'];

    // Insert into transactions
    $insertTransaction = mysqli_query($config, "INSERT INTO transactions (no_transaction, id_user, sub_total) VALUES ('$no_transaction', '$id_user', '$grand_total')");

    if($insertTransaction){
        $last_id = mysqli_insert_id($config);
        $id_products = $_POST['id_product'];
        $qtys = $_POST['qty'];
        $totals = $_POST['total'];
        foreach ($_POST['id_product'] as $key => $value) {
            $id_product = $value;
            $qty = $qtys[$key];
            $total = $totals[$key];
            // Insert into transaction_details
            mysqli_query($config, "INSERT INTO transactions_details (id_transactions, id_product, qty, total) VALUES ('$last_id', '$id_product', '$qty', '$total')");
        }
        header("location:?page=pos&success=berhasil");
    } else {
        header("location:?page=pos&error=gagal");
    }
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
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="">No Transaction</label>
                                <input type="text" class="form-control" name="no_transaction" required value="<?= $no_transaction?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="">Product</label>
                                <select name="id_product" id="id_product" class="form-control">
                                    <option value="">Select One</option>
                                    <?php foreach ($rowProducts as $key => $data):?>
                                        <option data-price="<?php echo $data['price'] ?>" value="<?php echo $data['id'] ?>"><?php echo $data['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="">Cashier </label>
                                <input type="text" class="form-control" name="cashier_name" required value="<?= $_SESSION['NAME'] ?>" readonly>
                                <input type="hidden" name="id_user" value="<?= $_SESSION['ID_USER'] ?>"> 
                            </div>
                        </div>

                        <div align="right" class="mb-3">
                        <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                        </div>
                        <table class="table table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <br>
                        <p>
                            <strong>Grand Total : Rp <span id="grandTotal">0</span></strong>
                            <div class="mb-3">
                                <input type="hidden" name="grand_total" id="grandTotalInput" value=0>
                            </div>
                        </p>
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

<!-- Javascript -->
<script>
    const button = document.querySelector('.addRow'); 
    const tbody = document.querySelector('#myTable tbody'); // untuk mengambil tbody dari table dengan id myTable
    const select = document.querySelector('#id_product'); // untuk mengambil select id_product
    const grandTotal = document.getElementById('grandTotal'); // untuk mengambil input grand total
    const grandTotalInput = document.getElementById('grandTotalInput'); // untuk mengambil input grand total

    let no = 1; // untuk nomor urut
    button.addEventListener('click', function() {
        // alert ('Tombol Add Row Diklik');
        const selectedProduct = select.options[select.selectedIndex]; // mengambil opsi yang dipilih
        
        const productValue = selectedProduct.value; // id produk yang dipilih
        if (!productValue) {
            alert("Please select a product first!"); // jika tidak ada produk yang dipilih
            return; // keluar dari fungsi
        }
        const productName = selectedProduct.textContent; // nama produk yang dipilih
        const productPrice = selectedProduct.dataset.price; // harga produk yang dipilih
        const tr = document.createElement('tr'); // membuat elemen tr baru
        tr.innerHTML = 
        `<td>${no}</td>
        <td> <input type='hidden' name='id_product[]' class='id_products' value='${productValue}'>${productName}</td>
        <td> 
            <input type='number' name='qty[]' value='1' class='form-control qtys'>
            <input type='hidden' class="priceInput" name='price[]' value='${productPrice}'>
        </td>
        <td> <input type='hidden' name='total[]' class='totals' value='${productPrice}'><span class='totalText'>${productPrice}</span></td>
        <td>
            <button type='button' class='btn btn-danger removeRow' type='button'>Delete</button>
        </td>`;
        tbody.appendChild(tr); // menambahkan elemen tr ke tbody
        no++; // menambah nomor urut
        
        select.value = ""; // mengosongkan pilihan select setelah menambahkan baris baru
        updateGrandTotal(); // update grand total
    });

    tbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove(); // menghapus baris yang diklik
        }
        updateRowNumbers(); // update nomor urut
        updateGrandTotal(); // update grand total
    });

    function updateRowNumbers() {
        const rows = tbody.querySelectorAll('tr');

        rows.forEach(function(row, index){
            row.cells[0].textContent = index + 1; // update nomor urut
        });

        no= rows.length + 1; // update nomor urut untuk baris berikutnya
    }
    
    function updateGrandTotal() {
        const totalCells = tbody.querySelectorAll('.totals'); // mengambil semua input total
        let grand = 0; // inisialisasi grand total

        totalCells.forEach(function(input) {
            grand += parseInt(input.value) || 0; // menambahkan nilai total ke grand total
        });

        grandTotal.textContent = grand.toLocaleString('id-ID'); // update teks grand total
        grandTotalInput.value = grand; // update nilai input hidden grand total
    }

    tbody.addEventListener('input', function(e) {
        if (e.target.classList.contains('qtys')) {
            const row = e.target.closest('tr'); // mengambil baris terdekat
            const qty = parseInt(e.target.value) || 0; // mengambil nilai qty
            const price = parseInt(row.querySelector('.priceInput').value) || 0; // mengambil harga produk
            row.querySelector('.totalText').textContent = qty * price; // print total di elemen span
            row.querySelector('.totals').value = qty * price; // update nilai total di input hidden
            updateGrandTotal(); // update grand total
        }
    });
</script>
