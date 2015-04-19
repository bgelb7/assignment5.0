<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <title> pho hong</title>
   <meta charset="utf-8">
  <meta name="author" content="Benjamin Gelb">
   <meta name="description" content="A website dedicated to making Pho Hong, a local restaurant much more popular">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel="shortcut icon" href="icon.ico"> <!--taken from:  https://pbs.twimg.com/profile_images/130530998/PHo_Icon_2_normal.png    -->

  <link rel="stylesheet" type="text/css" media="all" href="navstyle.css">
  <script src="script.js" ></script>
</head>
        
       
    

        <?php
        $debug = false;
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//
//  $domain = "https://www.uvm.edu" or http://www.uvm.edu;
        $domain = "http://";
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS']) {
                $domain = "https://";
            }
        }
        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
        $domain .= $server;
        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
        $path_parts = pathinfo($phpSelf);
        if ($debug) {
            print "<p>Domain" . $domain;
            print "<p>php Self" . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre>";
        }
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// include all libraries
//
        require_once('lib/security.php');
        if ($path_parts['filename'] == "form2") {
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }
        ?>	


    <!-- ################ body section ######################### -->

    <?php
    print '<body id="' . $path_parts['filename'] . '">';
    include "header.php";
   
    ?>
        



