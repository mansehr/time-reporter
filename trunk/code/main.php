 <?php
/*************************************************************
 * Skapad den 17 dec 2008
 * Senaste uppdatering den 17 dec 2008
 * 
 * En första sida efter inlogg
 * 
 * Skapad av Andreas Sehr
**************************************************************/

function show_content() {
?>
<style type="text/css">
<!--
.style1 {color: #FF9900}
.style2 {color: #00FF00}
.style3 {color: #33FF00}
.style4 {color: #FF0000}
.style5 {color: #33CC00}
-->
</style>

<h2>Main</h2>
<p>V&auml;lkommen till mansehrsrapporteringsystem det som &auml;r kvar att fixa &auml;r:<br />

<h3><- <span class="style4">Se &quot;Att göra&quot; 
länken i menyn</span></h3>
<ul>
  <li> G&ouml;ra denna sida &auml;ndringsbar ifr&aring;n databasen</li>
<li class="style5"> Anv&auml;ndarhantering</li>
  <li class="style2"> Fakturahantering</li>
  <li> <span class="style1">Se &ouml;ver kodduplicering,</span><span class="style2"> ex list sidorna &auml;r v&auml;ldigt lika skulle kunna vara en och samma phpsida</span></li>
  <li class="style2">Visa de 20 f&ouml;rsta i listorna</li>
  <li class="style3">Se &ouml;ver varf&ouml;r rapporter inte visas i IE7 men i firefox</li>
  <li class="style1">F&ouml;rbereda oss f&ouml;r redovisning</li>
  <li class="style5">Hantera kontaktpersoner</li>
  <li class="style3">L&auml;nka startsidan i menyn</li>
 </ul>
  <?php
}
?>
