<?php
require_once('../inc/common_func.php');
// print_r($_REQUEST); die;
if(isset($_REQUEST['ticket_id']) && !empty($_REQUEST['ticket_id'])){
$id = $_REQUEST['ticket_id'];
$technician_id = $_REQUEST['tech_id'];
$reason_cancel = $_REQUEST['reason_cancel'];

$cancel_ticket = cancelTicket($id,$reason_cancel,$technician_id);
echo $cancel_ticket;
}
die;
?>