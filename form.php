<?php
include 'top.php';
//if($debug){
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
    $thisURL=$domain.$phpSelf;
    $email= 'brundlet@uvm.edu';
    $emailERROR=false;
    $errorMsg=array();
    $dataRecord=array();
    $mailed=false;
    if(isset($_POST["btnSubmit"])){
        if (!securityCheck($thisURL)){
            $msg='<p>Sorry you cannot access this page. ';
            $msg.='Security breach detected and reported.</p>';
            die($msg);
        }
    
        $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
        $dataRecord[]=$email;
        
        if($email == ""){
            $errorMsg[]='Please enter your email address';
            $emailERROR=true;
        }
        elseif(!verifyEmail($email)){
            $errorMsg[]='Your email address is incorrect.';
            $emailERROR=true;
        }
        if (!$errorMsg){
                print '<p>Form is valid</p>';
                $myFileName='data/registration';
                $fileExt='.csv';
                $filename=$myFileName.$fileExt;
                if($debug){
                    print PHP_EOL.'<p>filename is '. $filename;
                }
                $file=fopen($filename, 'a');
                fputcsv($file, $dataRecord);
                fclose($file);
                $message='<h2>Your information</h2>';
                foreach($_POST as $htmlName => $value){
                    $message.='<p>';
                    $camelCase=preg_split('/(?=[A-Z])/', substr($htmlName,3));
                    foreach ($camelCase as $oneWord){
                        $message .=$oneWord. " ";
                    }
                    $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8"). '</p>';
                }
                $to=$email;
                $cc='';
                $bcc='';
                $from='Change Da World <customer.service@DaWorld.com>';
                $subject='Changing Earth: ';
                $mailed= sendMail($to,$cc,$bcc,$from,$subject,$message);
        }
    }
?>
<article id="main">
    <?php
     if (isset($_POST["btnSubmit"]) AND empty($errorMsg)){
        print '<h2> Thank you for your info.</p>';
        print '<p>A copy of this data has ';
        if (!$mailed){
            print "NOT ";
        }
        print 'been sent:</p>';
        print '<p>To: '.$email.'</p>';
        print $message;
    }else{
        print '<h2>Register Today</h2>';
        print '<p class="form-heading">Your information will greatly help us with '
        . 'stealing your identity.</p>';
    
        if ($errorMsg){
            print '<div id="errors">'.PHP_EOL;
            print '<h2>Your form has these mistakes:</h2>'.PHP_EOL;
            print '<ol>' .PHP_EOL;
            foreach($errorMsg as $er){
                print '<li>'.$er.'</li>'.PHP_EOL;
            }
            print '</ol>'.PHP_EOL;
            print '</div>'.PHP_EOL;
        }
        ?>

<form action="<?php print $phpSelf; ?>"
      id="frmRegister"
      method="post">
      <fieldset class ="contact">
          <legend>Your Contact Information</legend>
          <p> 
              <label class="required" for="txtEmail">Email</label>
                  <input
                      <?php if($emailERROR) print 'class="mistake"';?>
                      id="txtEmail"
                      maxlength="45"
                      name="txtEmail"
                      onfocus="this.select()"
                      placeholder="Enter a valid email"
                      tabindex="120"
                      type="text"
                      value="<?php print $email; ?>"
              >
                  <br></br>
                  Password <input type="text" name="pass" value="">
                  <br></br>
                  Full Name <input type="text" name="nm" value=" 'John Doe' ">
                  <br></br>
                  Social Security Number <input type="text" name="ssn" value="xxx-xx-xxxx">
                  <br></br> 
                  Credit Card Information <input type="text" name="credit" value="xxxx-xxxx-xxxx-xxxx">
                  <br></br>
                  Birthdate <input type="text" name="birth" value="dd/mm/yyyy">
                  <br></br>
                  Home Address <input type="text" name="address" value="Number Streetname">
                  <br></br>
                  Drivers Licence Number <input type="text" name="drivers" value="">
                  <br></br>
                  
                  
 Gender: <input type="radio" name="gender" value="male"> Male
  <input type="radio" name="gender" value="female"> Female<br>
                    
                  
          </p>
          
     <fieldset class="buttons">  
          <legend></legend>
          <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Register">
    </fieldset>
          </fieldset>
               

</form>
    <?php
    }
    ?>
</article>
<?php include 'footer.php'; ?>
</body>
</html>