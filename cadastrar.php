<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Locadora: Cadastro De Clientes</title>
    <link rel="stylesheet" type="text/css" href="css/general.css" media="all" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.idealforms.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
    <div id="container">
        <section id="cadCli">
            <form id="frmCad" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <h2>Cadastro Clientes</h2>
                    <?php
                        /****************************************************************************************
                        *                                                                                       *
                        *   Rotina para validação de dados de entrada e inserção ou alteraração no banco        *
                        *                                                                                       *
                        *****************************************************************************************/
                        require_once ("conecta.php");
                        require_once("functions/dateformat.func.php");
                        require_once("functions/datevalid.func.php");
                        require_once("functions/cpfvalid.func.php");

                        //Validação
                        if(isset($_POST['cadastrar']) && $_POST['cadastrar'] == 'yes'){

                            //Valida Nome. Entre 10 e 50 caracteres
                            $getNome = strip_tags(trim($_POST['nome']));
                            if(strlen($getNome) < 10 || strlen($getNome) > 50){
                                $nome = false;
                            }else{
                                $nome = $getNome;
                            }

                            //Valida Data Nascimento com a função do arquivo: datevalid.func.php
                            $getdtNasc = strip_tags(trim($_POST['dtNasc']));
                            if($getdtNasc != null && validateDate($getdtNasc,'DD/MM/YYYY')){
                                $dtNasc = trataData($getdtNasc);
                            }else{
                                $dtNasc = false;
                            }


                            //Valida CPF com a função do arquivo: cpfvalid.func.php
                            $getCpf = strip_tags(trim($_POST['cpf']));
                            if($getCpf != null && is_numeric($getCpf) && validaCPF($getCpf)){
                                $cpf = $getCpf;
                            }else{
                                $cpf = false;
                            }


                            //Valida Endereço. Entre 8 e 100 caracteres
                            $getEndereco  = strip_tags(trim($_POST['endereco']));
                            if(strlen($getEndereco) < 8 || strlen($getEndereco) > 100){
                                $endereco = false;
                            }else{
                                $endereco = $getEndereco;
                            }

                            //Valida Bairro. Entre 4 e 40 caracteres
                            $getBairro    = strip_tags(trim($_POST['bairro']));
                            if(strlen($getBairro) < 4 || strlen($getEndereco) > 40){
                                $bairro = false;
                            }else{
                                $bairro = $getBairro;
                            }

                            //Valida telefone 13 caracteres (00)0000-0000
                            $getTelefone = strip_tags(trim($_POST['telefone']));
                            if(strlen($getTelefone) != 13){
                                $telefone = false;
                            }else{
                                $telefone = $getTelefone;
                            }

                            //Verifica se passou na validação.Se não retorna o erro
                            if(!$nome){
                                $retorno = "(!) Informe o nome, entre 4 e 50 caracteres.";
                            }else if(!$dtNasc){
                                $retorno = "(!) Informe uma data de nascimento válida.";
                            }else if(!$cpf){
                                $retorno = "(!) Informe um CPF válido.";
                            }else if(!$endereco){
                                $retorno = "(!) Informe o endereço, entre 8 e 100 caracteres.";
                            }else if(!$bairro){
                                $retorno = "(!) Informe o bairro, entre 8 e 40 caracteres.";
                            }else if(!$telefone){
                                $retorno = "(!) Informe um telefone válido.";
                            }

                                //Se não retornou erros e não existir o get alterar insere no banco
                                if(empty($retorno)){
                                    if(!isset($_GET['alterar'])){
                                        $sql   = "INSERT INTO clientes (nome,dtnasc,cpf,endereco,bairro,telefone)
                                                  VALUES ('$nome','$dtNasc','$cpf','$endereco','$bairro','$telefone')";
                                        $query = mysql_query($sql) or die("Erro");

                                        if($query){
                                            echo "<script type='text/javascript'>
                                                    alert('(!) Cliente cadastrado com sucesso!');
                                                    location.href='listar.php'
                                                  </script>";
                                        }
                                    //Se não retornou erros e existir o get alterar faz a atualização no banco
                                    }else if(isset($_GET['alterar']) && $_GET['alterar'] == 'yes'){
                                        $id    = mysql_real_escape_string((int)$_GET['id']);
                                        $sql   = "UPDATE clientes SET nome='$nome',dtnasc='$dtNasc',cpf='$cpf',endereco='$endereco',
                                                                      bairro='$bairro',telefone='$telefone'
                                                 WHERE id='$id'";
                                        $query = @mysql_query($sql) or die('Erro');
                                         if($query){
                                            echo "<script type='text/javascript'>
                                                    alert('(!) Cliente alterado com sucesso!');
                                                    location.href='listar.php'
                                                 </script>";
                                        }
                                    }
                                //Se retornou erro apresenta em tela
                                }else{
                                    echo '<div class="erro">
                                            <p class="red">'.$retorno.'</p>
                                          </div>';
                                }
                        }//Fim Rotina Validação

                        //Pegar Dados do cliente a ser alterado para mostrar em tela
                        if(isset($_GET['alterar']) && $_GET['alterar'] == 'yes' && !isset($_POST['cadastrar'])){
                            $id    = mysql_real_escape_string((int)$_GET['id']);
                            $sql   = "SELECT * FROM clientes WHERE id = '$id'";
                            $query = mysql_query($sql) or die('Erro');
                            $row   = mysql_fetch_array($query);

                                //Dados Temporarios
                                $nomeA     = $row['nome'];
                                $dtNascA   = $row['dtnasc'];
                                $cpfA      = $row['cpf'];
                                $enderecoA = $row['endereco'];
                                $bairroA   = $row['bairro'];
                                $telefoneA = $row['telefone'];
                        }
                    ?>
                    <div>
                        <label class="required">Nome:</label>
                        <input type="text" name="nome" size="50"
                        value="<?php if(isset($nome) && $nome != null){echo $nome;}
                        else if(isset($nomeA) && $nomeA != null){echo $nomeA;} ?>">
                    </div>
                    <div>
                        <label class="required">Data Nascimento:</label>
                        <input type="text" id="date" name="dtNasc" size="10"
                        value="<?php if(isset($dtNasc) && $dtNasc != null){echo trataData3($dtNasc);}
                        else if(isset($dtNascA) && $dtNascA != null){echo trataData3($dtNascA);} ?>">
                    </div>
                    <div>
                        <label class="required">CPF</label>
                        <input type="text" id="cpf" name="cpf" size="15"
                        value="<?php if(isset($cpf) && $cpf != null){echo $cpf;}
                        else if(isset($cpfA) && $cpfA != null){echo $cpfA;} ?>">
                    </div>
                    <div>
                        <label class="required">Endereço</label>
                        <input type="text" name="endereco" size="50"
                        value="<?php if(isset($endereco) && $endereco != null){echo $endereco;}
                        else if(isset($enderecoA) && $enderecoA != null){echo $enderecoA;} ?>">
                    </div>
                    <div>
                        <label class="required">Bairro</label>
                        <input type="text" name="bairro" size="15"
                        value="<?php if(isset($bairro) && $bairro != null){echo $bairro;}
                        else if(isset($bairroA) && $bairroA != null){echo $bairroA;} ?>">
                    </div>
                    <div>
                        <label class="required">Telefone</label>
                        <input type="text" name="telefone" id="telefone" size="20"
                        value="<?php if(isset($telefone) && $telefone != null){echo $telefone;}
                        else if(isset($telefoneA) && $telefoneA != null){echo $telefoneA;} ?>">
                    </div>
                    <div>
                        <p><span class="red">*</span>Campos Obrigatórios</p>
                        <label>&nbsp;</label>
                        <input type="hidden" name="cadastrar" value="yes">
                        <input type="submit" value="Confirmar">
                    </div>
                </fieldset>
            </form>
        </section>
    </div>
</body>
</html>
