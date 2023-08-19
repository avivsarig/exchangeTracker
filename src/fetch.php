<?php
error_log("Fetching data");

function fetchDataFunc($conn, $url, $tableName) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($curl);
    curl_close($curl);

    if (!$resp) {
        error_log("Failed to fetch the content from URL");
        return [];
    }
    
    $matches = [];
    preg_match_all('/<Obs TIME_PERIOD="(\d{4}-\d{2}-\d{2})" OBS_VALUE="([\d.]+)" RELEASE_STATUS="YP"><\/Obs>/', $resp, $matches);

    if (empty($matches[1]) || empty($matches[2])) {
        error_log("No matches found");
        return [];
    }
    
    mysqli_query($conn, "TRUNCATE TABLE `exchangeTracker`.`$tableName`");

    $stmt = $conn->prepare("INSERT INTO $tableName (time_period, obs_value, status) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($matches[1]); $i++) {
        $time_period = $matches[1][$i];
        $obs_value = $matches[2][$i];

        // Bind parameters and execute the prepared statement
        $stmt->bind_param("sds", $time_period, $obs_value, $status);
        $stmt->execute();
    }

    $stmt->close();
}

fetchDataFunc($conn, URL_USD, 'usd_rates');
fetchDataFunc($conn, URL_EUR, 'eur_rates');
fetchDataFunc($conn, URL_GBP, 'gbp_rates');
?>
