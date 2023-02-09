<div class="content">
    <h2>
        Pagination Test
    </h2>
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>address</th>
            <th>age</th>
        </tr>
        <?php
        $table = $data['test'];
        if (!$table['error'] && !$table['nodata']) :
            foreach ($table['result'] as $row) : ?>
                <tr>
                    <td>
                        <?= $row['id'] ?>
                    </td>
                    <td>
                        <?= $row['name'] ?>
                    </td>
                    <td>
                        <?= $row['address'] ?>
                    </td>
                    <td>
                        <?= $row['age'] ?>
                    </td>
                </tr>
            <?php endforeach;
        else :  ?>
            <tr>
                <td colspan="2">No Data</td>
            </tr>
        <?php endif; ?>

    </table>
    <?php
    $size = $table['page'][1];
    $max = $table['count'];
    $page_count = ceil($max / $size); ?>

    <script>
        const changePage = () => {
            document.getElementById("pageForm").submit();
        }
    </script>
    <form action="<?= URLROOT . "/References/Pagination" ?>" method="get" id="pageForm">
        <?php
        if ($page_count > 4) : ?>
            <a href="<?= URLROOT . "/References/Pagination?page=0&size=$size" ?>">1</a>
            <a href="<?= URLROOT . "/References/Pagination?page=1&size=$size" ?>">2</a>
            <select name="page" onchange="changePage()" id="page">
                <?php
                $i = 0;
                for (; $i * $size < $max; $i++) : ?>
                    <option value="<?= $i ?>" <?php if ($i == $table['page'][0] / $size) echo "selected" ?>><?= $i + 1 ?></option>
                <?php endfor ?>
            </select>
            <a href="<?= URLROOT . "/References/Pagination?page=" . ($page_count - 2) . "&size=$size" ?>"><?= $page_count - 1 ?></a>
            <a href="<?= URLROOT . "/References/Pagination?page=" . ($page_count - 1) . "&size=$size" ?>"><?= $page_count ?></a>
            <?php else :
            for ($i = 0; $i * $size < $max; $i++) : ?>
                <a href="<?= URLROOT . "/References/Pagination?page=$i&size=$size" ?>"><?= $i + 1 ?></a>
        <?php
            endfor;
        endif; ?>
        No.of Rows : <select name="size" onchange="changePage()" id="size">
            <?php foreach ([10, 25, 50, 100] as $page_size) : ?>
                <option value="<?= $page_size ?>" <?php if ($page_size == $size) echo "selected" ?>><?= $page_size ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>