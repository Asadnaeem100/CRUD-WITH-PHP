<?php
//Connect to the Database

// INSERT INTO `notes` (`id`, `title`, `description`, `timestamp`) VALUES ('1', 'Asad Info', 'Hey Mate, My Name is Asad Naeem And Am From Faisalabad, Pakistan. How are You?', current_timestamp());

$insert = false;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notes";

//Connecting to the DataBase 
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
  echo "Sorry We Could Not Cnnect to the Database because of this error --->" . mysqli_connect_error($conn);
}
// echo $_GET["update"];
// echo $_POST["idEdit"];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // if(!isset( $_POST['idEdit'])) {
  //   //Update the Record
  //   exit();
  // }
  $title = $_POST['title'];
  $description = $_POST['description'];

  //Sql query to be executed
  $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
  $result = mysqli_query($conn, $sql);

  if($result){
    // echo "The Record has been added SuccessFully";
    $insert = true;
  }
  else{
    echo "Sorry we could not added record SuccessFully to the DataBase because of this error --->" . mysqli_connect_error($conn);
  }
}
?>
<!doctype html>
<html lang="ar">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <title>MyNotes</title>
  </head>
  <body>
    <!-- Edit modal -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
          Edit Modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <form action="/crud/index.php" method="post">
                <input type="hidden" class="idEdit" id="idEdit">
                <div class="form-group">
                  <label for="title">Note Title</label>
                  <input type="text" class="form-control" id="titleedit" name="titleedit">
                </div>
              <div class="form-group">
                  <label for="description">Note Description</label>
                  <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary my-3">Update Note</button>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">MyNotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      <?php

        if($insert){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your note has been inserted SuccessFully.
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
           }
        // else{
        //   echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        //   <strong>Sorry!</strong> Your notes can't inserted SuccessFully.
        //   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        // </div>";
        // }
      ?>
      <div class="container my-4">
            <h2 class="text-center">Add a Note</h2>
        <form action="/crud/index.php" method="POST">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary my-3">Add Note</button>
        </form>
      </div>

      <div class="container my-4">
         <?php
          /*$sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);

          while($row = mysqli_fetch_assoc($result)){
            echo $row['id'] . " Title " . $row['title'] . " Description is " . $row['description'];
            echo "<br>";
          } */
        ?> 

          <table class="table" id="myTable">
            <thead>
              <tr>
                <th scope="col">I.D</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $sql = "SELECT * FROM `notes`";
              $result = mysqli_query($conn, $sql);
                $id = 0;
               while($row = mysqli_fetch_assoc($result)){
                $id = $id + 1;
                  echo "<tr>
                      <th scope='row'>" . $id . "</th>
                      <td>" . $row['title'] . "</td>
                      <td>" . $row['description'] . "</td>
                      <td> <button class='edit btn btn-sm btn-primary'>Edit</button> <button class='btn btn-sm btn-danger'>Delete</button> </td>
                  </tr>";
                }
            ?>
            </tbody>
          </table>
          <button class="btn btn-sm btn-primary">Edit</button>
      </div>
      <hr>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" 
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      let table = new DataTable('#myTable');
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("edit ", );
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          titleedit.value = title;
          descriptionedit.value = description;
          // idEdit.value = e.target.id;
          // console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })
    </script>
    
  </body>
</html>