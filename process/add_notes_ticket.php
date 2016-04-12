<?php
require_once('../inc/common_func.php');
//print_r($_REQUEST); die;
if(isset($_REQUEST['ticket_id_notes']) && !empty($_REQUEST['ticket_id_notes'])){
$id = $_REQUEST['ticket_id_notes'];
$technician_id = $_REQUEST['tech_id_notes'];
$add_notes = $_REQUEST['add_notes'];
$author_type = $_REQUEST['author_type'];
$author_name = $_REQUEST['author_name'];

$add_notes_ticket = AddNoteForTicket($id,$add_notes,$author_type,$author_name);
echo $add_notes_ticket;
}
die;
?>