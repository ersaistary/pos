<?php 
if (isset($_GET['delete'])) {
    $id_instructor = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE instructors SET deleted_at = 1 WHERE id = $id_instructor");
    if ($queryDelete) {
        header("location:?page=instructors&hapus=berhasil");
        exit;
    } else {
        header("location:?page=instructors&hapus=gagal");
        exit;
    }
}

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : 0;
    $education = $_POST['education'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = isset($_POST['password']) ? sha1($_POST['password']) : '';
    $id_instructor = isset($_GET['edit']) ? $_GET['edit'] : '';
    
    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO instructors (name, gender, education, phone, email, address, password) VALUES ('$name', '$gender', '$education', '$phone', '$email', '$address', '$password')");
        header("location:?page=instructors&tambah=berhasil");
        exit;
    } else {
        $update = mysqli_query($config, "UPDATE instructors SET name='$name', gender='$gender', education='$education', phone='$phone', email='$email', address='$address', password='$password' WHERE id = $id_instructor");
        header("location:?page=instructors&ubah=berhasil");
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id_instructor = $_GET['edit'];
    $selectEdit = mysqli_query($config, "SELECT * FROM instructors WHERE id = $id_instructor");
    $rowEdit = mysqli_fetch_assoc($selectEdit);
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit Instructor' : 'Add Instructor' ?></h5>

                <form action="" method="post">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter instructor name" required
                            value="<?= isset($_GET['edit']) ? htmlspecialchars($rowEdit['name']) : '' ?>">
                    </div>
                    
                    <!-- Gender with radio buttons -->
                    <div class="mb-3">
                        <label for="">Gender *</label>
                        <br>
                        <input type="radio" name="gender" value="0" <?= (isset($_GET['edit']) && isset($rowEdit['gender']) && $rowEdit['gender'] == 0) ? 'checked' : '' ?>>
                        <label for="male">Male</label>

                        <input type="radio" name="gender" value="1" <?= (isset($_GET['edit']) && isset($rowEdit['gender']) && $rowEdit['gender'] == 1) ? 'checked' : '' ?>>
                        <label for="female">Female</label>
                    </div>
                    
                    <!-- Education -->
                    <div class="mb-3">
                        <label for="education">Education *</label>
                        <input type="text" class="form-control" name="education" id="education" placeholder="Enter education" required
                            value="<?= isset($_GET['edit']) ? htmlspecialchars($rowEdit['education']) : '' ?>">
                    </div>
                    
                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone">Phone *</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone number" required 
                            value="<?= isset($_GET['edit']) ? htmlspecialchars($rowEdit['phone']) : '' ?>">
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required 
                            value="<?= isset($_GET['edit']) ? htmlspecialchars($rowEdit['email']) : '' ?>">
                    </div>

                    <!-- Password -->
                     <div class="mb-3">
                        <label for="">Password *</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" <?= isset($_GET['edit']) ? '' : 'required' ?>>
                        <?php if (isset($_GET['edit'])): ?>
                            <small>*If you want to change your password, fill this field.</small>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address">Address *</label>
                        <textarea class="form-control" name="address" id="address" placeholder="Enter address" required><?= isset($_GET['edit']) ? htmlspecialchars($rowEdit['address']) : '' ?></textarea>
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
