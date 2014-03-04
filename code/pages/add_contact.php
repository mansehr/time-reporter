<?php
/*************************************************************
 * Created on 18 feb 2009
 * Updated on 25 feb 2009
 * 
 * Add a contactperson for a company
 * 
 * Created by Mattias Hägglund
 * 2009-02-25 Andreas Sehr - Moved the validate javascript to an extern file
**************************************************************/
//

function show_content(){
	require_once('./js/form_validate.js');

	$db = new DbHandler();	
	
	if(isset($_REQUEST['sent'])) {
                $obj = new ContactPerson($_REQUEST);
                save_object($obj);
		edit_contact($_REQUEST);
	} else if(isset($_REQUEST['name']) && isset($_REQUEST['regnumber'])) {
		$contact = new ContactPerson($_REQUEST['name']);
		
		edit_contact($contact->data);
	} else {
		edit_contact(NULL);
	}

}



function add_contact(){
?>
	<h2>Formulär - Lägg till en ny kontaktperson</h2>
	<form method="post" action="" onSubmit="return validate(this);">
	<input type="hidden" name="regnumber" value="<?php echo $_GET['regnumber']; ?>" />
	<div id="form">
	<table>
<?php
	$reg = $_GET['regnumber'];
	table_code("Name", "name");
//	fill_table_code("Organisationsnummer", "regnr",$reg);
	table_code("Phone", "phone");
	table_code("Cell", "mobile");
	table_code("E-mail", "mail");
?>
	<tr>
		<td></td><td class="right"><input type="submit" value="Save!" /></td>
	</tr>
	</table>
	</div>
	</form>
<?php
}

function edit_contact($obj){
	if($_GET['link'] == 'edit_contact_link') {
		$text = "Change";
	} else {
		$text = "Add";
	}
?>	
	<h2>Fromulär - <?php echo $text; ?> contact</h2>
	<form method="post" onSubmit="return validate(this);">
    <input type="hidden" value="true" name="sent">
	<div id="form">
	<table>
<?php
	table_code("Name", "name", $obj);
	table_code("Phone", "phone", $obj);
	table_code("Cell", "mobile", $obj);
	table_code("E-mail", "mail", $obj);
?>
	<tr>
	<td>
   <?php 
   	if($_GET['link'] == 'edit_user_link') {
		echo '<label><input type="radio" value="true" name="check">Accept changes</label>
				<div id="check_error" class="error_txt"></div><br />';
	} ?>
	</td>
	<td class="right"><input type="submit" value="<?php echo $text; ?>" /></td>
	</tr>
	</table>
	</div>
	</form>
<?php

}
?>