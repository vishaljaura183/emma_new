<?php
ob_start();
include_once('header.php');
include('process/add_officer.php');

?>
<style type="text/css">
			body { background: url(img/bg-login.jpg) !important; }
			#content{padding: 28px 28px 0px 28px!important;}
			.error_login{background:yellow; color:red; border: 1px;text-align: center;}
		</style>
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">Add Dispatcher</a>
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
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Add Dispatcher</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
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
								<input type="text" class="span6 typeahead" id="typeahead"  name="name" value="" data-provide="typeahead" data-items="4" >
								
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Username</label>
							  <div class="controls">
								<input type="text" required class="span6 typeahead" id="date01" name="username" value="">
								<input type="hidden" class="span6 typeahead" id="userid" name="userid" value="">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Email</label>
							  <div class="controls">
								<input type="email" required class="span6 typeahead" id="date01" name="email"  value="">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Password</label>
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
							
							  <button type="submit" name="submit" class="btn btn-primary">Save</button>
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