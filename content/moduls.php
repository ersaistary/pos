<?php 
    $id_user = isset($_SESSION['ID_USER'])? $_SESSION['ID_USER'] : '';
    $id_role = isset($_SESSION['ID_ROLE'])? $_SESSION['ID_ROLE'] : '';

    $rowStudent = mysqli_fetch_assoc(mysqli_query($config, "SELECT * FROM students WHERE id = '$id_user'"));
    $id_majors = isset($rowStudent['id_majors'])? $rowStudent['id_majors'] : '';
    
    if($id_role == 8){
        $where = "WHERE moduls.id_majors='$id_majors'";
    }else if($id_role == 6){
        $where = "WHERE moduls.id_instructors='$id_user'";
    }

    $queryModuls = mysqli_query($config, "SELECT majors.name as majors_name, instructors.name as instructors_name, moduls.* 
    FROM moduls 
    LEFT JOIN majors ON majors.id = moduls.id_majors
    LEFT JOIN instructors ON instructors.id = moduls.id_instructors
    $where
    ORDER BY moduls.id");
    $rowModuls = mysqli_fetch_all($queryModuls, MYSQLI_ASSOC);
    // print_r($rowModuls);die;
?>
 
<div class="row">
  <div class="col-12">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title mt-3">Data Modul</h5>
              <?php if(canAddModul($id_role)):?>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-moduls" class="btn btn-primary mb-3" >Add Modul</a>
                </div>
              <?php endif?>
              <div class="table-responsive">
                  <table class="table table-bordered datatable" >
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Title</th>
                              <th>Instructors</th>
                              <th>Majors</th>
                              <?php if($id_role==6):?>
                                <th>Action</th>
                                <?php endif ?>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($rowModuls as $key => $row):?>
                          <tr>
                              <td><?= $key + 1 ?></td>
                              <td>
                                  <a href="?page=tambah-moduls&detail=<?php echo $row['id']?>">
                                      <i class="bi bi-link"></i>
                                      <?= $row['name'] ?>
                                  </a>
                              </td>
                              <td><?= $row['instructors_name'] ?></td>
                              <td><?= $row['majors_name'] ?></td>
                              <?php if($id_role==6):?>
                                <td>
                                    <a href="?page=tambah-modul&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-moduls&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
                                </td>
                              <?php endif ?>
                          </tr>
                          <?php endforeach?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>