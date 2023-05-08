<!-- <div class="content">
    <h1>
        Disabled User Management
    </h1>
    <hr>
    <?php
    // $table = $data['Users'];
    ?>
</div> -->
<div class="content">
<?php
$page_title = "Disabled User Management";
echo '<h2 class="analytics-topic">'. $page_title . '</h2> <hr />';
$table = $data['Users'];
$roles = $data['roles'] ?? [];
$user_enabled = $data['enabled']['result'][0]?? false;
$roles_assoc = [];
foreach($roles as $role) {
    $roles_assoc[''.$role['staff_type_id']] = $role['staff_type'];   
}

Pagination::top('/Admin/Users/Disabled',select_filters:[
        'role' => ['Filter by Role',$roles_assoc]
]);

$aliases = [
    'email' => 'Email',
    'name' => 'Name',
    'address' => 'Address',
    'contact_no' => 'Contact number',
    'nic' => 'NIC number',
    'role' => 'User Role'
];

if($user_enabled !== false):
    $message = '<b>' . $user_enabled['name'] . '(' . $user_enabled['email'] .
               ')</b> was re-enabled.'; ?>
    <div class="success"><?= $message ?></div>
<?php endif;

Table::Table($aliases,$table['result'],actions:[
    'Re-enable' => [[URLROOT . '/Admin/Users/Enable/%s', 'user_id'],'bg-green enable',['#']],    
    'View' => [[URLROOT . '/Admin/Users/View/%s', 'user_id'],'bg-blue view',['#']],    
],empty:count($table['result'] ?? []) == 0,empty_msg:'No Disabled users found'); 

Pagination::bottom('filter-form', $data['Users']['page'], $data['Users']['count']); ?>

</div>
<script>
    expandSideBar('sub-items-user');
</script>
