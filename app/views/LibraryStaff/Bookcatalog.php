<div class="content">
    <div class="bookcatalog">
        <div class="bookcatalog-title">
            <?php
            $page_title = "BOOK CATALOGUE";
            echo '<h2>' . $page_title . '</h2>';
            ?>  
            <div class="catalog-sub-title">  
                <input type="button" onclick="generate('#catalog','<?php echo $page_title ?>',4)" value="Export To PDF" class="btn bg-green"/>
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
                        <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
                    </button>
                </div>
            </div>

        </div>
        <div class="book-catalog-table">
            <table id="catalog">
                <thead>
                    <tr>
                        <th>Accession No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
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
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost">Lost</button>
                            <button class="btn delist">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
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
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost">Lost</button>
                            <button class="btn delist">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
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
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost">Lost</button>
                            <button class="btn delist">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="action-btn-set">
                            <button class="btn edit" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost">Lost</button>
                            <button class="btn delist">Delist</button>
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

<script>
    function generate(id,title,num_of_cloumns) {
        var doc = new jsPDF('p', 'pt', 'a4');

        var text = title;
        var txtwidth = doc.getTextWidth(text);

        var x = (doc . internal . pageSize . width - txtwidth) / 2;

        doc.text(x, 50, text);
        //to define the number of columns to be converted
        var columns = [];
        for(let i=0; i<num_of_cloumns; i++){
            columns.push(i);
        }


        doc.autoTable({
            html: id,
            startY: 70,
            theme: 'striped',
            columns: columns,
            columnStyles: {
                halign: 'left'
            },
            styles: {
                minCellHeight: 30,
                halign: 'center',
                valign: 'middle'
            },
            margin: {
                top: 150,
                bottom: 60,
                left: 10,
                right: 10
            }
        })
        doc.save(title.concat('.pdf'));
    }
</script>