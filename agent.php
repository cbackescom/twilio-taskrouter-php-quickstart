<?php
 
    /* Substitute your values here */
    $account_sid = '{AC********************************}';
    $auth_token = '{**********************************}';
    $workspace_sid = '{WS********************************}';
    /* All done substituting. Mr Bergstrom would be proud. */
 
    $worker_sid = $_REQUEST['WorkerSid'];
 
    require_once('twilio-php/Services/Twilio/CapabilityTaskRouter.php');
    $worker_capability = new Services_Twilio_TaskRouter_Worker_Capability($account_sid, $auth_token,
                                                                          $workspace_sid, $worker_sid);
    $worker_capability->allowWorkerFetchAttributes();
    $worker_capability->allowWorkerActivityUpdates();
    $worker_token = $worker_capability->generateToken();
 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Care - Voice Agent Screen</title>
      <link rel="stylesheet" href="//media.twiliocdn.com/taskrouter/quickstart/agent.css"/>
    <script src="//media.twiliocdn.com/taskrouter/js/v1.0/taskrouter.worker.min.js"></script>
    <script src="agent.js"></script>
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
    <section class="log">
      <textarea id="log" readonly="true"></textarea>
    </section>
</div>
<script>
  window.workerToken = "<?= $worker_token ?>";
</script>
</body>
</html>
