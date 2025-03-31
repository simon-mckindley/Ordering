<?php
$list = [];
$heading = "";

if (!empty($_GET["list-option"])) {
    switch ($_GET["list-option"]) {
        case "numbers1-30": {
                $list = range(1, 30);
                $heading = "Numbers 1 - 30";
                break;
            }
        case "reverseNumbers": {
                $list = range(30, 1);
                $heading = "Reverse Numbers 30 - 1";
                break;
            }
        case "reverseAlpha": {
                $list = range("Z", "A");
                $heading = "Reverse Alphabet";
                break;
            }
        case "lowerCase": {
                $list = range("a", "z");
                $heading = "Alphabet - Lower Case";
                break;
            }
        case "custom": {
                $heading = "Custom Numbers";
                break;
            }
        default: {
                $list = range("A", "Z");
                $heading = "Alphabet - Upper Case";
            }
    }
} elseif (!empty($_GET["custom-option"])) {
    $custom = $_GET["custom-option"];
    $list = range($custom, ($custom * 30), $custom);
    $heading = "Numbers by $custom";
} else {
    $list = range("A", "Z");
    $heading = "Welcome to Ordering";
}

$shuffledArr = $list;
shuffle($shuffledArr);

function displayResult()
{
    global $list;
    foreach ($list as $value) {
        echo "\t<div id='result$value' class='value result-value'>\n";
        echo "\t\t<span>$value</span>\n";
        echo "\t</div>\n";
    }
}

function displayShuffle()
{
    global $shuffledArr;
    foreach ($shuffledArr as $value) {
        echo "\t<button id='choice$value' type='button' class='value choice-value' onclick='onChoice(\"$value\")'>$value</button>\n";
    }
}

function displayCustom()
{
    echo <<< "OUTPUT"
    <form id="custom-form" method="get">
        <select name="custom-option" id="custom-list" onchange="this.form.submit()">
            <option value="">--Choose a Number--</option>
            <option value="2">2</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </form>\n
OUTPUT;
}

function php2js($arr, $arrName)   /// General function for converting a PHP array to a JS version
{
    $arrJSON = json_encode($arr, JSON_PRETTY_PRINT);
    echo <<<"CDATA"
  <script>
    /* Variable generated with Trev's handy php2js() function */
    var $arrName = $arrJSON;
  </script>\n
CDATA;
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Simon Mckindley">
    <meta name="description" content="A Bit of Fun">
    <meta http-equiv="X-Frame-Options" content="deny">
    <title>Ordering</title>
    <link rel="icon" href='https://previews.123rf.com/images/conceptw/conceptw1702/conceptw170200026/72327976-abc-%E3%82%A2%E3%83%AB%E3%83%95%E3%82%A1%E3%83%99%E3%83%83%E3%83%88%E6%96%87%E5%AD%97-3-d-%E3%81%AE%E3%83%AC%E3%83%B3%E3%83%80%E3%83%AA%E3%83%B3%E3%82%B0%E3%81%AE%E8%89%B2.jpg?fj=1' type="image/x-icon">
    <link id='stylecss' type="text/css" rel="stylesheet" href="style.css?t=<?= filemtime("style.css"); ?>">

    <?= php2js($list, 'listJS') ?>

    <script>
        var index = 0;
        var nextValue = listJS[index];
        var lastIndex = listJS.length - 1;
        console.log("Index:", index);
        console.log("NextValue:", nextValue);

        function onChoice(choice) {
            console.log("Choice:", choice);
            let choice_els = document.getElementsByClassName("choice-value");
            for (let i = 0; i < choice_els.length; i++) {
                choice_els[i].style.borderColor = "black";
            }
            if (choice == nextValue) {
                if (index > 0) {
                    document.getElementById("result" + listJS[index - 1]).style.borderColor = "black";
                }
                document.getElementById("result" + choice).style.display = "flex";
                document.getElementById("result" + choice).style.borderColor = "#0044bd";
                document.getElementById("choice" + choice).style.display = "none";
                if (index == lastIndex) {
                    alert("Task completed.\nWell done!!");
                } else {
                    index++;
                    nextValue = listJS[index];
                }
            } else {
                document.getElementById("choice" + choice).style.borderColor = "red";
            }
        }
    </script>
</head>

<body>
    <header>
        <h1><?= $heading ?></h1>
        <div id="forms">
            <form id="list-form" method="get">
                <label for="order-list">Choose something:</label>
                <select name="list-option" id="order-list" onchange="this.form.submit()">
                    <option value="">--Choose an Option--</option>
                    <option value="alpha">Alphabet-Upper Case</option>
                    <option value="lowerCase">Alphabet-Lower Case</option>
                    <option value="reverseAlpha">Reverse Alphabet</option>
                    <option value="numbers1-30">Numbers 1 - 30</option>
                    <option value="reverseNumbers">Reverse Numbers</option>
                    <option value="custom">Custom Numbers</option>
                </select>
            </form>
            <?php
            if (!empty($_GET["list-option"] == "custom")) {
                displayCustom();
            }
            ?>
        </div>
    </header>

    <div id="result" class="outer">
        <?= displayResult() ?>
    </div>

    <h2>Choose:</h2>
    <div id="choice" class="outer">
        <?= displayShuffle() ?>
    </div>

</body>