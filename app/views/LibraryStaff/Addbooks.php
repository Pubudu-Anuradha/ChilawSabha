<div class="content">
    <div class="page">
        <h2 class="topic">Add Books</h2>
        <div class="formContainer">
            <form action="<?= URLROOT . "/LibraryStaff/addbooks" ?>" class="fullForm">
                <div class="input-field">
                    <label for="title">Title</label>
                    <div class="input-wrapper">
                        <input type="text" name="title" id="title" maxlength="255" required>
                        <span></span>
                    </div>   
                </div>
                <div class="input-field">
                    <label for="author">Author</label>
                    <div class="input-wrapper">
                        <input type="text" name="author" id="author" maxlength="255" required>
                        <span></span>
                    </div>  
                </div>
                <div class="input-field">
                    <label for="publisher">Publisher</label>
                    <div class="input-wrapper">
                        <input type="text" name="publisher" id="publisher" maxlength="255" required>
                        <span></span>
                    </div>                      
                </div>
                <div class="input-field">
                    <label for="placeofpub">Place of Publication</label>
                    <div class="input-wrapper">
                        <input type="text" name="placeofpub" id="placeofpub" maxlength="255" required>
                        <span></span>
                    </div>                      
                </div>
                <div class="input-field">
                    <label for="dateofpub">Date of Publication</label>
                    <div class="input-wrapper">
                        <input type="date" name="dateofpub" id="dateofpub" max="<?php echo date("Y-m-d"); ?>" required>
                        <span></span>
                    </div>                      
                </div>
                <div class="input-field">
                    <label for="bookcategory">Book Category</label>
                    <div class="input-wrapper">
                        <select name="categoryFill">
                            <option value="Null">Choose Category</option>
                            <option value="Philosophy">Philosophy</option>
                            <option value="Languages">Languages</option>
                            <option value="Natural Sciences">Natural Sciences</option>
                            <option value="Literature">Literature</option>
                        </select>
                        <span></span>
                    </div>                     
                </div>
                <div class="input-field">
                    <label for="accno">Accession No</label>
                    <div class="input-wrapper">
                        <input type="text" name="accno" id="accno" required >
                        <span></span>
                    </div>                     
                </div>
                <div class="input-field">
                    <label for="price">Price</label>
                    <div class="input-wrapper">
                        <input type="number" name="price" id="price" step="0.01" min="0" required>
                        <span></span>
                    </div>  
                </div>
                <div class="input-field">
                    <label for="pages">Pages</label>
                    <div class="input-wrapper">
                        <input type="number" name="pages" id="pages" min="1" required>
                        <span></span>
                    </div>  
                </div>
                <div class="input-field">
                    <label for="recdate">Recieved Date</label>
                    <div class="input-wrapper">
                        <input type="date" name="recdate" id="recdate" max="<?php echo date("Y-m-d"); ?>" required>
                        <span></span>
                    </div>  
                </div>
                <div class="input-field">
                    <label for="recmethod">Recieved Method</label>
                    <div class="input-wrapper">
                        <input type="text" name="recmethod" id="recmethod" maxlength="255" required>
                        <span></span>
                    </div>  
                </div>
                <div class="submitButtonContainer">
                    <div class="submitButton">
                        <input type="submit" name="Submit" value="Add">
                    </div>
                
                </div>
            </form>
        </div>

    </div>
</div>