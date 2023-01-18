<?php
error_reporting(0);

function exit_and_close($message)
{
    echo '<script>alert("' . htmlentities($message, ENT_QUOTES, 'utf-8') . '"); window.close()</script>';
    exit();
}

require 'vendor/autoload.php';

if (empty($_POST)) {
    exit_and_close("No has enviado ni un solo dato");
}

$_POST['words'] = trim($_POST['words']);
if (empty($_POST['words'])) {
    exit_and_close("No has enviado la lista de palabras");
}

if (empty($_POST['size'])) {
    exit_and_close("No has enviado el tamaño");
}

$size = (int) $_POST['size'];
if ($size < 6 || $size > 26) {
    exit_and_close("El tamaño debe estar entre 6 y 26");
}

$include_direction_help = isset($_POST['include_direction_help']);

// analizar words
$words = [];
$post_words = explode("\n", $_POST['words']);
foreach ($post_words as $post_word) {
    $words[] = trim($post_word);
}

foreach ($words as $key => $word) {
    $words[$key] = \WordSearch\Utils::uppercaseString($word);
}

$puzzle = \WordSearch\Factory::create($words, $size, 'es');
$transformer = new \WordSearch\Transformer\HtmlTransformer($puzzle);
$syllabler_library_dir = __DIR__ . '/PHP-Syllabler/library';

set_include_path(get_include_path() . PATH_SEPARATOR . $syllabler_library_dir);
require_once $syllabler_library_dir . '/Fwok/Word/Syllabler/Spanish.php';

function silabas($word)
{
    $manual = explode(',', $word);
    if (count($manual) == 1) {
        //Example configuration
        Fwok_Word_Syllabler_Spanish::setSpain(true);
        Fwok_Word_Syllabler_Spanish::setTl(false);
        Fwok_Word_Syllabler_Spanish::setIgnorePrefix(true); //The all prefixes isn't supported by the moment
        //Fwok_Word_Syllabler_Spanish::setLogger($logger); //Logger
        $w = new Fwok_Word_Syllabler_Spanish($word);
        return $w->getSyllables();
    } else {
        return $manual;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sopa de letras</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    echo $transformer->grid();
    // echo $transformer->wordList();
    echo '<div class="wordlist">';
    foreach ($words as $word) {
        $silabas = silabas($word);
        echo '<div class="word">';
        echo '<div class="palabra">';
            echo implode('', explode(',', $word));
            if ($include_direction_help) {
                $dir = $puzzle->directions[$word];
                echo '<img src="img/' . $dir . '.svg" width="16" alt="" />';
            }
        echo '</div>';
        echo '<div class="silaba">';
        foreach ($silabas as $silaba) {
            echo '<span>';
            echo \WordSearch\Utils::uppercaseString($silaba);
            echo '</span>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    ?>
</body>

</html>