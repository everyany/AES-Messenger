<?php
session_start();
$cipher = "aes-256-cbc"; 

$encryption_key = "272a0cb2cd6d8b9f75f7d0cd34adaf39cfbc3be1b92bae983a7cf10e93e86c45"; 

$iv = '4c67338026a6d02f';


if (isset($_POST["submit"]))  {
//form variable
$data = $_POST["sender"] . ": " . $_POST["mail"]; 
$email = $_POST["email"];
$encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv); 
//send email
mail($email,"",$encrypted_data);
}


$url = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
$id = "alicefreshavocado@gmail.com";
$pwd = "bingobingo1"; 
?>





<!DOCTYPE html>
<html>
<body>
<style>
div.contents
{
	background-color: CornflowerBlue;
	width: 500px;
	height: 600px;
	position: absolute;
	text-align: center;
	top: 50%;
	left: 75%;
	margin-right: -75%;
	transform: translate(-50%, -50%);
}

div.contents2
{
	background-color: CornflowerBlue;
	width: 500px;
	height: 600px;
	position: absolute;
	text-align: center;
	top: 50%;
	left: 25%;
	margin-right: -25%;
	transform: translate(-50%, -50%);
}

body
{
	background-color: Black;
}

form
{
	position: absolute;
	top: 50%;
	left: 50%;
	margin-right: -50%;
	transform: translate(-50%, -50%);
}

lable, input
{
	display: block;
}

lable
{
	margin-bottom: 50px;
}

button
{
	background-color: Bisque;;
}


</style>
<div class=contents2>
<h1>Decrypted Messages</h1>
<p>
<?php
$imap = imap_open($url, $id, $pwd);
//Searching emails
$emailData = imap_search($imap, '');
        
if (! empty($emailData)) {  
    foreach ($emailData as $msg) {
        $msg = imap_fetchbody($imap, $msg, "1"); 
        $incoming_encrypted_data = $msg;
        $decrypted_data = openssl_decrypt($incoming_encrypted_data, $cipher, $encryption_key, 0, $iv); 
        print($decrypted_data . "<br>"); 
    }    
} 
//Closing the connection
imap_close($imap); 
?>
</p>
</div>

<div class=contents>
<h1>AES Encryption Messenger</h1>
<form action="index.php" method="post">
  <label for="sender">Your Name:</label><br>
  <input type="text" name="sender" required><br>  

  <label for="email">Recipient:</label><br>
  <input type="text" name="email" required><br>  

  <label for="mail">Body:</label><br>
  <input type="text" name="mail" required><br>

  <button type="submit" name="submit">Submit</button>
</form>
</div>
</body>
</html>
