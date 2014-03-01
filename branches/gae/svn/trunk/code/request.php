<?php
/*************************************************************
 * Created on 17 dec 2008
 * Updated on 06 apr 2011
 *
 * Ajax request page function
 *
 * Created by Andreas Sehr
**************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//SV" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    </head>
    <body>
        <?php
        require_once("checkuser.php");
        global $auth;
        if (!$auth->checkAuth()) {
            trigger_error("User not logged in.");
            exit();
        }

        switch ($_GET['function']) {
            case 'comp_list': companyList($_GET['name']);
                break;
            case 'user_list': userList($_GET['name']);
                break;
            case 'report': report($_GET['id']);
                break;

            case 'li_save': require_once('./httprequests/li_save.php');
                handle_request();
                break;
            case 'li_delete': require_once('./httprequests/li_delete.php');
                handle_request();
                break;
            case 'li_check': require_once('./httprequests/li_check.php');
                handle_request();
                break;

            default: echo "Unknown function.";
        }

        function companyList($name) {
            $db = new DbHandler();
            $q = "SELECT distinct name,regnumber FROM company ";
            if (isset($name) && $name != 'all') {
                $q .= " WHERE name LIKE " . $db->escapeCharacters("%" . $name . "%");
            }
            $companies = $db->fetch_array($q);
            $odd = true;
            $count_companies = count($companies);
            if ($count_companies > 0) {
                echo '<h3>Companylist</h3>
			<table class="list">';
                foreach ($companies as $comp) {
                    $company = new Company($comp['regnumber']);
                    if ($odd) {
                        $class = "odd";
                    } else {
                        $class = "even";
                    }
                    echo
                    "<tr class='$class' ><td>" .
                    $company->show_link . '</td>
				<td align="right">' . $company->new_report_link . '</td>
				</tr>';
                    $odd = !$odd;
                }
                echo '</table>';
            } else if ($name != 'new') {
                echo '<br /><p>Found no company with name "' . htmlentities($name) . '"</p>';
            }
            if ($name == 'new' || $count_companies == 0) {
                if ($name == 'new') {
                    $name = "";
                }
                echo '
			<form name="add_company" action="?page=add_comp" method="post">
			 <input type="hidden" name="name" value="' . htmlentities($name) . '" />
			 <a href="javascript:get_by_id(\'add_company\').submit();">Create new company.</a>
			 </form>';
            }
        }

        function userList($name) {
            $db = new DbHandler();
            $q = "SELECT distinct login, pnr FROM user ";
            if (isset($name) && $name != 'all') {
                $q .= " WHERE name LIKE " . $db->escapeCharacters("%" . $name . "%");
            }
            $users = $db->fetch_array($q);
            $odd = true;
            $count_user = count($users);
            if ($count_user > 0) {
                echo '<h3>Userlist</h3>
			<table class="list">';
                foreach ($users as $use) {
                    $user = new user($use['pnr']);
                    if ($odd) {
                        $class = "odd";
                    } else {
                        $class = "even";
                    }
                    echo
                    "<tr class='$class' ><td>" .
                    "<a href='?page=info_user&pnr=" . $user->pnr . "'>" .
                    htmlentities($user->name) . '</td>
				</tr>';
                    $odd = !$odd;
                }
                echo '</table>';
            } else if ($name != 'new') {
                echo '<br /><p>Found new user with name "' . htmlentities($name) . '"</p>';
            }
            if ($name == 'new' || $count_user == 0) {
                if ($name == 'new') {
                    $name = "";
                }
                echo '<form name="add_user" action="?page=add_user" method="post">
			 <input type="hidden" name="name" value="' . htmlentities($name) . '" />
			 <a href="javascript:get_by_id(\'add_user\').submit();">Create user</a>
			 </form>';
            }
        }

        function report($id) {
            $report = new Report($id);
            echo nl2br(htmlentities($report->text));
        }
        ?>

    </body>
</html>