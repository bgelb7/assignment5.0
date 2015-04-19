    

<?php 
    include "top2.php";
   
  
   
   
      
 
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.
$debug = false;
if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}
if ($debug)
    print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
$yourURL = $domain . $phpSelf;
// 
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
// 
// Initialize variables one for each form element
// in the order they appear on the form


$comments="";

$firstName = "";
$email = "benjamin.gelb@uvm.edu";

// 
// 
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$emailERROR = false;
//
//
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
// 
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// array used to hold form values that will be written to a CSV file
$dataRecord = array();
$mailed = false; // have we mailed the information to the user?
// 
// 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
if (isset($_POST["btnSubmit"])) {
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2a Security
    if (!securityCheck(true)) {


        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }
// 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2b Sanitize (clean) data 
// remove any potential JavaScript or html code from users input on the
// form. Note it is best to follow the same order as declared in section 1c.


   

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
$dataRecord[] = $comments;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
$dataRecord[] = $email;
    $mountain = htmlentities($_POST["lstMountains"],ENT_QUOTES,"UTF-8");
$dataRecord[] = $mountain;
    
    

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2c Validation
//Validation section. Check each value for possible errors, empty or
// not what we expect. You will need an IF block for each element you will
// check (see above section 1c and 1d). The if blocks should also be in the
// order that the elements appear on your form so that the error messages
// will be in the order they appear. errorMsg will be displayed on the form
// see section 3b. The error flag ($emailERROR) will be used in section 3c.

    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }

// Process for when the form passes validation (the errorMsg array is empty)
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2d Process Form - Passed Validation
// 
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";
        
        

// end form is valid
// 
//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2e Save Data
//This block saves the data to a CSV file.
        $fileExt = ".csv";


        $myFileName = "data/contactus";


        $filename = $myFileName . $fileExt;



        if ($debug)
            print "\n\n<p>filename is " . $filename;



// now we just open the file for append
        $file = fopen($filename, 'a');



// write the forms informations
        fputcsv($file, $dataRecord);


// close the file
        fclose($file);
//
// 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2f Create message
//
        $message = '<h2>Your information.</h2>';
        foreach ($_POST as $key => $value) {
            if ($key != "btnSubmit") {
                $message .= "<p>";
                $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
                foreach ($camelCase as $one) {
                    $message .= $one . " ";
                }
                $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }
        }

// 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2g Mail to user
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "benjamin.gelb@uvm.edu";
// subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Feedback Form: " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid
} // ends if form was submitted.
// 
//#############################################################################
//
// SECTION 3 Display Form
//
?>

<article id="main">

    <?php
//####################################
//
// SECTION 3a.
//
// // If its the first time coming to the form or there are errors we are going
// to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";

        if (!$mailed) {
            print "not ";
        }
        print "been processed</h1>";
        print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        print "<p>Mail Message:</p>";
        print $message;
    } else {
// 
        // 
        // 
        // 
        //####################################
        //
        // SECTION 3b Error Messages
        // display any error messages before we print out the form
        // 


        if ($firstName == "") {
            $errorMsg[] = "Enter Your Feedback";
            $firstNameERROR = true;
        } elseif (!verifyAlphaNum($firstName)) {
            $errorMsg[] = "Your first name appears to have extra character.";
            $firstNameERROR = true;
        }
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }



        //####################################
        //
        // SECTION 3c html Form
        //
         //Display the HTML form. note that the action is to this same page. $phpSelf
        //is defined in top.php
        // NOTE the line://
        //$value = "<?php //print $email; ";
        // this makes the form sticky by displaying either the initial default value (line 35)
        // or the value they typed in (line 84)
        // this line.
        //this prints out a css class so that we can highlight the background etc. to
        //make it stand out that a mistake happened here.
        ?>
   <form action="<?php print $phpSelf; ?>"
              method="post" 
              id="formRef"><!--get puts in url--> <!--wrapper-->
       <fieldset class="wrapper">
                <legend align="center">Contact Us</legend>
                    
                     <fieldset class="contact">
                        <legend align="center">Contact Information</legend>
                        <label for="txtFirstName" class="required">First Name
                            <input type="text" id="txtFirstName" name="txtFirstName"
                                   value="<?php print $firstName; ?>"
                                   tabindex="100" maxlength="45" placeholder="Enter your first name"
                                   <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                           
                            
                        </label>
                        
                     </fieldset>
                
               
                           
                      

      <fieldset class="emailTxt"> <legend align="center"> Email</legend><label for="emailTxt" class="emailTxt">Email Address</label> <input type="text" id="txtEmail" name="txtEmail" value="benjamin.gelb@uvm.edu" tabindex="120" maxlength="100" placeholder="Benjamin.gelb@uvm.edu"<?php if ($emailERROR) print 'class="mistake"'; ?> onfocus="this.select()" autofocus=""/>

    </fieldset> <!-- ends contact -->
                    
                    
                    <fieldset  class="textarea">
                        <legend align="center">Comments</legend>
    <label for="txtComments" class="required">Enter your questions</label>
    <textarea id="txtComments" 
              name="txtComments" 
              tabindex="200"
    <?php if ($emailERROR) print 'class="mistake"'; ?>
              onfocus="this.select()" 
              style="width: 25em; height: 4em;" ><?php print $comments; ?></textarea>
              <!-- NOTE: no blank spaces inside the text area -->

                        </fieldset> <!-- ends wrapper Two -->

                        <fieldset class="buttons">
                            <legend></legend>
                            <input type="submit" id="btnSubmit" name="btnSubmit" value="Enter" tabindex="900" class="button">
                        </fieldset> <!-- ends buttons -->

                    </fieldset> <!-- Ends Wrapper -->
        </form>

        <?php
    } // end body submit
    ?>

</article>

<?php include "footer.php"; ?>

</body>



