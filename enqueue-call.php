<?php
 
$digit_pressed = $_REQUEST['Digits'];
 
if ($digit_pressed == '1') {
  $language = "es";
} else {
  $language = "en";
}
 
header('Content-Type: application/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
 
?>
<Response>
  <Enqueue workflowSid="WW4048ea2c86d25c2d5d7c56cbdd6b8738">
    <TaskAttributes>{"selected_language": "<?= $language ?>"}</TaskAttributes>
  </Enqueue>
</Response>
