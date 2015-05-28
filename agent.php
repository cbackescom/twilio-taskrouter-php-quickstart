<?php
 
    /* Substitute your values here */
    $account_sid = '{AC********************************}';
    $auth_token = '{**********************************}';
    $workspace_sid = '{WS********************************}';
    $twiml_dialout = ''{AP********************************};
    /* All done substituting. Mr Bergstrom would be proud. */
 
    $worker_sid = $_REQUEST['WorkerSid'];
    $client_name = $_REQUEST['agentID'];
 
    require_once('twilio-php/Services/Twilio/CapabilityTaskRouter.php');
    $worker_capability = new Services_Twilio_TaskRouter_Worker_Capability($account_sid, $auth_token,
                                                                          $workspace_sid, $worker_sid);
    $worker_capability->allowWorkerFetchAttributes();
    $worker_capability->allowWorkerActivityUpdates();
    $worker_token = $worker_capability->generateToken();
    
    require_once('twilio-php/Services/Twilio/Capability.php');
    $capability = new Services_Twilio_Capability($account_sid, $auth_Token);
    $capability->allowClientOutgoing($twiml_dialout);
    $capability->allowClientIncoming($clientname);
    $token = $capability->generateToken();
 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Care - Voice Agent Screen</title>
      <link rel="stylesheet" href="agent.css"/>
    <script src="//media.twiliocdn.com/taskrouter/js/v1.0/taskrouter.worker.min.js"></script>
    <script src="agent.js"></script>
    <script type="text/javascript">
     $(document).ready(function(){
                Twilio.Device.setup("<?php echo $token; ?>");
                        var connection=null;
                        
                        $("#call").click(function() {
                                params = { "number" : $('#number').val()}; 
                                connection = Twilio.Device.connect(params);
                        });
                        $("#hangup").click(function() {  
                                Twilio.Device.disconnectAll();
                        });
                        $("#dequeue").click(function() {
                                connection = Twilio.Device.connect();
                        });
                        Twilio.Device.ready(function (device) {
                                $('#status').text('Registered');
                        });
                        Twilio.Device.incoming(function (conn) {
                                if (confirm('Accept incoming call from ' + conn.parameters.From + '?')){
                                        connection=conn;
                                    conn.accept();
                                }
                        });

                        Twilio.Device.offline(function (device) {
                                $('#status').text('Not Registered');
                        });

                        Twilio.Device.error(function (error) {
                                $('#status').text(error.message);
                        });

                        Twilio.Device.connect(function (conn) {
                                $('#status').text("On Call");
                                toggleCallStatus();
                        });

                        Twilio.Device.disconnect(function (conn) {
                                $('#status').text("Off Call");
                                toggleCallStatus();
                                });

                        function toggleCallStatus(){
                                $('#call').toggle();
                                $('#hangup').toggle();
                                $('#dialpad').toggle();
                        }

                        $.each(['0','1','2','3','4','5','6','7','8','9','star','pound'], function(index,
                        value) { 
                        $('#button' + value).click(function(){ 
                                        if(connection) {
                                                if (value=='star')
                                                        connection.sendDigits('*')
                                                else if (value=='pound')
                                                        connection.sendDigits('#')
                                                else
                                                        connection.sendDigits(value)
                                                return false;
                                        } 
                                        });
                        });


                });
    </script>
</head>
<body>
<div class="content">
    <section class="agent-activity offline">
        <p class="activity">Offline</p>
        <button class="change-activity" data-next-activity="Idle">Go Available</button>
    </section>
    <section class="agent-activity idle">
        <p class="activity"><span>Available</span></p>
        <button class="change-activity" data-next-activity="Offline">Go Offline</button>
    </section>
    <section class="agent-activity reserved">
        <p class="activity">Reserved</p>
    </section>
    <section class="agent-activity busy">
        <p class="activity">Busy</p>
    </section>
    <section class="agent-activity wrapup">
        <p class="activity">Wrap-Up</p>
        <button class="change-activity" data-next-activity="Idle">Go Available</button>
        <button class="change-activity" data-next-activity="Offline">Go Offline</button>
    </section>
    <section class="phone">
    <center><?php echo 'Agent: ' .htmlspecialchars($_GET["agent"]) . ''; ?>
                        <div id="status" style="color:#009966">
                                Offline
                        </div>
                        </center>
                        <br/>
                        <center><input type="text" id="number" size="14" value="" name="number">
                        <br/><br/>
                        <input type="button" id="call" value="CALL"/>
                        <input type="button" id="hangup" value="ENDCALL" style="display:none;"/>
                        </center>
                        <br/>
                        <center>
                        <div id="dialpad" style="display:none;">
                        <table class='flat-table flat-table-3'>
                        <tr>
                        <td><input type="button" value="1" id="button1"></td>
                        <td><input type="button" value="2" id="button2"></td>
                        <td><input type="button" value="3" id="button3"></td>
                        </tr>
                        <tr>
                        <td><input type="button" value="4" id="button4"></td>
                        <td><input type="button" value="5" id="button5"></td>
                        <td><input type="button" value="6" id="button6"></td>
                        </tr>
                        <tr>
                        <td><input type="button" value="7" id="button7"></td>
                        <td><input type="button" value="8" id="button8"></td>
                        <td><input type="button" value="9" id="button9"></td>
                        </tr>
                        <tr>
                        <td><input type="button" value="*" id="buttonstar"></td>
                        <td><input type="button" value="0" id="button0"></td>
                        <td><input type="button" value="#" id="buttonpound"></td>
                        </tr>
                        </table>
                        </div>
    </center>
    </section>
    <section class="log">
      <textarea id="log" readonly="true"></textarea>
    </section>
</div>
<script>
  window.workerToken = "<?= $worker_token ?>";
</script>
</body>
</html>
