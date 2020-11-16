<?php
if (isset($_POST['Email'])) {

    $email_to = "info@h16.be";
    $email_subject = "Nieuw bericht";

    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('Sorry, er is een probleem met het formulier dat u probeert te versturen.');
    }

    $name = $_POST['Name']; // required
    $email = $_POST['Email']; // required
    $message = $_POST['Message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Ongeldig emailadres.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Ongeldige naam.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Ongeldig bericht.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }
    
    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Naam: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Bericht: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'Van: ' . $email . "\r\n" .
        'Antwoord: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
    sleep(1);
    header( "refresh:4;url=/index.html" );
    echo "Bedankt voor uw email! Wij komen zo snel mogelijk in contact met u.";
    
?>

<?php
}
?>