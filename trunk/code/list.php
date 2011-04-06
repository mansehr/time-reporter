<?php
/*************************************************************
 * Created on 17 dec 2008
 * Updated on 04 apr 2011
 * 
 * Listar alla companies
 * 
 * Created by Mattias Hägglund
 * Updated by Andreas Sehr 22-jan 2009
 *              Added searchfunction and add button
 * Updated by David He 02-feb 2009
 * Updated by Andreas Sehr 22-feb 2009
 * 		Merged the user and company listapages to one
**************************************************************/

function show_content(){
	if(isset($_GET['type'])) {
		$type = $_GET['type'];
	} else {
		$type = 'user';
	}
	switch($type) {
		case 'user': $sing = 'user'; $plur = 'users'; break;
		case 'comp': $sing = 'company'; $plur = 'companies'; break;
	}


?>
<script language="JavaScript" type="text/JavaScript">
	document.onLoad = request('<?php echo $type; ?>', 'all');
</script>

<div class="block" align="left">
<h1>Search</h1>
<?php echo ucfirst($sing); ?>name: <input type="text" name="name" onkeyup="request('<?php echo $type; ?>', this.value);"  size="50"/>
&nbsp;&nbsp;<img src="img/info_icon.png" width="25px" height="25px" onmouseout="javascript:getById('info').style.display = 'none';"
	 onmouseover="javascript:getById('info').style.display = 'block';"/>
<div class="float_block mini_text" style=" width: 250px" id="info">
<h4>Info</h4>
<ul>
<li><b>all</b> shows all <?php echo $plur; ?></li>
<li><b>new</b> shows a form to add a new <?php echo $sing; ?></li>
</ul>
</div>
<br />
<div id="result_table">
</div>
</div>	

<?php
}
?>