<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exchange Tracker</title>
    </head>
    <body>
        <h1>Exchange Tracker</h1>
        <?php
            require_once('../config.php');
            require('../src/db_conn.php');

            // Start output buffering
            ob_start();

            // End output buffering
            ob_end_flush();
        ?>
    </body>
</html>
