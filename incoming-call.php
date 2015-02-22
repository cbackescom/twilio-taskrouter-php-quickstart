<?php
 
header('Content-Type: application/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
 
?>
<Response>
  <Gather action="enqueue-call.php" numDigits="1" timeout="5">
    <Say language="es">Para Español oprime el uno.</Say>
    <Say language="en">For English, please hold or press two.</Say>
  </Gather>
</Response>
