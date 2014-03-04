<?php
session_start();
ob_start();
require_once('checkuser.php');
global $title;
$initFail = ob_get_clean();

if(isset($_GET['id'])) {
    setcookie('id', $_GET['id']);
}/* else if(isset($_COOKIE['id'])) {
    $_GET['id'] = $_COOKIE['id'];
}*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//SV" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" media="all" href="css_main.css" />
        <script type="text/javascript" src="./js/ajax.js"></script>
        <?php
// Auto include javascriptfiles on the pages
        if (isset($_GET['page'])) {
            $file = "./js/" . $_GET['page'] . ".js";
            if (file_exists($file)) {
                echo '<script type="text/javascript" src="' . $file . '" ></script>';
            }
        }
        ?>
    </head>

    <body>
        <div id="ajax_error_text">
            &nbsp;
        </div>
        <div id="top_bar">
<?php echo $title; ?>
        </div>

<?php
        echo $initFail;
        global $user;
        // Confirm authorization:
        if ($user) {
            if (isset($_GET['page']) && $_GET['page'] == "logout") {
                // Log user out
                $user->logout();
                echo "<center>You have been logged out!<br />\n";
                echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?page=login\">Login</a><br /></center>\n";
            } else { // Show page
                echo '<div id="navigation" >';
                // Draw menu
?>
                <div class="menu"><ul>
                        <li class="title">Meny</li>
                        <li><a href="./?page=main">Home</a></li><br />
                        <li><a href="./?page=list&type=comp">Companies</a></li><br />
                        <li><a href="./?page=list&type=user">Users</a></li><br />
<?php
                if ($user->isAdmin()) {
?>
              			<!-- Admin -->
                    <li class="title">Administration</li>
                    <li><a href="./?page=invoice">Invoices</a></li>
<?php
                }
?>
                <br />
                <li><a href="./?page=logout">Logout</a></li>
            </ul></div> 
            <!-- Content -->
            <div id="content">
<?php
                if (isset($_GET['page'])) {
                    switch ($_GET['page']) {
                        case 'info_comp': 
                            $file = 'tabPage';
                            $page = new page_company();
                            break;
                        case 'add_comp': $file = 'add_company';
                            break; 
                        case 'add_rep': $file = 'add_report';
                            break;
                        case 'invoice':
                            $file = 'tabPage';
                            $page = new page_invoice();
                            break;
                        case 'add_user':        
                        case 'info_user': 
                        case 'list': 
                        case 'main': 
                        case 'edit':
                        case 'klick': 
                        case 'add_contact':  
                            $file = $_GET['page'];
                            break;
                        default: /* trigger_error("Wrong pagerequest".$_GET['page']); */$file = 'main';
                            break;
                    }
                } else {
                    $file = "main";  // Default main
                }
                // Load file and show it to the user
                require_once("./pages/$file.php");
                show_content();           
            }
        } else { // Unauthorized.
            echo "<center>You have to login to access the page.</center>";
        }
?>
       </div>
    </body>
</html>
