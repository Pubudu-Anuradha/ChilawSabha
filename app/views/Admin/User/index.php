<div class="content">
<?php
$page_title = "User Management";
echo '<h2 class="analytics-topic">'. $page_title . '</h2> <hr />';
$table = $data['Users'];
$roles = $data['roles'] ?? [];
$user_disabled = $data['disabled']['result'][0]?? false;
$roles_assoc = [];
foreach($roles as $role) {
    $roles_assoc[''.$role['staff_type_id']] = $role['staff_type'];   
}

Pagination::top('/Admin/Users',select_filters:[
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

if($data['self_disable_error'] ?? false) {
    $message = '<b>You are not allowed to disable yourself</b>';
    Errors::generic($message);
}

if($user_disabled !== false){
    $message = '<b>' . $user_disabled['name'] . '(' . $user_disabled['email'] .
               ')</b> was disabled.';
    Errors::generic($message);
}

Table::Table($aliases,$table['result'],id:"pdf",actions:[
    'Edit' => [[URLROOT . '/Admin/Users/Edit/%s', 'user_id'],'bg-yellow edit'],    
    'Disable' => [[URLROOT . '/Admin/Users/Disable/%s', 'user_id'],'bg-red delist'],    
],empty:count($table['result']??[])==0,empty_msg:'No matching users found'); 

Pagination::bottom('filter-form', $data['Users']['page'], $data['Users']['count']); ?>

    <input type="button" onclick="generate('#pdf','<?php echo $page_title ?>',6)" value="Export To PDF" class="btn bg-green"/>

</div>
<script>
    expandSideBar('sub-items-user');
</script>

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