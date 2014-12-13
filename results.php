<html>
    <head>
        <title>El Pacto Mejores Puntajes Resultados</title>
    </head>
    <body>
        <h1>El Pacto Mejores Puntajes Resultados</h1>
        <?php
        // create short variable names
        $selectedlvl = $_POST['selectedlvl'];
        if (!$selectedlvl) {
            echo 'You have not entered search details, duh.  Please go back and try again.';
        }

        if (!get_magic_quotes_gpc()) {
            $selectedlvl = addslashes($selectedlvl);
        }

        @ $db = new mysqli('localhost', 'el_pacto_game', 'pactoadmin', 'pactoadmin');



        ?>
    </body>
</html>