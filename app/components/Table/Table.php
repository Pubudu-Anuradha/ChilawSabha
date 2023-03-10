<?php
class Table{
  // $columns takes an associative array as ['col_name' => 'Column Title(Displayed title),...]
  // $row_data is a numeric array of associative arrays like
  // [
  //  ['col_1'=>'r1_c1','col_2'=>'r1_c2'],
  //  ['col_1'=>'r2_c1','col_2'=>'r2_c2'],
  //  ['col_1'=>'r3_c1','col_2'=>'r3_c2'],
  // ]
  public static function Table($columns,$row_data,$id=NULL,$caption = NULL,$actions = [
    'Action 1' => [
    ['F string %s %s', 'id','name'],// sprintf arguments "%s string" followed by column names
    // contents of column will be used as actual arguments.
    'edit' ,'#'// classes for the action button
    ],
    'View' => [
    ['view/%s', 'id'],
    'view bg-green', '#'
    ],
  ],$empty = false,$empty_msg = 'No content found'){
    $action_count = count($actions);
  ?>
  <div class="content-table">
    <table <?=$id?"id=\"$id\"":''?>>
      <?php if($caption):?>
      <caption><?= $caption ?></caption>
      <?php endif; ?>
      <thead>
        <tr>
          <?php foreach($columns as $name => $title):?>
            <th>
              <?=$title?>
            </th>
          <?php endforeach;
          if($action_count>0):
            if($action_count==1):?>
              <th>Action</th>
            <?php else: ?>
              <th>Actions</th>
            <?php endif;
            endif;?>
        </tr>
      </thead>
      <tbody>
        <?php if(!$empty):
        foreach($row_data as $row):?>
          <tr>
            <?php foreach($columns as $col_name => $title): ?>
              <td>
                <?= $row[$col_name] ?>
              </td>
            <?php endforeach; ?>
            <?php if($action_count>0): ?>
              <td>
                <div class="btn-column">
             <?php foreach($actions as $name => $func):
                // Converting each index to use referenced column's value
                for($i = 1;$i < count($func[0]);++$i){
                  $func[0][$i] = $row[$func[0][$i]];
                }
                // Embedding the intended value to the href string
                $href = call_user_func_array('sprintf',$func[0]);
              ?>
                  <a href="<?= $href ?>" class="btn <?= $func[1] ?>" onclick="<?= $func[2] ?>"><?= $name ?></a>
            <?php endforeach;?>
                </div>
              </td>
              
            <?php endif; ?>
          </tr>
        <?php endforeach;
        else: ?>
        <tr>
          <td colspan="<?= count($columns) + (($action_count > 0) ? 1 : 0)?>" 
              style="text-align:center">
            <?= $empty_msg ?>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
 <?php }
}