<?php
$alphabet = range("A", "Z");
$shuffledArr = $alphabet;
shuffle($shuffledArr);

function displayResult()
{
    global $alphabet;
    foreach ($alphabet as $letter) {
        echo "\t<div id='result$letter' class='letter result-letter'>\n";
        echo "\t\t<span>$letter</span>\n";
        echo "\t</div>\n";
    }
}

function displayShuffle()
{
    global $shuffledArr;
    foreach ($shuffledArr as $letter) {
        echo "\t<button id='choice$letter' type='button' class='letter choice-letter' onclick='onChoice(\"$letter\")'>$letter</button>\n";
    }
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
    <title>Alphabet</title>
    <link rel="icon" href='https://previews.123rf.com/images/conceptw/conceptw1702/conceptw170200026/72327976-abc-%E3%82%A2%E3%83%AB%E3%83%95%E3%82%A1%E3%83%99%E3%83%83%E3%83%88%E6%96%87%E5%AD%97-3-d-%E3%81%AE%E3%83%AC%E3%83%B3%E3%83%80%E3%83%AA%E3%83%B3%E3%82%B0%E3%81%AE%E8%89%B2.jpg?fj=1' type="image/x-icon">
    <link id='stylecss' type="text/css" rel="stylesheet" href="style.css?t=<?= filemtime("style.css"); ?>">

    <?= php2js($alphabet, 'alphabetJS') ?>

    <script>
        var index = 0;
        var nextLetter = alphabetJS[index];
        console.log("Index:", index);
        console.log("NextLetter:", nextLetter);

        function onChoice(choice) {
            console.log("Choice:", choice);
            let choice_els = document.getElementsByClassName("choice-letter");
            for (let i = 0; i < choice_els.length; i++) {
                choice_els[i].style.borderColor = "black";
            }
            if (choice == nextLetter) {
                if (index > 0) {
                    document.getElementById("result" + alphabetJS[index - 1]).style.borderColor = "black";
                }
                document.getElementById("result" + choice).style.display = "flex";
                document.getElementById("result" + choice).style.borderColor = "#0044bd";
                document.getElementById("choice" + choice).style.display = "none";
                index++;
                nextLetter = alphabetJS[index];
            } else {
                document.getElementById("choice" + choice).style.borderColor = "red";
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Alphabet</h1>
    </header>

    <div id="result" class="outer">
        <?= displayResult() ?>
    </div>

    <h2>Choose:</h2>
    <div id="choice" class="outer">
        <?= displayShuffle() ?>
    </div>

</body>