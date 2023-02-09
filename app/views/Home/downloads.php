<div class="download-page">
    <div class="left-download-page-content">
        <div class="emergency-numbers">
            <a href="#"><h3>Emergency Numbers</h3></a>
            <hr>
            <a href="#"><p class="emergency-item">Fire & Rescue / Ambulance</p></a>
            <a href="#"><p class="emergency-item">Other Emergency Numbers</p></a>
        </div>
    </div>

    <div class="download-page-content">
        <h2 class="download-topic">Downloads</h2>
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