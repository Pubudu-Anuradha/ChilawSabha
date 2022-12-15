<?php

require_once 'Header.php';
require_once 'Options.php';
$complaint = $data['complaint'];
if ($complaint->num_rows == 0) {
    echo "NO SUCH COMPLAINT";
} else {
    if (isset($data['complaint'])) {
        $complaint = $data['complaint']->fetch_assoc();
        ?>


        <div class="one-complaint">
            <div class="status-set">
                <p>Status</p>
                <p class="new">New</p>
                <button>Accept</button>
            </div>

            <div class="complaint-data">
                id : <?=$complaint['complaint_id']?><br>
                name : <?=$complaint['name']?><br>
                email : <?=$complaint['email']?><br>
                number : <?=$complaint['mobi_num']?><br>
                date : <?=$complaint['date']?><br>
                category : <?=$complaint['category']?><br>
                message : <?=$complaint['message']?><br>
            </div>

        </div>
<?php
}
}
