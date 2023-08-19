<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
    </body>
</html>
