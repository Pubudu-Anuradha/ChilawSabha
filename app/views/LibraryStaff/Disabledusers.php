<div class="content">

    <?php
        $table = $data['Users'];
        $enable_error = $data['enable_error'] ?? false;
    ?>

    <div class="page">
        <div class="title">
            <?php $page_title = "DISABLED USERS";
            echo '<h2>' . $page_title . '</h2>';
            ?>
            <input type="button" onclick="generate('#disabledLibUser','<?php echo $page_title ?>',5)" value="Export To PDF" class="btn bg-lightblue white"/>
        </div>
    </div>

    <?php Pagination::Top('/LibraryStaff/Disabledusers', select_filters:[]);?>

    <?php $aliases = [
        'membership_id'=>'Membership ID',
        'email' => 'Email',
        'name' => 'Name',
        'address' => 'Address',
        'contact_no' => 'Contact number',
        'nic' => 'NIC number',
        'disable_description' => 'Disable Reason'
    ];

    if($enable_error) {
        $message = "There was an error while enabling user";
        Errors::generic($message);
    }

    Table::Table($aliases,
        $table['result'],'disabledLibUser',
        actions:[
            'Enable'=>[['#'],'btn enable bg-green white',["openModal(%s,'enable_description')",'membership_id']]
        ],empty:$table['nodata'],empty_msg:'No Disabled User Found'

    );?>

    <?php Modal::Modal(textarea:true, title:"Reason For Enabling",name:'enable_description',id:'enable_description', rows:10, cols:50,required:true,textTitle:'Membership ID',textId:'enabled_member_ID');?>
        
    <?php Pagination::bottom('filter-form',$data['Users']['page'],$data['Users']['count']);?>

</div>

<script>
    expandSideBar("sub-items-user","see-more-usr");
    var openedModal;

    function closeModal(){
        openedModal.style.display = "none";
    }
    function openModal(id,modal){
        event.preventDefault();
        openedModal = document.getElementById(modal);
        openedModal.querySelector('input[type="number"]').value = id;
        openedModal.style.display = "block";

        window.onclick = function(event) {
            if (event.target == openedModal) {
                openedModal.style.display = "none";
            }
        }
    }

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