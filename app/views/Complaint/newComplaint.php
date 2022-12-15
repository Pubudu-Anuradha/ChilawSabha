<?php

require_once 'Header.php';
require_once 'Options.php';
$complaint = $data['complaint'];
if ($complaint->num_rows == 0) {
    echo "NO SUCH COMPLAINT";
} else {
    $complaint = $complaint->fetch_assoc();
    var_dump($complaint);
}
