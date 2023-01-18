<!DOCTYPE html>
<html class="no-js" lang="">

<head>
    <meta charset="UTF-8">
    <title>Generador de sopa de letras</title>
    <meta name="description" content="Generador de sopa de letras">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="Generador de sopa de letras">
    <meta property="og:type" content="post">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <h1>Generador de sopa de letras</h1>
    <form method="post" action="generator.php" target="_blank">
        <p>
            <label>
                <strong>Tamaño</strong>
                <input type="number" name="size" value="12" step="1" min="6" max="26" />
            </label>
        </p>


        <label><strong>Palabras</strong></label>
        <p>
            Escriba una palabra por línea.<br>
            Si la separación de una palabra es incorrecta puede indicar la separación de sílabas manualmente utilizando comas, por ejemplo:
            <code>chan,cho</code>
        </p>
        <textarea id="palabras" style="display: block; height: 15em;" cols="60" name="words" required></textarea>
        <p>Número de líneas: <span id="lines_count">0</span></p>
        <script>
            (function() {
                let ta = document.getElementById('palabras');
                let lc = document.getElementById("lines_count");

                function contar_lineas() {
                    let lines = ta.value.split("\n");
                    lc.innerText = lines.length;
                }

                ta.addEventListener('input', function(ev) {
                    contar_lineas();
                });
            })();
        </script>

        <label>
            <input type="checkbox" name="include_direction_help" />
            Incluir ayuda de dirección de cada palabra
        </label>
        <p>
            <button type="submit">Enviar</button>
        </p>

    </form>
    <?php
    // put your code here
    ?>
</body>

</html>