<?php 
include 'connection.php';
//include 'session.php';
//$EXEID=$_SESSION['userid'];
date_default_timezone_set('Asia/Kolkata');
$timestamp =date('y-m-d H:i:s');
$orgDate = date('Y-m-d',strtotime($timestamp));
$Date = date('Y-m-d', strtotime($orgDate. ' -1 days'));


?>



<!DOCTYPE html>  
<html>  
<head>   
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="Anant Singh Suryavanshi">
	<title>Reminders</title>
	<link rel="icon" href="cyrus logo.png" type="image/icon type">
	<!-- Bootstrap core CSS -->
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

	<style type="text/css">
	label{
		margin: 5px;
	}
</style>

</head>  
<body> 
	<?php 
	include 'navbar.php';
	include 'modals.php';

	?>
	<div class="container">
		<div class="col-lg-12 table-responsive" style="margin: 12px;">
			<h5 align="center">Pending GST Bills Based on No Reminders</h5>
			<table class="table table-hover table-bordered border-primary display"> 
				<thead> 
					<tr> 
						<th style="min-width:160px">Bank</th>
						<th style="min-width:80px">Zone</th>           
						<th style="min-width:150px">Branch</th>
						<th style="min-width:100px">Bill No</th>
						<th style="min-width:80px">Bill Date</th>        
						<th style="min-width: 100px;">Total Billed Value</th> 
						<th style="min-width: 100px;">Received Amount</th> 
						<th style="min-width: 100px;">Pending Payment</th>             
					</tr>                     
				</thead>                 
				<tbody>
					<?php 
					$query="SELECT * FROM cyrusbilling.billbook join cyrusbackend.branchdetails on billbook.BranchCode=branchdetails.BranchCode
					join cyrusbackend.zoneregions on branchdetails.ZoneRegionCode=zoneregions.ZoneRegionCode
					WHERE NOT EXISTS 
					(SELECT BillID FROM cyrusbilling.reminders WHERE reminders.BillID = billbook.BillID) and Cancelled=0
					and (billbook.TotalBilledValue - billbook.ReceivedAmount) >1 and billbook.Cancelled=0
					and zoneregions.BankCode not in (17,29,30,33,43,46,49,50,52) and billbook.BillDate <'$Date'";
					$result=mysqli_query($con2,$query);
					while($row = mysqli_fetch_array($result)){

						print "<tr>";
						print "<td>".$row['BankName']."</td>";             
						print "<td>".$row['ZoneRegionName']."</td>";
						print "<td>".$row['BranchName']."</td>"; 

						print '<td><a data-bs-toggle="modal" data-bs-target="#Bill" class="Bill" id="'.$row['BranchCode'].'" href="">'.$row['BookNo']."</a></td>";

						print "<td>".$row['BillDate']."</td>";
						print "<td>".$row['TotalBilledValue']."</td>";
						print "<td>".$row['ReceivedAmount']."</td>";
						print "<td>".sprintf('%0.2f', ($row['TotalBilledValue']-$row['ReceivedAmount']))."</td>";
						print "</tr>";
						
					}

					?>
				</tbody>
			</table>

		</div>

		<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
		<script src="ajax-script.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('table.display').DataTable( {
					responsive: false
				} );
			} );
		</script>
	</body>
	</html>
	<?php 
	$con->close();
	$con2->close();
?>