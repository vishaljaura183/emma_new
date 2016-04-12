<?php
require_once('../inc/common_func.php');
// print_r($_REQUEST); die;
if(isset($_REQUEST['ticket_id_redirect']) && !empty($_REQUEST['ticket_id_redirect'])){
$id = $_REQUEST['ticket_id_redirect'];
$old_technician_id = $_REQUEST['old_tech_id'];
$new_technician_id = $_REQUEST['new_technician_id'];
$reason_cancel = $_REQUEST['redirect_reason'];

$cancel_ticket = redirectTicket($id,$reason_cancel,$old_technician_id, $new_technician_id);

echo $cancel_ticket;
}
die;
?>