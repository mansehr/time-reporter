<?php
/* * ***********************************************************
 * Created on 17 dec 2008
 * Updated on 25 feb 2009
 * 
 * Add a company form
 * 
 * Created by David He
 * 2009-02-25 Andreas Sehr - Moved the java script to a separate file
 * ************************************************************ */

//
function show_content() {
    if (isset($_REQUEST['sent'])) {
        $obj = new Company($_REQUEST);
        save_object($obj);
        edit_comp();
    } else if (isset($_REQUEST['regnumber'])) {
        $comp = new Company($_REQUEST['regnumber']);
        edit_comp($comp);
    } else {
        edit_comp(NULL);
    }
}

function edit_comp($obj) {
    if ($_GET['link'] == 'edit_comp_link') {
        $text = "Edit";
    } else {
        $text = "Add";
    }
?>
<script type="text/javascript" src="./js/form_validate.js"></script>
    <h2>Formulär - <?php echo $text; ?> Företag</h2>
    <form method="post" onSubmit="return validate(this);">
        <input type="hidden" value="true" name="sent">
        <div id="form">
            <table>
            <?php
            table_code("Company", "name", $obj);
            table_code("Adress", "adress", $obj);
            table_code("Zip code", "zipcode", $obj);
            table_code("City", "city", $obj);
            table_code("Company type", "companytype", $obj);
            table_code("Registration nr", "regnumber", $obj);
            ?>
            <tr>
                <td><a target="_blank" href="http://allabolag.se/?what=<?php echo urlencode($_POST['name']); ?>">Sl&aring; upp f&ouml;retaget</a></td><td class="right"><input type="submit" value="<?php echo $text; ?>" /></td>
            </tr>
        </table>
    </div>
</form>
<?php
        }
?>