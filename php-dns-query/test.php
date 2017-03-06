
<?php

// Open a Socket connection to our WHOIS server
$fp = fsockopen("whois.domain.com", 43);

// The data we're sending
$out = "yahoo.com\r\n";

// Send the data
fwrite($fp, $out);

// Listen for data and "append" all the bits of information to 
// our result variable until the data stream is finished
// Simple: "give me all the data and tell me when you've reached the end"
while (!feof($fp)) {
	$whois .= fgets($fp, 128);
}


// Print out the data we've received
echo "<pre>";
echo $whois;
echo "</pre>";

// Close the Socket Connection
fclose($fp);

?>
