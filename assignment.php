<?php
 
$assignment_instruction = [
  'instruction' => 'dequeue',
  'post_work_activity_sid' => '{WA********************************}'
];
 
header('Content-Type: application/json');
echo json_encode($assignment_instruction);
