<?php 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $id_instructors = isset($_GET['id_instructors']) ? $_GET['id_instructors'] : '';


    $queryDelete = mysqli_query($config, "DELETE FROM instructors_majors WHERE id = $id");
    if ($queryDelete) {
        header("location:?page=tambah-instructors-majors&id=" . $id_instructors . "&hapus=berhasil");
        exit;
    } else {
        header("location:?page=tambah-instructors-majors&id=" . $id_instructors . "&hapus=gagal");
        exit;
    }
}

$id_instructors = isset($_GET['id']) ? $_GET['id'] : '';
$edit = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_POST['id_major'])) {
    $id_major = $_POST['id_major'];
    if(isset($_GET['edit'])){
        $update = mysqli_query($config, "UPDATE instructors_majors SET id_majors = '$id_major' WHERE id = '$edit'");
        header("location:?page=tambah-instructors-majors&id=" . $id_instructors . "&ubah=berhasil");
        
    }else{
        $insert = mysqli_query($config, "INSERT INTO instructors_majors (id_majors, id_instructors) VALUES ('$id_major', '$id_instructors')");
        header("location:?page=tambah-instructors-majors&id=" . $id_instructors . "&tambah=berhasil");
    }
    
    $id_instructor = isset($_GET['edit']) ? $_GET['edit'] : '';
}

$queryMajors= mysqli_query($config, "SELECT * FROM majors ORDER BY id DESC");
$rowMajors = mysqli_fetch_all($queryMajors, MYSQLI_ASSOC);

$queryInstructors = mysqli_query ($config, "SELECT * FROM instructors WHERE id = '$id_instructors'");
$rowInstructors = mysqli_fetch_assoc($queryInstructors);

$queryInstructorsMajors = mysqli_query($config, "SELECT majors.name, instructors_majors.id, id_instructors FROM instructors_majors 
LEFT JOIN majors ON majors.id = instructors_majors.id_majors WHERE id_instructors='$id_instructors'  ORDER BY instructors_majors.id DESC");

$rowInstructorsMajors = mysqli_fetch_all ($queryInstructorsMajors, MYSQLI_ASSOC);

$queryEdit = mysqli_query($config, "SELECT * FROM instructors_majors WHERE id = '$edit'");
$rowEdit = mysqli_fetch_assoc($queryEdit);



// if (isset($_GET['edit'])) {
//     $id_instructor_majors = $_GET['edit'];
//     $selectEdit = mysqli_query($config, "SELECT * FROM instructors_majors WHERE id = $id_instructor_majors");
//     $rowEdit = mysqli_fetch_assoc($selectEdit);
// }

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body mt-3">
                <h5 class="card-title"><?= isset($_GET['edit']) ? 'Edit Instructor Major' : 'Add Instructor Major' ?></h5>
                <!-- Form Edit -->
                 <?php if(isset($_GET['edit'])) :?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form_label" >Major Name</label>
                            <select name="id_major" id="" class="form-control">
                                <!-- <option value="">Select One </option> -->
                                <?php foreach ($rowMajors as $KEY => $data):?>
                                    <option <?php echo ($data['id']== $rowEdit['id_majors'])? 'selected' : '' ?> value="<?php echo $data['id'] ?>"><?php echo $data['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" >Save Changes</button>
                        </div>
                    </form>
                    <!-- End form edit -->   

                    <?php else: ?>
                    <!-- listing table -->
                        <div align='right'>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add Instructor Majors
                            </button>
                        </div>
                        
                        <table class="table teble-bordered">
                            <thead class="text-center">
                                <th>No</th>
                                <th>Major Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php foreach ($rowInstructorsMajors as $key => $data) :?>
                                    <tr class="text-center">
                                        <td><?= $key += 1?></td>
                                        <td><?= $data['name']?></td>
                                        <td>
                                            <a href="?page=tambah-instructors-majors&id=<?php echo $data['id_instructors']?>&edit=<?php echo $data['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                            <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-instructors-majors&delete=<?php echo $data['id']?>&id_instructors=<?php echo $data['id_instructors']?>" class = "btn btn-danger" name="delete">Delete</a>
                                        </td>
                                    </tr>
                                
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <!-- end listing table -->
                    <?php endif ?>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Instructors Major</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post">
          <div class="modal-body">
            <div class="mb-3">
                <label for="" class="form_label" >Major Name</label>
                <select name="id_major" id="" class="form-control">
                    <option value="">Select One</option>
                    <?php foreach ($rowMajors as $KEY => $data):?>
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
