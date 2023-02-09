<div class="content">
    <h1>
        User Management
    </h1>
    <hr>
    <?php
    $table = $data['Users'];
    $roles = ['All'=>'All','Admin'=>'Administrator','LibraryStaff'=>'Library Staff Member','ComplaintHandler'=>'Complaint Handler'];
    ?>

    <script>
        const send = ()=>{
            document.getElementById('filterform').submit();
        }
    </script>
    <div class="filters">
        <form action="<?=URLROOT . '/Admin/Users'?>" method="get" id="filterform">
            <div class="filter">
                <label for="search">
                    Search
                </label>
                <input class="search" type="search" name="search" id="search" value="<?= isset($_GET['search']) ? $_GET['search']:''?>">
                <span onclick="send()"></span>
            </div>
            <div class="filter">
                <label for="role">
                    Filter by Role
                </label>
                <select onchange="send()" name="role" id="role">
                    <?php foreach ($roles as $role=>$name):?>
                        <option value="<?=$role?>" <?php if(isset($_GET['role']) && $_GET['role']==$role) {echo 'selected';} ?>>
                            <?=$name?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
    </div>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact No.</th>
                    <th>NIC</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!$table['nodata'] && !$table['error']):
                foreach($table['result'] as $user): ?>
                <tr>
                    <td><?= $user['email']?></td>
                    <td><?= $user['name']?></td>
                    <td><?= $user['address']?></td>
                    <td><?= $user['contact_no']?></td>
                    <td><?= $user['nic']?></td>
                    <td><?= $roles[$user['role']]?></td>
                    <td>
                        <div  class="btn-column">
                            <a href="<?=URLROOT . '/Admin/Users/Edit/' . $user['id']?>" class="btn bg-yellow edit"> Edit </a>
                            <a href="<?=URLROOT . '/Admin/Users/Disable/' . $user['id']?>" class="btn bg-red delist"> Disable </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else:?>
                    <tr>
                        <td colspan="8">
                            No matching Users
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="page-nav">
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
    </div>
    </form>
</div>