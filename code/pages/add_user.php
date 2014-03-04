<?php
/*************************************************************
 * Created on 18 dec 2008
 * Updated on 25 feb 2009
 * 
 * Add user forms
 * 
 * Created by David He
 * 2009-02-25 Andreas Sehr - Moved the validate javascript to an extern file
**************************************************************/
//
function show_content(){
	$db = new DbHandler();
	if(isset($_REQUEST['sent'])) {
		save_user($_REQUEST);	
			
		edit_user($_REQUEST);
	} else if(isset($_REQUEST['pnr'])) {
		$user = new User($_REQUEST['pnr']);
		edit_user($user);
	} else {
		edit_user(NULL);
	}
}

function save_user($input) {	
	if($input['link'] == 'edit_user_link') {
		global $auth ;
		$input['pnr'] = $auth->getAuthData('pnr');
	} else {
		$input['password'] = md5($input['password']);
	}
	
	$obj = new User($input);
        save_object($obj);
}

function edit_user($obj) {
	if($_GET['link'] == 'edit_user_link') {
		$text = "Edit";
	} else {
		$text = "Add";
	}
?>
        <script type="text/javascript" src="./js/form_validate.js"></script>
	<h2>Form - <?php echo $text; ?> user</h2>
	<form method="post" onSubmit="return validate(this);">
    <input type="hidden" value="true" name="sent">
	<div id="form">
	<table>
<?php
	if($_GET['link'] != 'edit_user_link') {
		table_code("Login name", "login", $obj);
		table_code("Person id", "pnr", $obj);
		table_code("Password", "password", $obj);
	}	
	table_code("Name", "name", $obj);
	table_code("Adress", "adress", $obj);
	table_code("City", "city", $obj);
	table_code("Zip code", "zipcode", $obj);
	table_code("Phone nr", "phone", $obj);
	table_code("Cell nr", "mobile", $obj);
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