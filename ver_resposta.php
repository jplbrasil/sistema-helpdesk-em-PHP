<?
require("header.php");

//Recupera os dados do chamado
$query="SELECT * FROM chamados WHERE id = $chamado";
$resultado=mysql_query($query,$link);
$linha=mysql_fetch_array($resultado);

$data=dataie($linha[data_abe]);

print "<B>Chamado:</B> &nbsp $linha[titulo]\n";
print "<BR>";
print "<I>Remetente: $linha[remetente] &nbsp - &nbsp Data: $data</I>\n";
print "<BR><BR>";
print "<FONT COLOR=\"GREEN\"<I>$linha[texto]</I></FONT>\n";
print "<BR><BR>";

//Recupera os dados da resposta
$query2="SELECT texto,remetente,data FROM respostas WHERE id = $resposta";
$resultado2=mysql_query($query2,$link);
$linha2=mysql_fetch_array($resultado2);

$data2=dataie($linha2[data]);

print "<B>Resposta:</B>\n";
print "<BR>";
print "<I>Remetente: $linha2[remetente] &nbsp - &nbsp Data: $data2</I>\n";
print "<BR><BR>";
print "<FONT COLOR=\"GREEN\"<I>$linha2[texto]</I></FONT>\n";
print "<BR><BR>";

require("footer.php");
?>