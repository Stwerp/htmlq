<?php
/**
  * This PHP script takes the results of the survey and writes it into a CSV file.
  *
  * Change in settings/config.xml the following:
  *
  *   <!-- URL for data transmission via POST/GET (leave blank if not required) -->
  *   <item id="submitUrl">src/save_as_csv.php</item>
  *   <!-- request mode (post|get) -->
  *   <item id="submitUrlMethod">get</item>
  *
  * You will find the generate CSV file in the folder OUTPUT. Simply move or delete the file if you
  * would like to start a new survey.
  *
  * @author Paul Spiesberger - no warrenty for any dataloss or other harm.
 */

$filePath = "../OUTPUT/survey_results.csv";

createDir("../OUTPUT/"); // create directory if it doesn't exist yet

$csvFile = fopen($filePath, "a") or die("Unable to open file!");

// Extract comments
$comments = array();
$commentHeaders = array();

for ($x = 0; $x <= 10000; $x++) {
    $key = "comment" . $x;

    if(isset($_GET[$key])) {
        $comments[] = htmlspecialchars($_GET[$key]);
        $commentHeaders[] = "comment" . sizeof($commentHeaders);
    }
}

// Extract Forms
$forms = array();
$formHeaders = array();

for ($x = 0; $x <= 10000; $x++) {
    $key = "form" . $x;

    if(isset($_GET[$key])) {
        $forms[] = htmlspecialchars($_GET[$key]);
        $formHeaders[] = $key;
    }
}

// Extract Durations
$durations = array();
$durationHeaders = array();

for ($x = 0; $x <= 10000; $x++) {
    $key = "dur" . $x;

    if(isset($_GET[$key])) {
        $durations[] = htmlspecialchars($_GET[$key]);
        $durationHeaders[] = $key;
    }
}

// Adding headers  
if (filesize($filePath) == 0) {
    
    $headers = array("uuid", "name", "datetime", "nneg", "nneu", "npos", "sort");
    $headers = array_merge($headers, $commentHeaders, $formHeaders, $durationHeaders);
    fputcsv($csvFile, $headers);
}

// Create Data Arrays
$data = array_merge(array(
    uniqid(), // generate random UUID
    htmlspecialchars($_GET["name"]), 
    htmlspecialchars($_GET["datetime"]), 
    htmlspecialchars($_GET["nneg"]), 
    htmlspecialchars($_GET["nneu"]), 
    htmlspecialchars($_GET["npos"]), 
    htmlspecialchars($_GET["sort"])
), $comments, $forms, $durations);

fputcsv($csvFile, $data); // Write data

fclose($csvFile); // Closing file

function createDir($path, $mode = 0777, $recursive = true) {
    if(file_exists($path)) return true;
    return mkdir($path, $mode, $recursive);
}
?>