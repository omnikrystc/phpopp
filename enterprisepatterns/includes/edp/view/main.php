<?php 
require_once('includes/edp/view/viewhelper.php');
$request = \edp\view\VH::getRequest();
?>
<!DOCTYPE>
<html lang='en'>
    <head>
        <title>EDP! Welcome to the Enterprise Design Patterns</title>
    </head>
    <body>
        <table>
            <tr>
                <td>
<?php
print $request->getFeedbackString('</td></tr><tr><td>');
?>                    
                </td>
            </tr>
        </table>
    </body>
</html>