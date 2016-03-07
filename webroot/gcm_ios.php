<?php


// Payload data you want to send to Android device(s)
// (it will be accessible via intent extras)
$data = array( 'message' => 'Hello hg World!' );

// The recipient registration tokens for this notification
// http://developer.android.com/google/gcm/

$ids = array('n5xAkx_P0Dc:APA91bHYtA5T6oaxazBs1ngKaewB0B7cUqWOM4LEpZpy2pwM6Red_QSRXjeVKPlxHIywpZ05QUF3DwUWz9U2bJlBW77oREh3s9r2VCpEz75d8vmlJN_jJbaE8-I5mKWp5uKsUPmp2EXb');



// Send a GCM push
sendGoogleCloudMessage(  $data, $ids );

function sendGoogleCloudMessage( $data, $ids )
{
// Insert real GCM API key from Google APIs Console
// https://code.google.com/apis/console/
$apiKey = 'AIzaSyC6z1RbKr-h5OCdHIR8ArajM-5rZME2j4g';

// Define URL to GCM endpoint
$url = 'https://gcm-http.googleapis.com/gcm/send';

    $title = 'title';
    $body='body';
    $badge= 3;
    $sound= 'default';

    $notification = array(
        'title' => $title,
        'body'  => $body,
        'badge' => $badge,
        'sound' => $sound

    );
    $priority= 'high';

// Set GCM post variables (device IDs and push payload)
$post = array(
//'registration_ids'  => $ids,
    'registration_ids'   => $ids,
    //'data'               => $data,
    'notification'       => $notification,
    'priority'           => $priority
);

// Set CURL request headers (authentication and type)
$headers = array(
'Authorization: key=' . $apiKey,
'Content-Type: application/json'
);

// Initialize curl handle
$ch = curl_init();

// Set URL to GCM endpoint
curl_setopt( $ch, CURLOPT_URL, $url );

// Set request method to POST
curl_setopt( $ch, CURLOPT_POST, true );

// Set our custom headers
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

// Get the response back as string instead of printing it
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

// Set JSON post data
curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

// Actually send the push
$result = curl_exec( $ch );

// Error handling
if ( curl_errno( $ch ) )
{
echo 'GCM error: ' . curl_error( $ch );
}

// Close curl handle
curl_close( $ch );

// Debug GCM response
echo $result;
    echo '<pre>';
    print_r(json_encode( $post ));
}