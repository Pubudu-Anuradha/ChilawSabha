<div class="content">
    <h2>
        All Accepted Complaints
    </h2>

    <!-- TODO-> -->
    <?php
    $table = $data['complaints'];
    ?>
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Complaint ID</th>
                    <th>Complainer Name</th>
                    <th>Category</th>
                    <th>Handler Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$table['nodata'] && !$table['error']) :
                    foreach ($table['result'] as $ann) : ?>
                        <tr>
                            <td><?= $ann['id'] ?></td>
                            <td><?= $ann['name'] ?></td>
                            <td><?= $ann['category'] ?></td>
                            <td><?= $ann['author'] ?></td>
                            <td><?= $ann['date'] ?></td>
                            <td><?= $ann['category'] ?></td>
                            <td>
                                <div class="btn-column">
                                    <!-- when click my processing complaint -->
                                    <a class="btn bg-green  view" href="<?= URLROOT . '/Complaint/myProcessingClickedComplaint/' . $ann['id'] ?>">View</a>
                                </div>
                            </td>
                        </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>

</div>