<?php require_once('header.php'); ?>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	$path = $_FILES['cust_photo']['name'];
    $path_tmp = $_FILES['cust_photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    }

	if($valid == 1) {

		// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_customer'");
		$statement->execute();
		$result = $statement->fetchAll();
		

        unset($_POST['cust_name']);
        foreach($result as $row) {
			$ai_id=$row[10];
		}        

		$final_name = 'customer-'.$ai_id.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

		$statement = $pdo->prepare("INSERT INTO tbl_customer (cust_name,cust_photo,cust_email,cust_country) VALUES (?,?,?,?)");
		$statement->execute(array($final_name,$_POST['cust_photo'],$_POST['cust_name'],$_POST['cust_email']$_POST[' cust_country'],$_POST['cust_address'],$_POST['cust_city'] ,$_POST['cust_state'],$_POST['cust_zip']));
			
		$success_message = 'Slider is added successfully!';
        
       
		unset($_POST['cust_email']);
		unset($_POST['cust_phone']);
		unset($_POST['cust_country']);
        unset($_POST['cust_address']);
		unset($_POST['cust_state']);
		unset($_POST['cust_zip']);
	}
    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Customer</h1>
	</div>
	<div class="content-header-right">
		<a href="slider.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
				<p>
					<?php echo $error_message; ?>
				</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
                    <div class="form-group">
							<label for="" class="col-sm-2 control-label">Full Name <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="heading" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="cust_photo">(Only jpg, jpeg, gif and png are allowed)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Company Name </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_cname" value="<?php if(isset($_POST['cust_cname'])){echo $_POST['cust_cname'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Email </label>
							<div class="col-sm-6">
								<textarea class="form-control" name="cust_email" style="height:140px;"><?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Contact No. </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_phone" value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-6">
							    <input type="text" autocomplete="off" class="form-control" name="cust_country" value="<?php if(isset($_POST['cust_country'])){echo $_POST['cust_country'];} ?>">  
                            </div>
						</div>
                        <div class="form-group">
							<label for="" class="col-sm-2 control-label">Address </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_address" value="<?php if(isset($_POST['cust_address'])){echo $_POST['cust_address'];} ?>">
							</div>
						</div>
                        <div class="form-group">
							<label for="" class="col-sm-2 control-label">City </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_city" value="<?php if(isset($_POST['cust_city'])){echo $_POST['cust_city'];} ?>">
							</div>
						</div>
                        <div class="form-group">
							<label for="" class="col-sm-2 control-label">State </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_state" value="<?php if(isset($_POST['cust_state'])){echo $_POST['cust_state'];} ?>">
							</div>
						</div>
                        <div class="form-group">
							<label for="" class="col-sm-2 control-label">Zip Code </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_zip" value="<?php if(isset($_POST['cust_zip'])){echo $_POST['cust_zip'];} ?>">
							</div>
						</div>
                        <div class="form-group">
							<label for="" class="col-sm-2 control-label">Password </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_password" value="<?php if(isset($_POST['cust_password'])){echo $_POST['cust_password'];} ?>">
							</div>
						</div>
                        <div class="form-group">
							<label for="" class="col-sm-2 control-label">Retype Password </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="cust_state" value="<?php if(isset($_POST['cust_state'])){echo $_POST['cust_state'];} ?>">
							</div>
						</div>




						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>