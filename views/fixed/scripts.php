<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="assets/js/main.js"></script>
        <?php
            if(isset($_GET['page'])) {
                switch($_GET['page']) {
                    case 'messages':
                        echo('<script src="assets/js/messages.js"></script>');
                        break;
                }
            }
        ?>
    </body>
</html>