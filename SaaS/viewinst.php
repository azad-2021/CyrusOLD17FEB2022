<?php

include('connection.php'); 
include 'session.php';
$username = $_SESSION['user'];
$query ="SELECT * FROM `orders` WHERE Installed='1'";
$results = mysqli_query($con, $query);

if(isset($_POST['submit'])){



  $OrderID=$_POST['OrderID'];
  $Remark=$_POST['Remark'];



  $sql = "UPDATE installation SET Remark='$Remark' WHERE OrderID=$OrderID";

  if ($con->query($sql) === TRUE) {
    echo '<script>alert("Your response recorded successfully")</script>';
    echo '<meta http-equiv="refresh" content="0">';
  }else {
    echo "Error updating record: " . $con->error;
  }


}


?>

<!DOCTYPE html>  
<html>  
<head>   
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <meta name="description" content="">
 <meta name="author" content="Anant Singh Suryavanshi">
 <title>Installation</title>
 <link rel="icon" href="cyrus logo.png" type="image/icon type">
 <!-- Bootstrap core CSS -->
 <link href="bootstrap/css/bootstrap.css" rel="stylesheet">  
 <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css"/>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">  
 <link rel="stylesheet" type="text/css" href="css/style.css"> 
 <link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
 <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/staterestore/1.0.1/css/stateRestore.dataTables.min.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #E0E1DE;" id="nav">
    <div class="container-fluid" align="center">
      <a class="navbar-brand" href="index.html"><img src="cyrus logo.png" alt="cyrus.com" width="50" height="60">Cyrus Electronics</a>
      <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-md-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="instable.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewinst.php?">View Submitted Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/cyrus/executive/changepass.php">Change Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <br><br> 

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Remark</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="POST" action="">
              <div class="mb-3 d-none">
                <label for="recipient-name" class="col-form-label ">Recipient:</label>
                <input type="text" class="form-control" id="recipient-name" name="OrderID">

              </div>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Remark</label>
                <textarea class="form-control" id="message-text" name="Remark"></textarea>
              </div>
              
            </div>
            <div class="modal-footer">
              <input type="submit"  class=" btn btn-success my-button" value="submit" name="submit">
            </form>
            <button type="button" class="btn btn-secondary my-button" data-bs-dismiss="modal">Close</button>
            
          </div>
        </div>
      </div>
    </div>

    <h3 align="center">View Installation Details</h3>  
    <br />  
    <div class="table-responsive">  
     <table class="table table-hover table-bordered border-primary" id="example"> 
      <thead> 
        <tr>  
          <th>Bank</th> 
          <th>Zone</th> 
          <th>Branch</th> 
          <th>Order ID</th>
          <th>Gadget</th> 
          <th>Mobile No</th> 
          <th>Sim NO</th> 
          <th>Sim Type</th> 
          <th>Operator</th> 
          <th>Sim Provider</th>
          <th>Executive</th>
          <th>Remark Orders</th>
          <th>Remark Sim Provider</th>
          <th>Panel Issue Date</th>
          <th>Panel Issue To</th>
          <th>Installed By</th>
          <th>Installation Date</th>
          <th>Action</th>
        </tr>                     
      </thead>                 
      <tbody> 
        <?php  
        while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){ 

          $BranchCode=$row["BranchCode"];
          $GadgetID=$row["GadgetID"];
          $OrderID=$row["OrderID"];

          $queryP ="SELECT * FROM `production` WHERE OrderID=$OrderID";
          $resultsP = mysqli_query($con, $queryP);
          $row8=mysqli_fetch_array($resultsP,MYSQLI_ASSOC);
          $SimID=$row8["SimID"];

          $queryBranch ="SELECT * FROM branchdetails WHERE `BranchCode`='$BranchCode'";
          $resultBranch = mysqli_query($con2, $queryBranch);
          $row4=mysqli_fetch_array($resultBranch,MYSQLI_ASSOC);
          $Branch=$row4["BranchName"];
          
          $Zone=$row4["ZoneRegionName"];
          $Bank=$row4["BankName"];

          $queryGadget ="SELECT Gadget FROM `gadget` WHERE GadgetID=$GadgetID";
          $resultGadget = mysqli_query($con, $queryGadget);
          $row5=mysqli_fetch_array($resultGadget,MYSQLI_ASSOC);
          $Gadget=$row5["Gadget"];

          $querySim ="SELECT * FROM `simprovider` WHERE ID=$SimID";
          $resultsSim = mysqli_query($con, $querySim);
          $row6=mysqli_fetch_array($resultsSim,MYSQLI_ASSOC);
          $OperatorID=$row6["OperatorID"];

          $queryO ="SELECT * FROM `operators` WHERE OperatorID=$OperatorID";
          $resultsO = mysqli_query($con, $queryO);
          $row7=mysqli_fetch_array($resultsO,MYSQLI_ASSOC);

          $queryS ="SELECT * FROM `store` WHERE OrderID=$OrderID";
          $resultsS = mysqli_query($con, $queryS);
          $row9=mysqli_fetch_array($resultsS,MYSQLI_ASSOC);
          $EmployeeID=$row9["EmployeeCode"];
          $queryE ="SELECT * FROM `employees` WHERE `EmployeeCode`=$EmployeeID";
          $resultsE = mysqli_query($con2, $queryE);
          $row10=mysqli_fetch_array($resultsE,MYSQLI_ASSOC);

          $queryIS ="SELECT * FROM `installation` WHERE OrderID=$OrderID";
          $resultsIS = mysqli_query($con, $queryIS);
          $rowIS=mysqli_fetch_array($resultsIS,MYSQLI_ASSOC);
          $InstalledByID=$rowIS["InstalledBy"];
          $InstallationDate=$rowIS["InstallationDate"];
          $queryI ="SELECT * FROM `employees` WHERE `EmployeeCode`=$InstalledByID";
          $resultsI = mysqli_query($con2, $queryI);
          $rowI=mysqli_fetch_array($resultsI,MYSQLI_ASSOC);


          echo '  
          <tr> 
          <td>'.$Bank.'</td>
          <td>'.$Zone.'</td>  
          <td>'.$Branch.'</td>
          <td>'.$row["OrderID"].'</td>  
          <td>'.$Gadget.'</td>  
          <td>'.$row6["MobileNumber"].'</td>
          <td>'.$row6["SimNo"].'</td> 
          <td>'.$row6["SimType"].'</td>   
          <td>'.$row7["Operator"].'</td>  
          <td>'.$row6["SimProvider"].'</td>  
          <td>'.$row["Executive"].'</td>
          <td>'.$row["Remark"].'</td>
          <td>'.$row6["Remark"].'</td>
          <td>'.$row9["ReleaseDate"].'</td>
          <td>'.$row10["Employee Name"].'</td>
          <td>'.$rowI["Employee Name"].'</td> 
          <td>'.$InstallationDate.'</td>
          <td>'
          ?>

          <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="<?php print $row["OrderID"]; ?>"><?php print $rowIS["Remark"].' : Update'; ?></a>
          <?php
          print '<a target="blank" href=update.php?id='.$row["OrderID"].'&Type=Ins> Update Number</a>';
          "</td>"
          ;  
        }

        ?> 

      </table>  
    </div>  
  </div>  

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js
  "></script>
  <script src="https://cdn.datatables.net/staterestore/1.0.1/js/dataTables.stateRestore.min.js"></script>

  <script>

    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            return 'Details for '+data[0]+' '+data[1];
                        }
                    } ),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                        tableClass: 'table'
                    } )
                }
            },
            stateSave: true,

        } );
    } );

    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = exampleModal.querySelector('.modal-title')
  var modalBodyInput = exampleModal.querySelector('.modal-body input')

  modalTitle.textContent = 'New Remark for Order ID ' + recipient
  modalBodyInput.value = recipient
})

</script>
</body>
</html>