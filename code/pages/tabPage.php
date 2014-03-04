<?php
/*************************************************************
 * Skapad den 18 feb 2011
 * 
 * A tabable page
 * Needs a loaded 'page_template'-object loaded in the global $page variable
 *
 * Created by Andreas Sehr
**************************************************************/

function show_content() {
    global $page;

    if(!isset($_GET['active_tab']) || !array_key_exists($_GET['active_tab'], $page->menu())) {
        $_GET['active_tab'] = $page->default_page();
    }
?>

<ul id="tab_menu">
    <?php

    foreach($page->menu() as $key => $title) {
        echo '<a href="?page='.$_GET['page'].'&active_tab='.$key.'"><li';
        if($_GET['active_tab'] == $key)
             echo ' id="active_tab" ';
        
        echo ">$title</li></a>";
    }
    ?>
</ul>
<?php
    echo $page->get_tab($_GET['active_tab']);
}