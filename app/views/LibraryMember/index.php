<div class="content">
    <div class="head-area">
        <h1>WELCOME TO CHILAW PUBLIC LIBRARY</h1>
        <hr>
    </div>
    <div class="dashboard-mid-area">
        <div class="fine-container">
            <h2>Fine Amount</h2>
            <hr>
            <div class="fine-sub">
                <img src=<?= URLROOT . '/public/assets/fine.png' ?> alt='Fine Image'>
                <input type="text" name="textInputField" id="fine-holder" value="Rs.125.00" disabled> 
            </div>
        </div>
        <div class="request-container">
            <h2>Request Book</h2>
            <hr>
            <button class="btn request" onclick="window.location='<?= URLROOT . '/LibraryMember/bookRequest' ?>'">Make a Book Request</button>
        </div>
    </div>
    <div class="dashboard-bottom-area">
        <div class="dashboard-bottom-sub">
            <h2>Borrowed Books Section</h2>
            <button class="btn extend">Extend Due Date</button>
        </div>
        <hr>
        <div class="book-catalog-table">
            <table>
                <tr>
                    <th>Accession No</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Due Date</th>
                </tr>
                <tr>
                    <td style="padding-left:3rem">P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>2023/02/28</td>
                </tr>
                <tr>
                    <td style="padding-left:3rem">A45</td>
                    <td>Atomic Habits</td>
                    <td>James Clear</td>
                    <td>Penguin Random</td>
                    <td>2023/02/28</td>
                </tr>
            </table>
        </div>
    </div>
</div>