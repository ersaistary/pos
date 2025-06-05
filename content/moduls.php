<?php 
    $queryModuls = mysqli_query($config, "SELECT majors.name as majors_name, instructors.name as intructors_name, moduls.* 
    FROM moduls 
    LEFT JOIN majors ON majors.id = moduls.id_majors
    LEFT JOIN instructors ON instructors.id = moduls.id_instructors
    ORDER BY moduls.id");
    $rowModuls = mysqli_fetch_all($queryModuls, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-tittle mt-3">Data Modul</h5>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-moduls" class="btn btn-primary mb-3" >Add Modull</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Instructors</th>
                                <th>Majors</th>
                                <th>Title</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowModuls as $key => $row):?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $row['instructors_name'] ?></td>
                                <td><?= $row['majors_name'] ?></td>
                                <td>
                                    <a href="?page=tambah-modul&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-modul&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
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