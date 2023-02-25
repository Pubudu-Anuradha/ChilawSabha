<div class="content">

    <h2>
        All Accepted Complaints
        <hr class="hr1">
    </h2>



    <div class="tab">
        <button class="tablinks" onclick="openComplaints(event, 'P_Complaints')">Processing Complaints</button>
        <button class="tablinks" onclick="openComplaints(event, 'R_Complaints')">Resolved Complaints</button>
    </div>

    <div id="P_Complaints" class="tabcontent">
        <div class="content-table">
            <table>
                <thead>
                    <tr>
                        <th>Complaint ID</th>
                        <th>Complainer Name</th>
                        <th>Category</th>
                        <th>Handler Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>11</td>
                        <td>W.P Alwis</td>
                        <td>Garbage Disposal</td>
                        <td>C.V. Perera</td>
                        <td>2022.12.15</td>
                        <td>Processing</td>
                        <td>
                            <div class="btn-column">
                                <button class="btn view">View</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>W.P Alwis</td>
                        <td>Garbage Disposal</td>
                        <td>C.V. Perera</td>
                        <td>2022.12.30</td>
                        <td>Resolved</td>
                        <td>
                            <div class="btn-column">
                                <button class="btn view">View</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>13</td>
                        <td>W.P Alwis</td>
                        <td>Garbage Disposal</td>
                        <td>C.V. Perera</td>
                        <td>2022.12.31</td>
                        <td>Processing</td>
                        <td>
                            <div class="btn-column">
                                <button class="btn view">View</button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div id="R_Complaints" class="tabcontent">
        <div class="content-table">
            <table>
                <thead>
                    <tr>
                        <th>Complaint ID</th>
                        <th>Complainer Name</th>
                        <th>Category</th>
                        <th>Handler Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12</td>
                        <td>W.P Alwis</td>
                        <td>Garbage Disposal</td>
                        <td>C.V. Perera</td>
                        <td>2022.12.15</td>
                        <td>Processing</td>
                        <td>
                            <div class="btn-column">
                                <button class="btn view">View</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>20</td>
                        <td>W.P Alwis</td>
                        <td>Garbage Disposal</td>
                        <td>C.V. Perera</td>
                        <td>2022.12.30</td>
                        <td>Resolved</td>
                        <td>
                            <div class="btn-column">
                                <button class="btn view">View</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>21</td>
                        <td>W.P Alwis</td>
                        <td>Garbage Disposal</td>
                        <td>C.V. Perera</td>
                        <td>2022.12.31</td>
                        <td>Processing</td>
                        <td>
                            <div class="btn-column">
                                <button class="btn view">View</button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function openComplaints(evt, complaint) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(complaint).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
