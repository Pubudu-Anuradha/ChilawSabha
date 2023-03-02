<div class="content">
    <div class="page">
        <div class="lend-book">
            <div class="content-title-search usr-search">
                <input type="text" name="search" placeholder=" Search User" id="search">
                <button>
                    <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
                </button>
            </div>

            <div class="lend-book-content">
                <div class="lend-form">
                    <div class="lend-book-title">
                        <h2>LEND A BOOK</h2>
                    </div>
                    <div class="field">
                        <label for="acc1">Book Accession No 01</label>
                        <input type="text" name="acc1" id="acc1">
                    </div>
                    <div class="field">
                        <label for="acc2">Book Accession No 02</label>
                        <input type="text" name="acc2" id="acc2">
                    </div>
                    <div class="lend-confirm">
                        <button type="button" class="btn white bg-blue" onclick="openModal()">Lend</button>
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                                <div class="model-text"><p>Are You Sure?</p></div>
                                <div class="popup-btn">
                                    <button class="btn bg-green white" onclick="closeModal()">Confirm</button>
                                    <button class="btn bg-red white" onclick="closeModal()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="status">
                    <div>
                        <h2>USER STATISTICS</h2>
                    </div>
                    <div class="status-content">
                        <div>
                            <h4>Lend Status : </h4>
                            <div class="status-dot"></div>
                        </div>
                        <div>
                            <h4 >Fine Status : </h4>
                            <h4 class="green"> Rs. 00 00 </h4> 
                        </div>
                        <div>
                            <h4 >Books Lost : </h4>
                            <h4 class="red"> 2</h4>
                        </div>
                        <div>
                            <h4>Books Damaged : </h4>
                            <h4 class="red"> 3</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="recieve-book">
            <div class="recieve-book-title">
                <h2>RECIEVE A BOOK</h2>
                <div class="extend-due-date">
                    <input type="submit" name="Submit" value="Extend Due Date" class="btn bg-blue white">
                </div>
            </div>
            <div class="recieve-book-content">
                <div class="content-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Accession No</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Due Date</th>
                                <th>Damaged</th>
                                <th>Recieved</th>
                            </tr>
                        </thead>

                        <tr>
                            <td>P305</td>
                            <td>Harry Poter</td>
                            <td>J.K. Rowling</td>
                            <td>Animus Kiado</td>
                            <td>12/04/2023</td>
                            <td class="check"><input type="checkbox" name="damagedcheck" id="damagedcheck"></td>
                            <td class="check"><input type="checkbox" name="recievedcheck" id="recievedcheck" checked></td>
                        </tr>
                        <tr>
                            <td>A45</td>
                            <td>Atomic Habits</td>
                            <td>James Clear</td>
                            <td>Penguin Random</td>
                            <td>21/05/2023</td>
                            <td class="check"><input type="checkbox" name="damagedcheck" id="damagedcheck"></td>
                            <td class="check"><input type="checkbox" name="recievedcheck" id="recievedcheck" checked></td>
                        </tr>
                    </table>
                </div>
                <div class="recieve-submition">
                    <div class="recieve-confirm">
                        <input type="submit" name="Submit" value="Confirm" class="btn bg-green white">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

var modal = document.getElementById("myModal");

function closeModal(){
    modal.style.display = "none";
}
function openModal(){
    modal.style.display = "block";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>