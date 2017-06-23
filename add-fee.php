<?php 
require_once("config.php"); 

//checking if action is from add parents from
if(isset($_POST['class_id'])){

/* 
securedata() is define in include/function.php
It is for data validation (For Security).

encrypt_decrypt() is defined in include/function.php
This function is used for encryption and decryption. 
*/
$class_id=securedata($_POST['class_id']);
$session_from_year=securedata($_POST['session_from_year']);
$session_to_year=securedata($_POST['session_to_year']);
$submission_last_date=securedata($_POST['submission_last_date']);
$amount=securedata($_POST['amount']);
$fee_per_month=securedata($_POST['fee_per_month']);
$fine_per_day=securedata($_POST['fine_per_day']);
$note=securedata($_POST['note']);
if(empty($class_id)){
	$error_msg="Please select class";
}else if(empty($session_from_year)){
	$error_msg="Please select session";
} if(empty($session_to_year)){
	$error_msg="Please select session";
}if(empty($submission_last_date)){
	$error_msg="Please select last date of submission without fine";
}if(empty($amount)){
	$error_msg="Please enter amount";
}if(empty($fee_per_month)){
	$error_msg="Please enter fee";
}if(empty($fine_per_day)){
	$error_msg="Please enter fine";
}else if(mysqli_num_rows(mysqli_query($con,"select id from fee where class_id='$class_id' and session_from_year='$session_from_year' and session_to_year='$session_to_year'"))>0){
	$error_msg="Sorry! fee already exist";
}else{
	
	{

	if(mysqli_query($con,"insert into fee(class_id,session_from_year,session_to_year,amount,fee_per_month,fine_per_day,submission_last_date,note)values ('$class_id','$session_from_year','$session_to_year','$amount','$fee_per_month','$fine_per_day','$submission_last_date','$note')")){
		$success_msg="Fee Added successfully";
	}else{
		$error_msg= "Technical problem, data not inserted in table";
		
	}															   									
				 
}		
}
}		 
                

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $school_name; ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php require("header.php"); ?>
<!-- Left side column. contains the logo and sidebar -->
<?php require("sidebar.php"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
		
		<li class="active">Add Fee</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<a href="view-fee-type.php"> <button class="btn btn-primary">View Fee type</button></a><br><br>
	<!-- general form elements -->
    <div class="row">
        <div class="col-lg-6">
			<div class="box box-primary" style="padding:20px">
				<div class="box-header with-border">
					<h3 class="box-title">Add Fee</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form  role="form" method="post" enctype="multipart/form-data" id="add_fee_form">
					<div class="row" style="padding:10px">
				
					
						
							<?php if(isset($error_msg)){?>
			<div class="alert alert-warning">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Warning!</strong> <?php echo $error_msg; ?>
</div>
			
			<?php }else if(isset($success_msg)){
			?>
			
			<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $success_msg; ?>
</div>
			  
			<?php } ?>
							
							
                            <div class="form-group">
								<label>Class</label>
								<select class="form-control" name="class_id" id="class_id" required>
								<option value="">Select Class</option>
<?php $sql_class=mysqli_query($con,"select * from class"); 
if(mysqli_num_rows($sql_class)>0){
	while($row_class=mysqli_fetch_assoc($sql_class)){
		?><option value="<?php echo $row_class['class_id']; ?>"><?php echo $row_class['class']; ?></option><?php
	}
}

?>
</select>								
							</div>
							<div class="form-group">
							<label>Session</label>
							<div class="row">
							<div class="col-sm-6">
								<select class="form-control" name="session_from_year" id="session_from_year" required>
								<option value="">From</option>
								<?php for($i=2000;$i<2050;$i++){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
								</select>

							</div>
							<div class="col-sm-6">			
							<select class="form-control" name="session_to_year"  id="session_to_year" required>
							<option value="">To</option>
								<?php for($i=2000;$i<2050;$i++){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
								</select>
							</div>
							</div>
								
							</div>
							<div class="form-group">
								<label>Amount (Fee per year)</label>
								<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" onkeyup="document.getElementById('fee_per_month1').value=this.value/12;document.getElementById('fee_per_month2').value=this.value/12;" autocomplete="off" required>
							</div>
							<div class="form-group">
								<label>Fee Per month</label>
								<input type="text" class="form-control fee_per_month" id="fee_per_month1"disabled>
								<input type="hidden" class="form-control fee_per_month" name="fee_per_month" id="fee_per_month2"placeholder="Fee Per Month" required>
							</div>
							<div class="form-group">
								<label>Fine Per Day</label>
								<input type="text" class="form-control" id="fine_per_day" name="fine_per_day" placeholder="Fine Per day" required>
							</div>
							<div class="form-group">
								<label>Last date of Fee submission without fine</label>
								<select class="form-control" name="submission_last_date" id="submission_last_date">
								<option>Select date</option>
								<?php for($i=1;$i<32;$i++){ ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?>
								<option></option>
								
								</select>
								</div>
							<div class="form-group">
								<label for="note" >Note</label>
								<textarea class="form-control" name="note" id="note"> </textarea>
							</div>
							<div class="form-group">
								<input type="submit" name="add_fee" value="Add" class="btn btn-primary" >
							</div>
						
					</div>
				</form>
          </div>
		</div>
	</div>
    <!-- /.box -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Trigger the modal with a button -->


  <footer class="main-footer">
    <div class="pull-right hidden-xs">
     
    </div>
    <strong><?php echo $school_name; ?>.</strong>
  </footer>

 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
 <style>
.error {
    color:#FF0000;
}
.my-error-class {
    color:#FF0000;  /* red */
}
.my-valid-class {
    color:#00CC00; /* green */
}
</style>
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
 <script src="js/jquery.validate.min.js"></script>
	<script>
	$("#add_fee_form").submit(function(e) {
    e.preventDefault();
});
	$(document).ready(function() {
		$("#add_fee_form").validate({
			 errorClass: "my-error-class",
   validClass: "my-valid-class",
  rules:{
 
  amount:{
      required:true,
  number: true
  },
 fine_per_day:{
      required:true,

  number: true
  },

  },
 submitHandler: function(form) {
          review_addfee(document.getElementById('class_id').value,document.getElementById('session_from_year').value,document.getElementById('session_to_year').value,document.getElementById('amount').value,document.getElementById('fee_per_month2').value,document.getElementById('fine_per_day').value,document.getElementById('submission_last_date').value,document.getElementById('note').value)
        }
  
  });
	});
	</script>
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="js/my.js"></script>
<script src="js/account.js"></script>
<link type="text/css" rel="stylesheet" href="student/jquery-te-1.4.0.css">

<script type="text/javascript" src="student/jquery-te-1.4.0.min.js" charset="utf-8"></script>


<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
<style>
.jqte_tool_label{
	min-height:20px;
}
</style>
</body>
</html>
