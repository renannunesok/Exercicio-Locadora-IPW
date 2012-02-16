<?php
    require_once('conecta.php');
    require_once("functions/dateformat.func.php");

    $ultimoRegistro = @mysql_real_escape_string((int)$_POST['ultimo']);
    $sql   = "SELECT * FROM clientes WHERE id < '$ultimoRegistro' ORDER BY id DESC LIMIT 0,2";
    $query = @mysql_query($sql) or die ("Erro");
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
    }
?>
