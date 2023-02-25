<div class="content">
    <h2>
        My Working Complaints
        <hr class="hr1">
    </h2>
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Complaint ID</th>
                    <th>Complainer Name</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>11</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.15</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn view">View</button>
                            <button type="button" class="btn view" onclick="openModal()">Add Note</button>

                        </div>


                    </td>
                </tr>

                <tr>
                    <td>12</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.30</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn view">View</button>
                            <button type="button" class="btn view" onclick="openModal()">Add Note</button>

                        </div>

                    </td>
                </tr>

                <tr>
                    <td>13</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.31</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn view">View</button>
                            <button type="button" class="btn view" onclick="openModal()">Add Note</button>

                        </div>

                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    
    <div class="popup popup-confirm">
        <div id="popupModal" class="popup-modal">
            <div class="popup-content">
                <div class="close-section-popup"><span class="close-popup" onclick="closeModal()">&times;</span></div>
                <div class="popup-text">
                    <p>ADD NOTE</p>
                    <div class="note-textarea">
                        <textarea id="noteInput" name="message" rows="10" cols="64"></textarea>
                    </div>
                </div>
                <div class="popup-submit-btn">
                    <button class="btn bg-blue" onclick="closeModal()">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var modal = document.getElementById("popupModal");

    function closeModal() {
        modal.style.display = "none";
    }

    function openModal() {
        modal.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>