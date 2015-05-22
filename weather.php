<?php

# Grab some of the values from the slash command, create vars for post back to Slack
$command = $_POST['command'];
$text = $_POST['text'];
$token = $_POST['token'];

# Check the token and make sure the request is from our team 
if($token != 'TOKEN HERE'){ #replace this with the token from your slash command configuration page
  $msg = "The token for the slash command doesn't match. Check your script.";
  die($msg);
  echo $msg;
}

# We're just taking the text exactly as it's typed by the user. If it's not a valid domain, isitup.org will respond with a `3`.
# We want to get the JSON version back (you can also get plain text).
$loc_to_check = "https://api.forecast.io/forecast/API-KEY/".$text;

# Set up cURL 
$ch = curl_init($loc_to_check);

# Set up options for cURL 
# We want to get the value back from our query 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

# Make the call and get the response 
$ch_response = curl_exec($ch);
# Close the connection 
curl_close($ch);

# Decode the JSON array sent back by isitup.org
$response_array = json_decode($ch_response,true);

# Build our response 
# Note that we're using the text equivalent for an emoji at the start of each of the responses.
# You can use any emoji that is available to your Slack team, including the custom ones.

if($ch_response === FALSE){
# isitup.org could not be reached
$reply = "Dark Sky could not be reached.";
}else{
#$reply = "".$response_array["currently"]."|".$response_array["currently"]." // made with :heart: by Harsh in San Francisco";
$reply = $response_array['currently']['summary'] . " // Made with :heart: by Harsh in San Francisco";
}


# Send the reply back to the user. 
echo $reply;