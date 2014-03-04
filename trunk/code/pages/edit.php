<?php
/* * ***********************************************************
 * Created on 14 may 2011
 * Updated on 14 may 2011
 *
 * Edit form
 *
 * Created by Andreas Sehr
 * ************************************************************ */

// Function that switches the get array
function show_content() {
    /* edit something? */
    if(isset($_REQUEST['edit_id'])) {
        $input = $_REQUEST['edit_id'];
    } else {
        $input = $_REQUEST;
    }
    /* What to edit? */
    switch($_REQUEST['edit_type']) {
        case 'company': $obj = new Company($input); break;
        case 'user':    $obj = new User($input); break;
        case 'contact': $obj = new ContactPerson($input); break;
        case 'product': $obj = new Product($input); break;
        default: echo "Missing required 'edit_type'"; exit;
    }
    if (isset($_REQUEST['sent'])) {
        save_object($obj);
        edit_form();
    } else {
        edit_form($obj);
    }
}

function edit_form($obj) {
    if (isset($_REQUEST['edit_id'])) {
        $text = "Edit";
    } else {
        $text = "Add";
    }
?>
<script type="text/javascript" src="./js/form_validate.js"></script>
    <h2>Form - <?php echo $text." ". $obj->typeStr; ?></h2>
    <form method="post" onSubmit="return validate(this);">
        <input type="hidden" value="true" name="sent">
        <div id="form">
            <table>
            <?php
                $obj->getEditForm();
            ?>
            <tr>
                <td class="right" colspan="2"><input type="submit" value="<?php echo $text; ?>" /></td>
            </tr>
        </table>
    </div>
</form>
<?php
}
?>