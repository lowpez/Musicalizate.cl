<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        //$name = strip_tags(trim($_POST["name"]));
		//$name = str_replace(array("\r","\n"),array(" "," "),$name);
		$name = "Nuevo Suscriptor";
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        //$message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        //if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
          if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {

		    // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! Algo salió mal :'(.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "jonathanscottgonzalez@gmail.com";


        // Set the email subject.
        $subject = "Musicalizate : $name";

        // Build the email content.
        $email_content = "Nombre: $name\n";
        $email_content .= "Email: $email\n\n";
        //$email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Gracias! Suscripcion enviada.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Algo salió mal :'(.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
