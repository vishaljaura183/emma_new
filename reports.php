<?php
include ('inc/common_func.php');
include('header.php');
?>
<style>
label, select, button, input[type="button"], input[type="reset"], input[type="submit"], input[type="radio"], input[type="checkbox"] {
	cursor: auto!important;
	
}
</style>
<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Reports</a></li>
			</ul>
<h2>Election Data Reports [ .csv files]</h2>
<div>
<table>
<tr><td>
	<table>
	<tr>
	<td>
	<div class="report_div">
		<form action="export_ser_tickets.php" method="POST">
		<label class="title_report">Service Tickets</label>

		<label>Select Date</label>
		FROM <input type="input" name="from_date" id="" class="datepicker2" required />
		TO <input type="input" name="to_date" id="" class="datepicker2" required />
		<input type="submit" class="btn btn-primary" id="download_btn" value="Download"/>
		</form>
	</div>
	</td>
	</tr>
	</table>
</td>

</tr>
<tr><td>
	<table>
	<tr>
	<td>
	<div class="report_div">
		<form action="exp_poll_data.php" method="POST">
		<label class="title_report">Poll Sites Data</label>

		<label>Select Date</label>
		FROM <input type="input" name="from_date" id="" class="datepicker2" required />
		TO <input type="input" name="to_date" id="" class="datepicker2" required />
		<input type="submit" class="btn btn-primary" id="download_btn" value="Download"/>
		</form>
	</div>
	</td>
	</tr>
	</table>
</td>

</tr>


</table>
</div>
</div>
<?php
include('footer.php');
?>
<script>
$(document).ready(function(){
	$('.datepicker2').datepicker({ dateFormat: 'yy-mm-dd' });
	
});
</script>