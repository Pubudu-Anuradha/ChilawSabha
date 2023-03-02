<div class="content">
    <div class="page">
        <div class="title">
            <?php
            $page_title = "BOOK CATALOGUE";
            echo '<h2>' . $page_title . '</h2>';
            ?>  
            <div class="sub-title">  
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
        <div class="content-table">
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
                        <div class="btn-column">
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
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
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
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
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
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
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>P305</td>
                    <td>Harry Poter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Kiado</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn edit bg-yellow" onclick="window.location.href = '<?=URLROOT . '/LibraryStaff/Editbooks'?>'">Edit</button>
                            <button class="btn lost bg-red">Lost</button>
                            <button class="btn delist bg-orange">Delist</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- <div class="page-nav">
            <?php
            $page = $data['Users']['page'];
            $size = $page[1];
            $max = $data['Users']['count'];
            $page_count = ceil($max / $size);
            $current = $page[0] / $size;
            ?>
            <div class="page-nos">
                <?php if($current!=0):?>
                    <a href="<?= URLROOT . "/Admin/Users?page=0&size=$size" ?>" class="page-btn">&lt;&lt;</a>
                    <a href="<?= URLROOT . "/Admin/Users?page=".($current - 1)."&size=$size" ?>" class="page-btn">&lt;</a>
                <?php endif; ?>
                <select name="page" onchange="send()" id="page">
                    <?php
                    $i = 0;
                    for (; $i * $size < $max; $i++) : ?>
                        <option value="<?= $i ?>" <?= $i==$current?'selected' : ''?>><?= $i + 1 ?></option>
                    <?php endfor ?>
                </select>
                <?php if($current<$page_count-1):?>
                    <a href="<?= URLROOT . "/Admin/Users?page=" . ($current + 1) . "&size=$size" ?>" class="page-btn">&gt;</a>
                    <a href="<?= URLROOT . "/Admin/Users?page=" . ($page_count - 1) . "&size=$size" ?>" class="page-btn">&gt;&gt;</a>
                <?php endif; ?>
            </div>
            <div class="page-size">
                No.of Posts per page : <select name="size" onchange="send()" id="size">
                    <?php foreach ([10, 25, 50, 100] as $page_size) : ?>
                        <option value="<?= $page_size ?>" <?= $page_size == $size?'selected':''?>><?= $page_size ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div> -->
        <!-- <div class="pagination-bar">
            <div class="pagination-item">1</div>
            <div class="pagination-item"> 2</div>
            <div class="pagination-item">3</div>
            <div class="pagination-item">4</div>
            <div class="pagination-item"> &#62; </div>
        </div> -->
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