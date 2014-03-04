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
    $tab_items = array(
        "menu1" => array("Skicka faktura", '<h1>MainOrignial</h1>'),
        "menu2" => array("Fakturalista", '<h1>Main 2</h1>'));

    if(!isset($_GET['active_tab']) || !array_key_exists($_GET['active_tab'], $tab_items)) {
        $_GET['active_tab'] = "menu1";
    }
?>

<ul id="tab_menu">
    <?php

    foreach($tab_items as $key => $item) {
        echo '<a href="?page=test&active_tab='.$key.'"><li';
        if($_GET['active_tab'] == $key)
             echo ' id="active_tab" ';
        
        echo ">$item[0]</li></a>";
    }
    ?>
</ul>
<?php
echo $tab_items[$_GET['active_tab']][1];
}
?>