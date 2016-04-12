<?php
include ('header.php');
if($_POST)
{
//ex rint_r($_POST);
}
 
?>
<script type = 'text/javascript'>
$(document).ready(function(){
	
	$('form.dataReset button[name=submit]').click(function(){
		dataReset();
	});
});

function dataReset()
{
	var r = confirm("Please confirm that you want to reset data! This will reset your application for new elections. Old data will be perserved.");
	if (r == true) {
		$('form.dataReset').submit();
	}
}
</script>
<div id="content" class="span10">
	<ul class="breadcrumb">
		<li><i class="icon-home"></i> <a href="poll_venues.php">Home</a> <i
			class="icon-angle-right"></i></li>
		<li><a href="#">Data Back Up and Reset</a></li>
	</ul>
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2>
					<i class="halflings-icon edit"></i>
						<span class="break"></span>
						Data Back Up and Reset</span>
				</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize">
						<i class="halflings-icon chevron-up"></i>
					</a> 
					<a href="#" class="btn-close">
						<i class="halflings-icon remove"></i>
					</a>
				</div>
			</div>
			<div class="box-content">
				<form class="form-horizontal dataReset" method="post" action = "" enctype="multipart/form-data">
					<fieldset>
						
						<div class="control-group" style="">
 							<button type="submit" name='submit' value = 'Reset Data' class="btn btn-primary">Submit</button>
						</div>
						
<!--						<div class="form-actions">-->
<!--							<button type="submit" name='submit' value = 'submit' class="btn btn-primary">Submit</button>-->
<!--							<button type="reset" class="btn">Cancel</button>-->
<!--						</div>-->
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Settings</h3>
	</div>
	<div class="modal-body">
		<p>Here settings can be configured...</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	</div>
</div>
<?php
include('footer.php');
?>