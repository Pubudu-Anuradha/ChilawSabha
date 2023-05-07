<div class="content">
    <h1>
        Manage Events
    </h1>
    <div class="btn-column">
        <a href="<?= URLROOT . '/Admin/Events/Add' ?>" class="btn add bg-green">Add a new Event</a>
    </div>
    <hr>
<?php
Pagination::top('/Admin/Events', form_id:'event-table-filter', select_filters:[
    'status' => [
        'Filter by project status', [
            '0' => 'All',
        ],
    ],
    'hidden' => [
        'Filter by visibility', [
            2 => 'All',
            0 => 'visible',
            1 => 'hidden',
        ],
    ],
    'pinned' => [
        'Filter Pinned events', [
            2 => 'All',
            0 => 'not pinned',
            1 => 'pinned',
        ],
    ],
    'sort' => [
        'Posted time' , [
            'DESC' => 'Newest to Oldest',
            'ASC' => 'Oldest to Newest'
        ]
    ]
]);

Table::Table(['title' => 'Event Title','views'=>'Views', 'posted_time' => 'Time posted' ], $data['events'][0]['result'] ?? [], actions:[
    'View' => [[URLROOT . '/Admin/Events/View/%s', 'post_id'], 'bg-blue view'],
    'Edit' => [[URLROOT . '/Admin/Events/Edit/%s', 'post_id'], 'bg-yellow edit'],
], empty:!(count($data['events'][0]['result']) > 0), empty_msg:'No events available');

Pagination::bottom(
    form_id:'event-table-filter',
    page_data:$data['events'][0]['page'],
    count:$data['events'][0]['count'],
);
?>
</div>


<script>
    const events = <?=json_encode($data['events'][0]['result'] ?? []);?>;
    if(events.length != 0) {
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
            let result = events[i++];

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
            hidden.cell.style.textAlign = 'center';

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
            pinned.cell.style.textAlign = 'center';

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
                    if(response.success !== true) {
                        e.target.checked = e.target.checked ? false : true;
                    }
                    pinned.box.disabled = false;
                }).catch(console.log);
            });
        });
    }
</script>