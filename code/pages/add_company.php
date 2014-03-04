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
    <h2>Form - <?php echo $text; ?> Company</h2>
    <form method="post" onSubmit="return validate(this);">
        <input type="hidden" value="true" name="sent">
        <div id="form">
            <table>
            <?php
                $obj->getEditForm();
            ?>
            <tr>
                <td><a target="_blank" href="http://allabolag.se/?what=<?php // TODO: Save adress in db for dynamic
                echo urlencode($_POST['name']); ?>">Look up company</a>
                </td>
                <td class="right"><input type="submit" value="<?php echo $text; ?>" /></td>
            </tr>
        </table>
    </div>
</form>
<?php
        }
?>