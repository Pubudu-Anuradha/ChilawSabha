<?php
  $table = $data['PlantoRead'];
?>

<div class="content">
  <div class="head-area">
    <div class="sub-head-area">
      <h1>PLAN TO READ BOOKS</h1>
    </div>
    <hr>
    <div class="head-actions-area">
      <?php
        $categories_assoc = []; 
        foreach ($data['categories']['result'] ?? [] as $category){
          if($category['category_code'] !== 'All'){
            $categories_assoc[$category['category_id']] = $category['category_code'] . " - " . $category['category_name'];
          }
        }

        $sub_categories_assoc = [];
        foreach ($data['sub_categories']['result'] ?? [] as $sub_category){
          if($sub_category['sub_category_code'] !== 'All'){
            $sub_categories_assoc[$sub_category['sub_category_id']] = $sub_category['sub_category_code'] . " - " . $sub_category['sub_category_name'];
          }
        }

        Pagination::top('/LibraryMember/bookCatalogue', 'member_catalogue_filter', select_filters:[
          'category' => [
            'Filter by category',
            array_merge(['0' => 'All'], $categories_assoc)
          ],
          'sub_category' => [
            'Filter by sub category',
            array_merge(['0' => 'All'], $sub_categories_assoc)
          ],
        ]);
      ?>
    </div>
  </div>
  <div class='content-table'>
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
        <?php 
          if (!$table['nodata'] && !$table['error']):
            foreach ($table['result'] as $plrbooks): 
        ?>
	            <tr draggable="true" class="draggable" id="<?=$plrbooks['accession_no']?>">
	              <td>
	                <div class="changeOrder-bar">
	                  <button> &#9776; </button>
	                </div>
	              </td>
	              <td>
                  <?=$plrbooks['accession_no']?>
                </td>
	              <td>
                  <?=$plrbooks['title']?>
                </td>
	              <td>
                  <?=$plrbooks['author']?>
                </td>
	              <td>
                  <?=$plrbooks['publisher']?>
                </td>
	              <td>
                  <?php 
                    echo '<p class="status-'.$plrbooks['status'].'">'.$plrbooks['status'].'</p>';
                  ?>
	              </td>
	              <td>
                  <div class="btn-column">
                    <a href="<?= URLROOT . '/LibraryMember/PlanToReads/remove/' . $plrbooks['accession_no'] ?>" class="btn bg-blue remove" onclick="#"><span>Remove</span></a>
                    <?php 
                      if(in_array($plrbooks['accession_no'],array_column($data['fav']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/PlanToReads/removeFav/' . $plrbooks['accession_no']?>" class="btn bg-blue unfav"><span>Remove Favorite</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/PlanToReads/favourite/' . $plrbooks['accession_no']?>" class="btn bg-blue fav"><span>Favorite</span></a>
                    <?php
                      endif;
                      if(in_array($plrbooks['accession_no'],array_column($data['comp']['result'],'accession_no'))):
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/PlanToReads/incomplete/' . $plrbooks['accession_no']?>" class="btn bg-blue incomplete"><span>Remove Completed</span></a>
                    <?php
                      else:
                    ?>
                        <a href="<?=URLROOT . '/LibraryMember/PlanToReads/completed/' . $plrbooks['accession_no']?>" class="btn bg-blue complete"><span>Completed</span></a>
                    <?php
                      endif;
                    ?>
                  </div>
	              </td>
	            </tr>
	      <?php 
          endforeach;else: 
        ?>
              <tr>
                <td colspan="7" style="text-align:center">
                  No Plan To Read Books Available
                </td>
              </tr>
        <?php 
          endif;
        ?>
      </tbody>
    </table>
  </div>
  <?php Pagination::bottom('filter-form', $data['PlantoRead']['page'],$data['PlantoRead']['count']);  ?>
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
    } else {
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
      } else {
        return closestRow;
      }
    }, { 
      offset: Number.NEGATIVE_INFINITY 
    }).element
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