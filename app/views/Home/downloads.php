<div class="download-page">
    <div class="download-page-content">
        <h2 class="download-topic">Downloads</h2>
        <!-- To do - need to add real documents here -->
        <div>
            <div class="download-accordin">Forms</div>
            <div class="panel">
                <ul>
                    <li><a href="#" class="download-link">Document 01</a></li>
                    <li><a href="#" class="download-link">Document 02</a></li>
                    <li><a href="#" class="download-link">Document 03</a></li>
                </ul>
            </div>
        </div>
        <div>
            <div class="download-accordin">Acts and Circulars</div>
            <div class="panel">
                <ul>
                    <li><a href="#" class="download-link">Document 01</a></li>
                    <li><a href="#" class="download-link">Document 02</a></li>
                    <li><a href="#" class="download-link">Document 03</a></li>
                </ul>
            </div>
        </div>
        <div>
            <div class="download-accordin">Gazettes</div>
            <div class="panel">
                <ul>
                    <li><a href="#" class="download-link">Document 01</a></li>
                    <li><a href="#" class="download-link">Document 02</a></li>
                    <li><a href="#" class="download-link">Document 03</a></li>
                </ul>
            </div>
        </div>
        <div>
            <div class="download-accordin">Tender Notices</div>
            <div class="panel">
                <ul>
                    <li><a href="#" class="download-link">Document 01</a></li>
                    <li><a href="#" class="download-link">Document 02</a></li>
                    <li><a href="#" class="download-link">Document 03</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    var acc = document.getElementsByClassName("download-accordin");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            var panel = this.nextElementSibling
            if (panel.style.display === "block") {
                panel.style.display = "none";
            }
            else {
                panel.style.display = "block";
            }
        });
    }
</script>