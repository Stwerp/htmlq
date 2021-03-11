/**
This PHP script takes the results of the survey and writes it into a CSV file.

Change in settings/config.xml the following:

    <!-- URL for data transmission via POST/GET (leave blank if not required) -->
    <item id="submitUrl">src/save_as_csv.php</item>
    <!-- request mode (post|get) -->
    <item id="submitUrlMethod">get</item>

You will find the generate CSV file in the folder OUTPUT. Simply move or delete the file if you
would like to start a new survey.

@author Paul Spiesberger - no warrenty for any dataloss or other harm.

 */
<?php

$filePath = "../OUTPUT/survey_results.csv";

createDir("../OUTPUT/"); // create director if it doesn't exist yet

$csvFile = fopen($filePath, "a") or die("Unable to open file!");

if (filesize($filePath) == 0) {
    // adding headers  
    $headers = array("name", "uuid", "comment1", "comment2", "comment3", "comment4", "comment5", "comment6", "comment7", "comment8", "comment9", "comment10", "comment11", "comment12", "comment13", "comment14", "datetime", "dur0", "dur1", "dur2", "dur3", "dur4", "dur5", "form0", "form1", "form2", "form3", "nneg", "nneu", "npos", "sort");
    fputcsv($csvFile, $headers);
}

$data = array(
    htmlspecialchars($_GET["name"]), 
    uniqid(), // generate random UUID
    htmlspecialchars($_GET["comment1"]), 
    htmlspecialchars($_GET["comment2"]), 
    htmlspecialchars($_GET["comment3"]), 
    htmlspecialchars($_GET["comment4"]), 
    htmlspecialchars($_GET["comment5"]), 
    htmlspecialchars($_GET["comment6"]), 
    htmlspecialchars($_GET["comment7"]), 
    htmlspecialchars($_GET["comment8"]), 
    htmlspecialchars($_GET["comment9"]), 
    htmlspecialchars($_GET["comment10"]), 
    htmlspecialchars($_GET["comment11"]), 
    htmlspecialchars($_GET["comment12"]), 
    htmlspecialchars($_GET["comment13"]), 
    htmlspecialchars($_GET["comment14"]), 
    htmlspecialchars($_GET["datetime"]), 
    htmlspecialchars($_GET["dur0"]), 
    htmlspecialchars($_GET["dur1"]), 
    htmlspecialchars($_GET["dur2"]), 
    htmlspecialchars($_GET["dur3"]), 
    htmlspecialchars($_GET["dur4"]), 
    htmlspecialchars($_GET["dur5"]), 
    htmlspecialchars($_GET["form0"]), 
    htmlspecialchars($_GET["form1"]), 
    htmlspecialchars($_GET["form2"]), 
    htmlspecialchars($_GET["form3"]), 
    htmlspecialchars($_GET["nneg"]), 
    htmlspecialchars($_GET["nneu"]), 
    htmlspecialchars($_GET["npos"]), 
    htmlspecialchars($_GET["sort"])
);

fputcsv($csvFile, $data);

fclose($csvFile); // Closing file

function createDir($path, $mode = 0777, $recursive = true) {
    if(file_exists($path)) return true;
    return mkdir($path, $mode, $recursive);
}

?>