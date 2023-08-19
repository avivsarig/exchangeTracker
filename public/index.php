<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Exchange Tracker</title>
    </head>
    <body>
        <h1>Exchange Tracker</h1>
        <form action="../src/api.php" method="get">
            <label for="currency">Currency:</label>
            <select name="currency">
                <option value="usd">USD</option>
                <option value="eur">EUR</option>
                <option value="gbp">GBP</option>
            </select>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date">
            <button type="submit">Fetch Data</button>
        </form>
        <div id="response"></div>

        <script>
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault(); 
                var formData = new FormData(this);

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '../src/api.php?' + new URLSearchParams(formData).toString());

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        document.getElementById('response').innerHTML = '<p>' + xhr.responseText + '</p>';
                    } else {
                        document.getElementById('response').innerHTML = '<p>Error fetching data</p>';
                    }
                };

                xhr.onerror = function() {
                    document.getElementById('response').innerHTML = '<p>Connection error</p>';
                };

                xhr.send();
            });
        </script>
        
    </body>
</html>
