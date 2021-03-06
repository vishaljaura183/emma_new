<?php
ob_start();
include_once('header.php');
include('process/add_officer.php');

?>
<style>
label.error {
    color: red;
    float: none !important;
    line-height: 16px;
    margin-bottom: 0;
    margin-top: 2px;
}
</style>
<style type="text/css">
			body { background: url(img/bg-login.jpg) !important; }
			#content{padding: 28px 28px 0px 28px!important;}
			.error_login{background:yellow; color:red; border: 1px;text-align: center;}
</style>

<script type="text/javascript">
$(document).ready(function(){
	//Validations----------------
	validator = $("#to_be_validated2").validate({
		rules: {
			name:{
				required : true,
				maxlength: 100
			},
			email:{
				required : true,
				email:true,
				remote: "ajax_call_functions.php?action=check_disp_email_uniquenes"
			},
			username:{
				required : true,
				remote: "ajax_call_functions.php?action=check_disp_username_uniqueness"
			},
			new_pass:{
				required: true,
				minlength: 8,
				maxlength: 20,
				elec_app_password: true
			},
			conf_pass:{
				required: true,
				minlength: 8,
				maxlength: 20,
				equalTo: "#password2"
			}
		},
		messages: {
			username:{
				remote: "This username is already taken."
			},
			email:{
				remote: "This email ID is already taken."
			}
		},
		submitHandler: function(form) {
			$("#to_be_validated2").submit();
		}
	});
	
	/*
     * This addMethod can be used for password.
     * Password must contain at least one numeric and one alphabetic character.
     * 
     * @author jsingh7
     */
    $.validator.addMethod("elec_app_password", function (value, element) {
        return this.optional(element) || (value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/));
    },
        'Password must contain minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character.');
	
});
function validate_form(){
//alert('ddd');
if($("#to_be_validated2").valid()){
$("#to_be_validated2").submit();
}
}

</script>

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
						<form class="form-horizontal" action="" id="to_be_validated" method="POST" >
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Name </label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" id="typeahead"  required name="name" value="" data-provide="typeahead" data-items="4" >
								
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Username</label>
							  <div class="controls">
								<input type="text"  class="span6 typeahead" id="" name="username" value="" required>
								<input type="hidden" class="span6 typeahead" id="userid" name="userid" value="">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Email</label>
							  <div class="controls">
								<input type="email"  class="span6 typeahead" id="" name="email"  required value="">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Password</label>
							  <div class="controls">
								<input type="password"  class="span6 typeahead" id="password2" name="new_pass" value="" required minlength="8">
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date01">Confirm Password</label>
							  <div class="controls">
								<input type="password"  class="span6 typeahead" id="" name="conf_pass" value="">
							  </div>
							</div>

							      
						
							<div class="form-actions">
							
							  <button type="submit" name="submit" class="btn btn-primary">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>

					</div>
						</form>   
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