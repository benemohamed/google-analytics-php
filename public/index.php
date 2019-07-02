<?php
require '../vendor/autoload.php';
use benemohamed\analytics\Analytics;
$analytics = new Analytics('UA-101958632-2',null);

$analytics->set_uagt('dsadasdasdasdsadasd') // User agent
                ->set_hit('pageview')   // Set Hit Type
                ->set_ip('9.9.9.9')    // user IP
                ->set_location('CN')   //  Geographical Override
              //  ->set_host('google.com')  // hostname
              //  ->set_path($_GET['title']) // The path portion of the page URL. Should begin with '/'.
                ->set_title($_GET['title']) // The title of the page
                ->set_event_tra('server')
                ->set_event_act('user block')
                ->set_event_lab('test');

$analytics->send();

 ?>

 <!DOCTYPE html>
 <html>
 <head>
     <title>
        <?php
        if (isset($_GET['title'])) {
           echo $_GET['title'];
        } else {
            echo "Add HTTP GET variables [title]";
        }
         ?>


        - MOHAMED

    </title>
 </head>
 <body>
<?php
        if (isset($_GET['title'])) {
           echo 'page title is '.$_GET['title'];
        }
 ?>
 </body>
 </html>
