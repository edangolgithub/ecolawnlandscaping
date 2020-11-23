<?
session_start();
require "Config.php";

if(!isset($_POST['method'])):
	$PageTitle="";
	$ContactName="";
    $Phone="";
    $ContactEmail="";
   	$ContactMessage='';
	
 	$Template="htmls/ContactUs.html";
	
	include "htmls/Home.html";
	
	exit;
endif;

if($_POST['method']=="ContactUsOk"):
		if(isset($_POST['btnContact'])):
            $ContactName=$_POST['ContactName'];
            $Phone=$_POST['Phone'];
            $ContactEmail=$_POST['ContactEmail'];
            $ContactMessage=$_POST['ContactMessage'];
            
            
			$IsFormError="No";
			$ErrorMessage='';
			if(strlen(trim($_POST['ContactEmail']))==0):
			$IsFormError="Yes";
			$ErrorMessage.="Please enter your <b>Email</b> Address.<br>";
			else:
				if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $_POST['ContactEmail'])):
				$IsFormError="Yes";
				$ErrorMessage.="Please enter a <b>Valid Email Address</b>. Check email address for proper format or additional spaces, etc.<br>";
				endif;
			endif;
			
			if(strlen(trim($_POST['ContactMessage']))==0):
			$IsFormError="Yes";
			$ErrorMessage.="Please enter <b>Contact Message</b>.<br>";
			endif;
            if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) ):
                // Insert you code for processing the form here
                else:
                   $IsFormError="Yes";
                $ErrorMessage.="Please enter the security code as appears in the serucity image..<br>";
               endif;
		endif;
		
		
		if($IsFormError=="Yes"):
		    $PageTitle="";
			$Template="htmls/ContactUs.html";
		else:
			$MailTo=$SiteDefaultEmail;
			$MailSubject="Contact message submited from $SiteName";
            $MailBody="

Name : $ContactName
Phone: $Phone
Email: $ContactEmail

Message : $ContactMessage



Contact message submited from Eco Friendly Lawn & Landscaping website.
            ";

			if($ContactName!=''):
			$MailFrom="From: $ContactName <$ContactEmail>";
			else:
			$MailFrom="$ContactEmail";
			endif;
			mail($MailTo,$MailSubject,$MailBody,$MailFrom);
			$PageTitle="Thank You!";
			$Message="Thank You! Your contact message has been submited.";
		endif;
		$TopTemplate="htmls/DisplayMessage.html";
		
		include "htmls/Home.html";
endif;





?>