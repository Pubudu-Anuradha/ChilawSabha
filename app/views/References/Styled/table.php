<div class="content">
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Accestion number</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0;$i<5;++$i):?>
                <tr>
                    <td>P305</td>
                    <td>Harry Potter</td>
                    <td>J.K. Rowling</td>
                    <td>Animus Klado</td>
                    <td>
                        <div  class="btn-column">
                            <button class="btn bg-yellow">
                               <span class="edit">
                                    Edit
                               </span>
                            </button>
                            <button class="btn bg-orange">
                               <span class="lost">
                                    Lost
                               </span>
                            </button>
                            <button class="btn bg-red">
                               <span class="delist">
                                    Delist
                               </span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>A45</td>
                    <td>Atomic Habits</td>
                    <td>James Clear</td>
                    <td>Penguin Random</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn bg-yellow">
                               <span class="edit">
                                    Edit
                               </span>
                            </button>
                            <button class="btn bg-orange">
                               <span class="lost">
                                    Lost
                               </span>
                            </button>
                            <button class="btn bg-red">
                               <span class="delist">
                                    Delist
                               </span>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endfor;?>
            </tbody>
        </table>
    </div>

</div>
