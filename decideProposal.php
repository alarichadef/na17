<?php
include_once("conf.php");
include_once("dataprovider.php");
session_start();

$proposalId = intval($_POST['proposalId']);

if(isset($_POST['labelSubmit']))
{
	$label = htmlspecialchars($_POST['label']);
	insertLabel($_SESSION['login'], $proposalId, $label);
	header("Location:viewProposal.php?proposalId=$proposalId");
}
elseif (isset($_POST['acceptSubmit'])) {
	acceptProposal($proposalId);
	header("Location:createProject.php?proposalId=$proposalId");
}
elseif (isset($_POST['refuseSubmit'])) {
	refuseProposal($proposalId);
	header("Location:viewProposal.php?proposalId=$proposalId");
}

?>


<?php
dpdisconnect();
?>