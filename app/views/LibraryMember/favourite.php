<?php require_once 'Sidebar.php'?>
<div class="content">
    <div class="bookcatalog">
        <div class="head-area">
            <div class="sub-head-area">
                <h1>FAVOURITE BOOK LIST</h1>
                <div class="catalog-sub-title">
                    <div class="content-title-category">
                    <select name="categoryFill">
                        <option value="Null">Choose Category</option>
                        <option value="Philosophy">Philosophy</option>
                        <option value="Languages">Languages</option>
                        <option value="Natural Sciences">Natural Sciences</option>
                        <option value="Literature">Literature</option>
                    </select>
                    </div>
                    <div class="content-title-search">
                        <input type="text" name="search" placeholder=" Search" id="search">
                        <button>
                            <img src="<?=URLROOT . '/public/assets/search.png'?>" alt="search btn">
                        </button>
                    </div>
                </div>
            </div>
            <hr>
        </div>

        <div class="book-catalog-table">
            <table>
                <tr>
                    <th>Accession No</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th style="text-align:center">Action</th>

                </tr>
                <tr>
                    <td style="padding-left:3rem">P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:3rem">A45</td>
                    <td>Atomic Habits</td>
                    <td>James Clear</td>
                    <td>Penguin Random</td>
                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>
                        </div>
                    </td>
                </tr>
                <tr>

                    <td style="padding-left:3rem">P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>

                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>

                        </div>
                    </td>
                </tr>
                <tr>

                    <td style="padding-left:3rem">A45</td>
                    <td>Atomic Habits</td>
                    <td>James Clear</td>
                    <td>Penguin Random</td>

                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>

                        </div>
                    </td>
                </tr>
                <tr>

                    <td style="padding-left:3rem">P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>

                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>

                        </div>
                    </td>
                </tr>
                <tr>

                    <td style="padding-left:3rem">A45</td>
                    <td>Atomic Habits</td>
                    <td>James Clear</td>
                    <td>Penguin Random</td>

                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>

                        </div>
                    </td>
                </tr>
                <tr>

                    <td style="padding-left:3rem">P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>

                    <td>
                        <div class="action-btn-set">
                            <button class="btn remove">Remove</button>

                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="pagination-bar">
            <div class="pagination-item">1</div>
            <div class="pagination-item"> 2</div>
            <div class="pagination-item">3</div>
            <div class="pagination-item">4</div>
            <div class="pagination-item"> &#62; </div>
        </div>
    </div>
</div>