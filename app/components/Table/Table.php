<?php
class Table{

  public static function Head($columns,$caption = NULL,$actions = true,$actions_singular=false){
  ?>
  <div class="content-table">
    <table>
      <?php if($caption):?>
      <caption><?= $caption ?></caption>
      <?php endif; ?>
      <thead>
        <tr>
          <?php foreach($columns as $column):?>
            <th>
              <?=$column?>
            </th>
          <?php endforeach;
          if($actions):
            if($actions_singular):?>
              <th>Action</th>
            <?php else: ?>
              <th>Actions</th>
            <?php endif;
            endif;?>
        </tr>
      </thead>
 <?php }
  public static function Body($columns,$row_data,$actions,
  $action_funcs = [
    'Action 1' => [
    ['F string %s %s', 'id','name'],// sprintf arguments "%s string" followed by column names
    // contents of column will be used as actual arguments.
    'edit' // classes for the action button
    ],
    'View' => [
    ['view/%s', 'id'],
    'view bg-green'
    ],
  ]){
  ?>
      <tbody>
        <?php foreach($row_data as $row):?>
          <tr>
            <?php foreach($columns as $column): ?>
              <td>
                <?= $row[$column] ?>
              </td>
            <?php endforeach; ?>
            <?php if($actions): ?>
              <td>
                <div class="btn-column">
             <?php foreach($action_funcs as $name => $func):
                // Converting each index to use referenced column's value
                for($i = 1;$i < count($func[0]);++$i){
                  $func[0][$i] = $row[$func[0][$i]];
                }
                // Embedding the intended value to the href string
                $href = call_user_func_array('sprintf',$func[0]);
              ?>
                  <a href="<?= $href ?>" class="btn <?= $func[1] ?>"><?= $name ?></a>
            <?php endforeach;?>
                </div>
              </td>
              
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
 <?php }

}