 <?php
/*************************************************************
 * Skapad den 17 dec 2008
 * Senaste uppdatering den 17 dec 2008
 * 
 * En f�rsta sida efter inlogg
 * 
 * Skapad av Andreas Sehr
**************************************************************/

function show_content() {
    $sitedata = new Sitedata(0);
    echo $sitedata->maintext;
}
?>
