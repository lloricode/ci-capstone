<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Maintenance</title>

        <style>
            body {
                width:500px;
                margin:0 auto;
                text-align: center;
                color:#970001;
            }
        </style>
    </head>

    <body>

<!--        <img src="images/home_page_logo.png">-->

        <h1><p>Sorry for the inconvenience while we are temporarily unavailable. </p>
            <p>Please revisit shortly</p>
        </h1>
        <div></div>

<!--        <img src="images/under-maintenance.gif"   >-->

    </body>
</html>
<?php
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 3600');
?>