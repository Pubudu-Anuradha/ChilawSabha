<?php
    $table = $data['PlantoRead'];
?>

<div class="content">
    <div class="bookcatalog">
        <div class="head-area">
            <div class="sub-head-area">
                <h1>PLAN TO READ BOOK LIST</h1>
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
                            <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
                        </button>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        
        <div class="book-catalog-table">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center">Order</th>
                        <th>Accession No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th style="text-align:center">Status</th>
                        <th style="text-align:center">Action</th>
                    </tr>
                </thead>

                <tbody  class="dragdrop">
                    <?php if (!$table['nodata'] && !$table['error']):
                        foreach ($table['result'] as $plrbooks): ?>

	                            <tr draggable="true" class="draggable" id="<?=$plrbooks['accNo']?>">
	                                <td>
	                                    <div class="changeOrder-bar">
	                                        <button> &#9776; </button>
	                                    </div>
	                                </td>
	                                <td><?=$plrbooks['accNo']?></td>
	                                <td><?=$plrbooks['Title']?></td>
	                                <td><?=$plrbooks['Author']?></td>
	                                <td><?=$plrbooks['Publisher']?></td>
	                                <td>
	                                    <div class="action-btn-set">
	                                        <button class="btn status-available" disabled>Available</button>
	                                    </div>
	                                </td>
	                                <td>
	                                    <div class="action-btn-set">
	                                        <button class="btn remove">Remove</button>
	                                        <button class="btn completed">Completed</button>
	                                    </div>
	                                </td>
	                            </tr>
	                        <?php endforeach;else: ?>
                        <tr>
                            <td colspan="7">
                                No Data Available
                                <?php var_dump($data);?>
                            </td>
                        </tr>
                    <?php endif;?>
                </tbody>
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
    const rows = document.querySelectorAll('.draggable');
    const container = document.querySelector('.dragdrop');

    rows.forEach(row => {
        row.addEventListener('dragstart', () => {
            row.classList.add('dragging');
        })
        row.addEventListener('dragend', () => {
            row.classList.remove('dragging');
        })
    })

    container.addEventListener('dragover', (e) =>{
        e.preventDefault();
        const afterRow = findDragAfterRow(container, e.clientY)
        const row = document.querySelector('.dragging');
        if( afterRow == null){
            container.appendChild(row);  
        }
        else{
            container.insertBefore(row, afterRow);
        }
        //added the row id list after drop
        var selectedData = [];
        var dataIds = document.querySelectorAll('.dragdrop > tr');
        dataIds.forEach(function(dataId) {
            selectedData.push(dataId.id);
        });
        updateOrder(selectedData);
    })

    //function to find the next row of the row replacing
    function findDragAfterRow(container, y){
        const rows = [...container.querySelectorAll('.draggable:not(.dragging)')];

        return rows.reduce((closestRow, child) => {
            const rowBox = child.getBoundingClientRect();
            const offset = y - rowBox.top - rowBox.height / 2;
            if(offset < 0 && offset > closestRow.offset ){
                return { offset: offset, element: child };
            }
            else{
                return closestRow;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element
    }

    function updateOrder(aData){
        //setting up url to pass
        var url ="";
        for(let i=0; i<aData.length; i++){
            url += i+"="+aData[i];
            if(i != aData.length-1){
                url+="&";
            }   
        }
        //creating a xml request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= URLROOT . "/LibraryMember/planToRead" ?>');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //set header to idenfy in backend
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(url);
    }

</script>