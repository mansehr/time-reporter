<?php
/*************************************************************
 * Created on 18 dec 2008
 * Updated on  4 apr 2011
 * 
 * Company page with information about the company
 * 
 * Created by Mattias Hägglund
**************************************************************/
function show_content(){
	$company = new Company($_REQUEST['id']);
	$contactperson = new ContactPerson($_REQUEST['id']);

	
?>
<div class="block" align="left">
<h1><b><?php echo $company->name; ?></b> information</h1>
<?php echo $company->getInfoTable(); ?>
</div>

<div class="block" align="center">
<?php echo $company->edit_comp_link ?>
</div>

<div class="block" align="left">
<h1>Contactperson(s)</h1>
<div style="float: right"><?php echo $company->new_contact_link; ?></div>
<?php echo $contactperson->getContactPersonTable(); ?> 
</div>

<div class="block" align="left">
<h1>Sold products</h1>
<div style="float: right"><?php echo $company->new_product_link; ?></div>
<?php echo "Products"; ?>
</div>

<div class="block" align="left">
<h1>Reports</h1>
<div style="float: right"><?php echo $company->new_report_link; ?></div>
<?php echo $company->getReportTable(); ?>	
</div>
	
<?php
}
?>