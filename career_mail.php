<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = $_POST["name"];
    $email      = $_POST["email"];
    $phone      = $_POST["phone"];
    $position   = $_POST["position"];
    $link       = $_POST["link"];
    $message    = $_POST["message"];
    
    // File upload
    

    $uploadedFile = $_FILES["cv_file"]["tmp_name"];
    $filename = $_FILES["cv_file"]["name"];
    $fileType = $_FILES["cv_file"]["type"];
    
    $subject = "Job Application";
    
    $recipient_email = "info@qelabs.in";

    $customer_msg = "<html lang='en'> <head> <meta charset='utf-8'> <title></title> </head> <body>
        <table style='border-color:rgb(102,102,102)' cellpadding='10' width='60%' margin-left=50px'><tbody>
            <tbody>
               <tr style='background-color:rgb(57,62,64);color:white;font-size:14.0px'>
                  <td colspan='2'>Job Application Form<br></td>
               </tr>
               <tr>
                  <td><b>Name </b></td>
                  <td>".$name."</td>
               </tr>
               <tr>
                  <td><b>Email ID</b></td>
                  <td><a href='mailto:".$email."' target='_blank'>".$email."</a></td>
               </tr>
               <tr>
                  <td><b>Phone</b></td>
                  <td>".$phone."</td>
               </tr>
               <tr>
                  <td><b>Position</b></td>
                  <td>".$position."</td>
               </tr>
               <tr>
                  <td><b>Portfolio Link</b></td>
                  <td>".$link."</td>
               </tr>
               <tr>
                  <td><b>Message</b></td>
                  <td>".$message."</td>
               </tr>
            </tbody>
        </table>
        <br>Kindly do the needful.<br><br>Best regards,<br>Q E Labs Web Team</body> </html>";
         
    
        
        // MIME boundary
        $boundary = md5(time());
        
        // Headers
        $headers = "From: Q_E_Labs\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n\r\n";
        
        // Message body
        $email_message = "--" . $boundary . "\r\n";
        $email_message .= "Content-Type: text/html; charset='UTF-8'\r\n";
        $email_message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $email_message .= chunk_split(base64_encode($customer_msg)) . "\r\n";
        
        // Attachment
        if (!empty($uploadedFile)) {

            $fileContent = file_get_contents($uploadedFile);
            $email_message .= "--" . $boundary . "\r\n";
            $email_message .= "Content-Type: $fileType; name=\"" . $filename . "\"\r\n";
            $email_message .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n";
            $email_message .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $email_message .= chunk_split(base64_encode($fileContent)) . "\r\n";
        }

        
        if (mail($recipient_email, $subject, $email_message, $headers)) {
            
            
        $headers1 = "From: Q_E_Labs\r\n";
        $headers1 .= "MIME-Version: 1.0\r\n";
        $headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $headers1 .= "Content-Transfer-Encoding: base64\r\n\r\n";
            
            $admin_msg = '<html><head>
            <style>  
            a{
            color:#333;
            text-decoration: none;
            }
            p{
            font-family: helvetica; 
            }
            @media only screen and (max-width: 600px) {
            table td {
            /* display: flex; */
            display: block;
            width: 100%;
            /* flex-direction: column; */
            }
            }
            </style>
         </head>
         <body data-new-gr-c-s-check-loaded="14.1078.0" data-gr-ext-installed="">
         <table cellpadding="10" cellspacing="0" style="padding: 10px; max-width: 700px; margin-left: 75px; text-align:left;font-size: 14px;">
            <tbody>
            <tr>
            <div class="logo" style="text-align:center;background: #f1f1f1;
                  padding: 16px; "><img style="width:35%" src="//qelabs.in/img/logo.png" alt=""></div>
                <div style="margin:1px 0;
                  padding:25px;background: linear-gradient(0deg, rgba(118,118,118) 55%, rgba(241,241,241) 100%);text-shadow: 1px 1px #333; font-family:Helvetica; background-color:#284ab1;">
                  <h1 style="font-size:19px; font-family:Helvetica; color: #fff;">Dear <span>'.$name.',</span></h1>
                  <p style="font-size:17px; line-height:23px; margin-bottom: 0;
                     color: #fff;">
                     Thank you for reaching out to us.We have received your Job Application with your CV.
                  </p>
                  <p style="font-size:17px; color:#fff; line-height:23px;">
                  We will be reviewing the information you provided.Your CV will be taken into careful consideration as part of our selection process.<br><br>We will be in touch with updates regarding the status of your application as soon as we have completed our initial assessment.
                  </p>
                  <p style="font-size:17px; color:#fff; line-height:23px;">
                    Best regards,<br>
                     Q E Labs Web Team.
                  </p>
                </div>
                
                </div>
              </td>
            </tr>
         </tbody></table>
        </body><grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration></html>';
            

             mail($email, $subject, $admin_msg, $headers1);

            header("Location: career.html?status=success");
        }else {
            header("Location: career.html?status=error");
        }
}

?>