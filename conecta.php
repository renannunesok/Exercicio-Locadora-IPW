<?php

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $db ="locadora";

    $conecta = @mysql_connect($servidor,$usuario,$senha)
                or die ("<div class='red'>Erro na conexão com o banco de dados. Por favor contate o DBA.</div>");

    //Somente se Conectar, seleciona o DB
    if ($conecta){

        $seleciona = @mysql_select_db($db,$conecta)
                     or die ("<div class='red'>Erro na conexão com o banco de dados. Por favor contate o DBA.</div>");

        mysql_query("SET NAMES 'utf8'");
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');

    }

?>
