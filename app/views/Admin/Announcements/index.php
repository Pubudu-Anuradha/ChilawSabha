<?php // TODO: Make table with announcement titles and options 
require_once 'common.php';
?> 

<div class="content">
    <h1>
        Manage Announcements
    </h1>
    <hr>
    <?php
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    $types_assoc = [];
    foreach($data['types'] ?? [] as $type) {
        if($type['ann_type'] !== 'All')
            $types_assoc[$type['ann_type_id']] = $type['ann_type'];
    }
    Pagination::top('/Admin/Announcements',form_id:'ann-table-filter',select_filters:[
        'category' =>[
            'Filter by announcement type' , array_merge(['0' => 'All'] , $types_assoc)
        ],
        'hidden' => [
            'Filter by visibility' , [
                2 => 'All',
                0 => 'visible',
                1 => 'hidden'
            ]
        ],
        'pinned' => [
            'Filter Pinned Announcements' ,[
                2 => 'All',
                0 => 'not pinned',
                1 => 'pinned'
            ]
        ]

    ]);
    Table::Table(['title' => 'Announcement Title','posted_time' => 'Time posted','ann_type'=>'Type'],$data['announcements']['result'] ?? [],actions:[
        'View' => [[URLROOT . '/Admin/Announcements/View/%s','post_id'],'bg-blue view'],
        'Edit' => [[URLROOT . '/Admin/Announcements/Edit/%s','post_id'],'bg-yellow edit'],
    ],empty:!(count($data['announcements']['result']) > 0),empty_msg:'No announcements available');

    Pagination::bottom('ann-table-filter',$data['announcements']['page'],$data['announcements']['count']);
    ?>
    <script>
        const announcements = <?=json_encode($data['announcements']['result'] ?? []);?>;
        if(announcements.length != 0) {
            const table = document.querySelector('table');
            const headerRow = table.querySelector('thead > tr');
            const hiddenColumnHeader = document.createElement('th');
            hiddenColumnHeader.innerHTML = "Hidden"
            const pinnedColumnHeader = document.createElement('th');
            pinnedColumnHeader.innerHTML = "Pinned"
            headerRow.insertBefore(hiddenColumnHeader,headerRow.children[2]);
            headerRow.insertBefore(pinnedColumnHeader,hiddenColumnHeader);

            let i=0;
            table.querySelectorAll('tbody > tr').forEach(row => {
                let result = announcements[i++];

                const hidden = {
                    cell:document.createElement('td'),
                    box:document.createElement('input'),
                };
                hidden.box.type = 'checkbox';
                hidden.box.id = 'hide-unhide-' + result.post_id;
                hidden.box.checked = result.hidden == 1 ? true : false;
                hidden.box.style.height = '1.5rem';
                hidden.box.style.width  = '1.5rem';
                hidden.box.ariaLabel = 'hide or unhide post';
                hidden.cell.appendChild(hidden.box);

                const pinned = {
                    cell:document.createElement('td'),
                    box:document.createElement('input'),
                };
                pinned.box.type = 'checkbox';
                pinned.box.id = 'pin-unpin-' + result.post_id;
                pinned.box.checked = result.pinned == 1 ? true : false;
                pinned.box.style.height = '1.5rem';
                pinned.box.style.width  = '1.5rem';
                pinned.box.ariaLabel = 'pin or unpin post';
                pinned.cell.appendChild(pinned.box);

                row.insertBefore(hidden.cell,row.children[2]);
                row.insertBefore(pinned.cell,hidden.cell);

                hidden.box.addEventListener('change', (e) => {
                    hidden.box.disabled = true;
                    const hide = {
                        hidden:e.target.checked ? 1 : 0
                    };
                    fetch('<?=URLROOT . '/Admin/postsApi/Hide/'?>' + result.post_id, {
                        method:'POST',
                        headers: {
                            "Content-type":"application/json"
                        },
                        body:JSON.stringify(hide)
                    }).then(res => res.json()).then(response => {
                        if(response.success !== true) {
                            e.target.checked = e.target.checked ? false : true;
                        }
                        hidden.box.disabled = false;
                    }).catch(console.log);
                });
                pinned.box.addEventListener('change', (e) => {
                    pinned.box.disabled = true;
                    const pin = {
                        pinned:e.target.checked ? 1 : 0
                    };
                    fetch('<?=URLROOT . '/Admin/postsApi/Pin/'?>' + result.post_id, {
                        method:'POST',
                        headers: {
                            "Content-type":"application/json"
                        },
                        body:JSON.stringify(pin)
                    }).then(res => res.json()).then(response => {
                        console.log(response);
                        if(response.success !== true) {
                            e.target.checked = e.target.checked ? false : true;
                        }
                        pinned.box.disabled = false;
                    }).catch(console.log);
                });
            })
        }
    </script>
</div>