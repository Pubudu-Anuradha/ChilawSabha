<div class="content">
    <h2>
        My Working Complaints <hr class="hr1">
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
                        <div  class="btn-column">
                            <button class="btn view">View</button>
                            <button class="btn view" id="show-note" onclick="">Add Note</button>
                        </div>


                    </td>
                </tr>

                <tr>
                    <td>12</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.30</td>
                    <td>
                        <div  class="btn-column">
                            <button class="btn view">View</button>
                            <button class="btn view" id="show-note">Add Note</button>
                        </div>

                    </td>
                </tr>

                <tr>
                    <td>13</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.31</td>
                    <td>
                        <div  class="btn-column">
                            <button class="btn view">View</button>
                            <button class="btn view" id="show-note">Add Note</button>
                        </div>

                    </td>
                </tr>

            </tbody>
        </table>
    </div>





    <div class="popup">
        <div class="close-btn">&times;</div>
        <div class="form-note">
            <h2>ADD NOTE</h2>
            <div class="inputfield-note">
                <textarea id="noteInput" name="message" rows="10" cols="64"></textarea>
            </div>


            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input type="submit" id="submit" value="Submit">
                </div>
            </div>

        </div>




        <!-- <button onclick="myFunction()">Try it</button> -->
    </div>
</div>

<!-- <script>
function myFunction() {
  window.open("<?=URLROOT . '/Complaint/addNote'?>", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=200,width=1000,height=500");
}
</script> -->


<script>
    function myFunction() {
  }
    document.querySelector("#show-note").addEventListener("click", function(){
    document.querySelector(".popup").classList.add("active");
    });

    document.querySelector(".popup .close-btn").addEventListener("click", function(){
    document.querySelector(".popup").classList.remove("active");
});
</script>