<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Locadora: Listagem De Clientes</title>
    <link rel="stylesheet" type="text/css" href="css/general.css" media="all" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
        $(function($){
	        //quando o link for clicado
	        $("#mais").click(function(){
		        //recuperar o id do ultimo registro carregado na pagina
		        var ultimo = $("#registros td:last").attr("lang");
		        //mensagem de carregamento
		        $("#status").html('<p>Carregando...</p>');
		        //fazer a requisição via post com ajax
		        $.post("recuperar.php", {ultimo: ultimo}, function(valor){
			        //ocultar a mensagem de carregamento
			        $("#status").empty();
			        //coloca os registros na tabela
			        $("#registros").append(valor);
		        });
	        });
        });
    </script>
</head>
<body>
    <div id="container">
        <section id="listCli">
            <h2>Listagem de Clientes Cadastrados</h2>
            <table id="registros">
                <tr>
                    <td class="Tabletitle">Nome</td>
                    <td class="Tabletitle">Data Nascimento</td>
                    <td class="Tabletitle">CPF</td>
                    <td class="Tabletitle">TELEFONE</td>
                    <td class="Tabletitle">Excluir</td>
                    <td class="Tabletitle">Alterar</td>
                </tr>
                    <?php
                        require_once ("conecta.php");
                        require_once("functions/dateformat.func.php");
                        /*****************************************************************************************
                         *                                                                                       *
                         *   Rotina para deletar clientes cadastrados                                            *
                         *                                                                                       *
                         *****************************************************************************************/
                         if(isset($_GET['deletar']) && $_GET['deletar'] == 'yes'){

                            $id    = mysql_real_escape_string((int)$_GET['id']);
                            $sql   = "DELETE FROM clientes WHERE id = '$id'";
                            $query = @mysql_query($sql) or die('Erro');
                            $rows  = @mysql_affected_rows();
                            if($rows >= 1){
                                echo '<script type="text/javascript">alert("(!) Cliente excluído com sucesso!")</script>';
                            }

                         } //Fim Rotina Deletar

                        /*****************************************************************************************
                         *                                                                                       *
                         *   Rotina para listar clientes cadastrados                                             *
                         *                                                                                       *
                         *****************************************************************************************/

                        $sql   = "SELECT * FROM clientes ORDER BY id DESC LIMIT 0,2";
                        $query = @mysql_query($sql) or die ("Erro");

                        //Se o número de registros no banco é maior que 0, então enquanto encontrar resultados faz a listagem
                        if(mysql_num_rows($query) > 0){

                            while($row = mysql_fetch_array($query)){

                    ?>

                <tr>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo trataData3($row[2]); ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                    <td><a href="?deletar=yes&id=<?php echo $row[0];?>" title="Excluir <?php echo $row[1]; ?>">(X) Excluir</a></td>
                    <td lang="<?php echo $row[0] ?>">
                        <a href="cadastrar.php?alterar=yes&id=<?php echo $row[0];?>" title="Alterar <?php echo $row[1];?>">
                        (+) Alterar
                    </td>
                </tr>

                    <?php
                            }//endwhile

                        }else{
                            echo "<h3 class='red'>(!) Ops...Não existe clientes cadastrados.</h3>";
                        }//Fim Rotina Listar

                    ?>
            </table>
            <span id="status"></span>
            <a href="#" id="mais">Mostrar Mais Registros &raquo;</a>
        </section>
    </div>
</body>
</html>
