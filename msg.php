<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup</title>
    <link rel="stylesheet" href="msg/msg.css">
</head> 
 
<body>
    <div class="container">
        <div class="popup">
            <img src="img/success.png">
            <h2>Success</h2>
            <p>successfully</p>
            <button type="button" id="okButton">OK</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script>
        $('#okButton').click(function() {
            window.location.href = 'list_of_customers.php';
        });
    </script>
</body>

</html>
