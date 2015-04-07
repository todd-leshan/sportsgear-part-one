<?php

$firstname = $_POST["firstname"];
$lastname  = $_POST["lastname"];
$email     = $_POST["email"];
$question  = $_POST["question"];

if(isset($_POST["phone"]))
{
	$phone = $_POST["phone"];
}
else
{
	$phone = "No phone number left.";
}

$toAddress  = 'todd.leshan@gmail.com';

$subject = 'Someone leave a Message for you!';

$message = "
<html>
<head>
	<title>Someone leave a Message for you!</title>
</head>

<body>
	<p>Specials for persons born in August</p>
	<table>
		<tr>
			<th>Name</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Message</th>
		</tr>
		<tr>
			<td>".$firstname." ".$lastname."</td>
			<td>$phone</td>
			<td>$email</td>
			<td>$question</td>
		</tr>
	</table>
<body>
<html>
";

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: SportGear Contact Board' . "\r\n";

// Mail it
if(mail($toAddress, $subject, $message, $headers))
{
	header("Location:http://localhost/sportsgear");
}
else
{
	echo "Bad!";
}
?>