<?php

require_once 'Header.php';
require_once 'Options.php';

?>

<div class="view-new-complaint">
    <h1>
        New Complaints
    </h1>
    <hr class="hr1">
    <br>

</div>


<table class="content-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Complainer Name</th>
            <th>Category</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
if (isset($data['Complaints'])) {

    while ($complaint = $data['Complaints']->fetch_assoc()) {
        echo "<tr>";
        echo "<td class ='data tab-id'>" . $complaint['complaint_id'] . "</td>";
        echo "<td class ='data'>" . $complaint['name'] . "</td>";
        echo "<td class ='data'>" . $complaint['category'] . "</td>";
        echo "<td class='category'>" . $complaint['date'] . "</td>";
        $link = URLROOT . '/Complaint/newComplaint/' . $complaint['complaint_id'];
        echo "<td class = 'action-btn'>
                <button class = 'accept' >Accept</button>
                <button class = 'view' onclick=\"location.href='$link'\">View</button>
             </td>";
        echo "</tr>";
    }
}
?>

    </tbody>
</table>

<?php
require_once 'Footer.php';

?>