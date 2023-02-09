<div class="content">
    <div class="content-title">
        <div class="content-title-category">
            <select name="categoryFill">
                <option value="Null">Choose Category</option>
                <option value="Administrator">Administrator</option>
                <option value="Complaint Handler">Complaint Handler</option>
                <option value="Library Staff">Library Staff</option>
            </select>
        </div>
        <div class="content-title-search">
            <input type="text" name="search" placeholder=" Search" id="search">
            <button>
                <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
            </button>
        </div>
    </div>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Accestion number</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>P305</td>
                    <td>Harry Potter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Klado</td>
                    <td>
                        <div  class="btn-column">
                            <button class="btn edit">Edit</button>
                            <button class="btn lost">Lost</button>
                            <button class="btn delist">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>A45</td>
                    <td>Atomic Habits</td>
                    <td>James Clear</td>
                    <td>Penguin Random</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn edit">Edit</button>
                            <button class="btn lost">Lost</button>
                            <button class="btn delist">Delist</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
