<?php
/*************************************************************
 * Created on 18 dec 2008
 * Updated on 02 feb 2009 av David He
 * 
 * Page with information about the user
 * 
 * Created by Mattias Hägglund
**************************************************************/
function show_content(){
	$user = new User($_REQUEST['pnr']);
?>
<div class="block" align="left">
<h1>Information about <?php echo $user->name; ?></h1>
<?php echo $user->getInfoTable(); ?>
</div>

<div class="block" align="center">
<?php echo $user->edit_user_link() ?>
</div>
<?php
}
?>