<?php
ob_start();
include_once('header.php');
include('process/admin_profile.php');

?>
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="users.php">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">Profile</a>
				</li>
			</ul>
			<?php
					if(isset($_GET['msg']) && $_GET['msg']=='success'){
					echo "<div class='error_login'>Profile Updated Sucessfully</div>";
					}
					elseif(isset($_GET['msg']) && $_GET['msg']=='currpass'){
					echo "<div class='error_login'>Password Not Match!</div>";
					}
					elseif(isset($_GET['msg']) && $_GET['msg']=='pass_success'){
					echo "<div class='error_login'>Password Changed Successfully!!</div>";
					}
					?>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Admin Profile</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" method="POST" action="">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Name </label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" required id="typeahead"  name="name" value="<?php echo $row['name']; ?>" data-provide="typeahead" data-items="4" >
								
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Username</label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" required id="date01" name="username" value="<?php echo $row['username']; ?>">
								<input type="hidden" class="span6 typeahead" id="userid" name="userid" value="<?php echo $userid; ?>">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Email</label>
							  <div class="controls">
								<input type="email" class="span6 typeahead" id="date01" required name="email"  value="<?php echo $row['email']; ?>">
							  </div>
							</div>

							      
						
							<div class="form-actions">
							
							  <button type="submit" class="btn btn-primary">Save changes</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Reset Password</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" method="POST" action="">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Current Password </label>
							  <div class="controls">
								<input type="password" required class="span6 typeahead" id="typeahead" name="curr_pass" data-provide="typeahead" data-items="4">
								<input type="hidden" class="span6 typeahead" id="typeahead" name="change_pass" value='1'>
								
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">New Password</label>
							  <div class="controls">
								<input type="password" required class="span6 typeahead" id="date01" name="new_pass" value="">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Confirm Password</label>
							  <div class="controls">
								<input type="password" required class="span6 typeahead" id="date01" name="conf_pass" value="">
							  </div>
							</div>

							         
						
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save changes</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->
		
	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
<?php ob_end_flush(); ?>
<?php
include('footer.php');
?>