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

    <!-- <div class="accept">
        <input type="submit" value="Accept">
    </div>

    <div class="view">
        <input type="submit" value="View" >
    </div> -->


</div>


<table class="content-table">
    <thead>
        <tr>
            <th>Complaint ID</th>
            <th>Complainer Name</th>
            <th>Category</th>
            <th>Date</th>
            <th>Accept</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
        <?php
if (isset($data['Complaints'])) {

    while ($complaint = $data['Complaints']->fetch_assoc()) {
        echo "<tr>";
        echo "<td class ='data'>" . $complaint['complaint_id'] . "</td>";
        echo "<td class ='data'>" . $complaint['name'] . "</td>";
        echo "<td class ='data'>" . $complaint['category'] . "</td>";
        echo "<td class='category'>" . $complaint['date'] . "</td>";
        echo "<td>
                <a class = 'accept' href = '#' >Accept</a>
             </td>";
        echo "<td>
                <a class = 'view' href = '#' >View</a>
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