<?php
header('Content-type: text/xml');
?>
<Response>
<Dial callerId="{'YOURTWILIOPHONENUMBER'}"><?php echo htmlspecialchars($_REQUEST["tocall"]); ?></Dial>
</Response>
