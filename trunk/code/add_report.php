<?php
/* * ***********************************************************
 * Created on 19 dec 2008
 * Updated on 19 dec 2008
 * 
 * Report adding form
 * 
 * Created by David He
 * ************************************************************ */

function show_content() {
    $db = new DbHandler();
    if (isset($_REQUEST['regnumber'])) {
        global $auth;
        $company = new Company($_REQUEST['regnumber']);
        if (isset($_REQUEST['duration'])) {
            $_REQUEST['update'] = "";
            $_REQUEST['pnr'] = $auth->getAuthData('pnr');
            $obj = new Report($_REQUEST);
            if (save_object($obj)) { // Jump back to the company page if we have saved data
                echo '<p>' . $company->link .
                '</p><p>' . $company->new_report_link .
                '</p><p><a href="">Back to home</a></p>';
            }
        } else {
            add_rep($company);
        }
    } else { // No regnumber in request error handling
        echo "Error: No company registration number in request!";
    }
}

function add_rep($company) {
    $_SESSION['regnumber'] = $company->regnumber;
    $report = new Report($_REQUEST);
?>
    <script type="text/javascript" src="./js/form_validate.js"></script>
    <script type="text/javascript" src="./js/form_validate.js">

        window.onbeforeunload = function() {
        if(!valid)
        return 'Close the page without saving the report?';
        }

    </script>
    <h2>New report - <?php echo $company->name; ?></h2>
    <form method="post" action="" onSubmit="return validate(this);">
        <div id="form">
            <table>
                <tr><td>
                        <table>
                        <?php
                        table_code("Date", "date", $report);
                        table_code("Title", "title", $report);
                        ?>
                    </table></td>
                <td align="center"><input type="button" id="clock_btn" onclick="javascript:toggleClock()" value="Start timer" />
                </td>
                <td align="right"><table>
                        <?php
                        table_code("Start time", "starttime", $report, 'onChange="update_duration();"');
                        table_code("End time", "endtime", $report, 'onChange="update_duration();"');

                        $totTime = (strtotime($report->endtime) - strtotime($report->starttime));
                        ?>
                        <tr><td>Total time: </td><td><input type="text" id="totalTime" value="<?php echo round($totTime / 3600, 2); ?>" readonly="readonly" style="border:none; color:#000000; background: none; font-weight: bold;"/>
                                <input type="text" name="duration" id="duration" value="<?php echo $totTime; ?>"/></td></tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">Description of work:<br/>
                    <textarea name="text" cols="10" rows="20" style="width: 99%"><?php echo $report->text; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="right" colspan="3"><input type="submit" value="Save!" />
                    <input type="hidden" name="invoicenr" value="0">
                    <input type="hidden" name="id" value="0">
                </td>
            </tr>
        </table>
    </div>
</form>
<?php
                    }
?>