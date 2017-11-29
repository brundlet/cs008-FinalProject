<?php
include 'top.php';
//if($debug){
    $thisURL=$domain.$phpSelf;
    $fullName="";
    $password="";
    $address="";
    $social="";
    $zip="";
    $email= '';
    $emailERROR=false;
    $fullNameERROR=false;
    $passwordERROR=false;
    $addressERROR=false;
    $socialERROR=false;
    $zipERROR=false;
    $errorMsg=array();
    $dataRecord=array();
    $mailed=false;
    $gender="hi";
    $genderERROR = false;
    $birth="";
    $married = false;    // checked
    $military = false; // not checked
    $student=false;
    $activityERROR = false;
    $totalChecked = 0;
$birthdayError = false;
//Sanitize: SECTION 2b.
//$mountain = htmlentities($_POST["1stMountain"],ENT_QUOTES,"UTF-8");
    if(isset($_POST["btnSubmit"])){
        if (!securityCheck($thisURL)){
            $msg='<p>Sorry you cannot access this page. ';
            $msg.='Security breach detected and reported.</p>';
            die($msg);
        }
        $fullName=  htmlentities($_POST["txtFullName"], ENT_QUOTES,"UTF-8");
        $dataRecord[]=$fullName;
        $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
        $dataRecord[]=$email;
        
        //error checking
        if($fullName==""){
            $errorMsg[]='Please enter your full name';
            $fullNameERROR=true;
        }elseif(!verifyAlpha($fullName)){
        $errorMsg[]="Your full name is invalid";
        $fullNameERROR=true;
        }
        
         if($email == ""){
            $errorMsg[]='Please enter your email address';
            $emailERROR=true;
        }
        elseif(!verifyEmail($email)){
            $errorMsg[]='Your email address is incorrect.';
            $emailERROR=true;
        }
        
        $password=  htmlentities($_POST["txtPassword"], ENT_QUOTES,"UTF-8");
        $dataRecord[]=$password;
        if($password==""){
            $errorMsg[]='Please enter your password';
            $passwordERROR=true;
        }
        
        $address=  htmlentities($_POST["txtAddress"], ENT_QUOTES,"UTF-8");
        $dataRecord[]=$address;
        if($address==""){
            $errorMsg[]='Please enter your address';
            $addressERROR=true;
        }
        
        $zip=  htmlentities($_POST["txtZip"], ENT_QUOTES,"UTF-8");
        $dataRecord[]=$zip;
        if($zip==""){
            $errorMsg[]='Please enter your zip code';
            $zipERROR=true;
        }elseif(!verifyNum($zip)){
            $errorMsg[]='Please enter a valid zip code';
            $zipERROR = true;
        }
        
        $social=  htmlentities($_POST["txtSocial"], ENT_QUOTES,"UTF-8");
        $dataRecord[]=$social;
        if($social==""){
            $errorMsg[]='Please enter your social security number';
            $socialERROR=true;
        }elseif(!verifyNum($social)){
            $errorMsg[]='please enter a valid social security number';
            $socialERROR=true;
        }
       
        
    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender;
    if($gender != "Male" AND $gender != "Female" AND $gender!="Other"){
        $errorMsg[] = "Please choose a gender";
        $genderERROR = true;
    }
     if (isset($_POST["txtMarried"])) {
        $married= true;
        $totalChecked++;
    } else {
        $married= false;
    }
    $dataRecord[] = $maried; 
    if (isset($_POST["txtMilitary"])) {
        $military= true;
        $totalChecked++;
    } else {
        $military = false;
    }
    $dataRecord[] = $military;
    if (isset($_POST["txtStudent"])) {
        $student= true;
        $totalChecked++;
    } else {
        $student = false;
    }
    $dataRecord[] = $student;
    // Error check: SECTION 2c.
    // may not need to check for any
    if($totalChecked < 1){
        $errorMsg[] = "Please choose at least one trait";
        $activityERROR = true;
    }
   $birth=  htmlentities($_POST["txtBirth"], ENT_QUOTES,"UTF-8");
        $dataRecord[]=$birth;
        if($birth==""){
            $errorMsg[]='Please enter your birthday';
            $birthdayERROR=true;
        }
   
    
   
//Error check: SECTION 2c.
// none if you set a default value. here i am just checking if they picked
// one. You could check to see if mountain is == to one of the ones you
// have, similar to radio buttons

        if (!$errorMsg){
                print '<p>Form is valid</p>';
                $myFileName='data/registration';
                $fileExt='.csv';
                $filename=$myFileName.$fileExt;
                //if($debug){
                    print PHP_EOL.'<p>filename is '. $filename;
                //}
                $file=fopen($filename, 'a');
                print'<p>writing to file</p>';
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
                $from='PleaseHaveMyIdentity.com <customer.service@PleaseHaveMyIdentity.com>';
                $subject='Got Your Identity!';
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
        print '<p class="form-heading">Your information will greatly help us with our research.</p>';
    
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
              <label class="required text-field" for="txtFullName">Full Name</label>
              <input autofocus
                     <?php if ($fullNameERROR) print 'class="mistake"';?>
                     id="txtFullName"
                     maxlength="45"
                     name="txtFullName"
                     onfocus="this.select()"
                     placeholder="Enter your full name"
                     tabindex="100"
                     type="text"
                     value="<?php print $fullName; ?>"
                     >
          </p>
          
          <p> 
              <label class="required text-field" for="txtEmail">Email</label>
                  <input
                      <?php if($emailERROR) print 'class="mistake"';?>
                      id="txtEmail"
                      maxlength="45"
                      name="txtEmail"
                      onfocus="this.select()"
                      placeholder="Enter a valid email"
                      tabindex="100"
                      type="text"
                      value="<?php print $email; ?>"
              >
                  
          </p>
          <p>
              <label class="required text-field" for="txtPassword">Password</label>
              <input 
                     <?php if ($passwordERROR) print 'class="mistake"';?>
                     id="txtPassword"
                     maxlength="45"
                     name="txtPassword"
                     onfocus="this.select()"
                     placeholder="Enter your password"
                     tabindex="100"
                     type="text"
                     value="<?php print $password; ?>"
                     >
          </p>
          <p>
              <label class="required text-field" for="txtAddress">Home Address</label>
              <input 
                     <?php if ($addressERROR) print 'class="mistake"';?>
                     id="txtAddress"
                     maxlength="45"
                     name="txtAddress"
                     onfocus="this.select()"
                     placeholder="Enter your Address"
                     tabindex="100"
                     type="text"
                     value="<?php print $address; ?>"
                     >
          </p>
          <p>
              <label class="required text-field" for="txtZip">Zip Code</label>
              <input 
                     <?php if ($zipERROR) print 'class="mistake"';?>
                     id="txtZip"
                     maxlength="5"
                     name="txtZip"
                     onfocus="this.select()"
                     placeholder="xxxxx"
                     tabindex="100"
                     type="text"
                     value="<?php print $zip; ?>"
                     >
          </p>
          <p>
              <label class="required text-field" for="txtSocial">Social Security Number</label>
              <input 
                     <?php if ($socialERROR) print 'class="mistake"';?>
                     id="txtSocial"
                     maxlength="9"
                     name="txtSocial"
                     onfocus="this.select()"
                     placeholder="xxx-xx-xxxx"
                     tabindex="100"
                     type="text"
                     value="<?php print $social; ?>"
                     >
          </p>
          
        
    <fieldset class="radio <?php if ($genderERROR) print ' mistake'; ?>">
        <legend>What is your gender?</legend>
        <p>
            <label class="radio-field">
                <input type="radio" 
                       
                       id="radGenderMale" 
                       name="radGender" 
                       value="Male" 
                       tabindex="572"
                       <?php if ($gender == "Male") echo ' checked="checked" '; ?>>
            Male</label>
        </p>

        <p>    
            <label class="radio-field">
                <input type="radio" 
                       id="radGenderFemale" 
                       name="radGender" 
                       value="Female" 
                       tabindex="582"
                       <?php if ($gender == "Female") echo ' checked="checked" '; ?>>
            Female</label>
        </p>
        <p>    
            <label class="radio-field">
                <input type="radio" 
                       id="radGenderOther" 
                       name="radGender" 
                       value="Other" 
                       tabindex="582"
                       <?php if ($gender == "Other") echo ' checked="checked" '; ?>>
            Other</label>
        </p>
    </fieldset>

    <fieldset class="checkbox <?php if ($activityERROR) print ' mistake'; ?>">
        <legend>Are You(choose at least one and check all that apply):</legend>

                    <p>
                        <label class="check-field">
                            <input <?php if ($married) print " checked "; ?>
                                
                                id="txtMarried"
                                name="txtMarried"
                                tabindex="420"
                                type="checkbox"
                                value="Married">Married</label>
                    </p>

                    <p>
                        <label class="check-field">
                            <input <?php if ($military)  print " checked "; ?>
                                id="txtMilitary" 
                                name="txtMilitary" 
                                tabindex="430"
                                type="checkbox"
                                value="Military"> In The Military</label>
                    </p>
                     <p>
                        <label class="check-field">
                            <input <?php if ($student)  print " checked "; ?>
                                id="txtStudent" 
                                name="txtStudent" 
                                tabindex="430"
                                type="checkbox"
                                value="Student"> A Student</label>
                    </p>
    </fieldset>
       
<fieldset  class="birthday <?php if ($birthdayERROR) print ' mistake'; ?>">
    <legend>Birthday</legend>
     <p>
                        <label class="check-field">
                            <input <?php if ($birth) print " checked "; ?>
                                
                                id="txtBirth"
                                name="txtBirth"
                                tabindex="420"
                                type="date"
                                >
                                </label
                                >
    </p>
</fieldset>
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
