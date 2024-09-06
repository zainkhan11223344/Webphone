<?php
// Connect to the database
$conn = mysqli_connect("localhost", "username", "password", "database");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle agent availability update
if ($_POST['action'] == 'update_availability') {
  $agent_id = $_POST['agent_id'];
  $availability = $_POST['availability'];
  $query = "UPDATE agents SET availability = '$availability' WHERE id = '$agent_id'";
  mysqli_query($conn, $query);
}

// Handle agent list retrieval
if ($_POST['action'] == 'get_agent_list') {
  $query = "SELECT * FROM agents WHERE availability = 'Available'";
  $result = mysqli_query($conn, $query);
  $agent_list = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $agent_list[] = $row;
  }
  echo json_encode($agent_list);
}

// Handle call assignment
if ($_POST['action'] == 'assign_call') {
  $call_id = $_POST['call_id'];
  $agent_id = $_POST['agent_id'];
  $query = "UPDATE calls SET agent_id = '$agent_id' WHERE id = '$call_id'";
  mysqli_query($conn, $query);
}

// Handle call decline
if ($_POST['action'] == 'decline_call') {
  $call_id = $_POST['call_id'];
  $query = "UPDATE calls SET status = 'Declined' WHERE id = '$call_id'";
  mysqli_query($conn, $query);
}

// Close database connection
mysqli_close($conn);

require_once('cyburphone.php');

require_once('cd_template.php');
?>