<?
require("header.php");

if(!$ordem)
 $ordem="id";

if(!$situacao)
 $situacao="%";

print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
print "<TR>\n";
print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
print "<A HREF=\"$PATH_INFO?ordem=titulo&situacao=$situacao\">Classificar pelo título</A>\n";
print "</TD>\n";
print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
print "<A HREF=\"$PATH_INFO?ordem=remetente&situacao=$situacao\">Classificar pelo remetente</A>\n";
print "</TD>\n";
print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
print "<A HREF=\"$PATH_INFO?ordem=data&situacao=$situacao\">Classificar pela data</A>\n";
print "</TD>\n";
print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
if($situacao=="%")
 print "<A HREF=\"$PATH_INFO?ordem=$ordem&situacao=N\">Ocultar respondidos</A>\n";
else
 print "<A HREF=\"$PATH_INFO?ordem=$ordem&situacao=%\">Exibir respondidos</A>\n";
print "</TD>\n";

print "</TR>\n";
print "</TABLE>\n";

print "<BR>\n";

$query="SELECT id,titulo,remetente,data,respondido FROM chamados WHERE respondido LIKE \"%$situacao%\" AND fechado = \"S\" ORDER BY $ordem";
$resultado=mysql_query($query,$link);

print "<TABLE>\n";

while($linha=mysql_fetch_array($resultado))
{
 $data=dataie($linha[data]);
 print "<TR><TD>-><A HREF=\"resposta.php?chamado=$linha[id]\">$linha[titulo]</A></TD></TR>\n";
 print "<TR><TD><I>Remetente: $linha[remetente] * Data: $data</I></TD></TR>\n";

 $query2="SELECT id,remetente,data FROM respostas WHERE chamado = $linha[id]";
 $resultado2=mysql_query($query2,$link);

 while($linha2=mysql_fetch_array($resultado2))
 {
  $data2=dataie($linha2[data]);
  print "<TR><TD> &nbsp &nbsp &nbsp --> <A HREF=\"ver_resposta.php?chamado=$linha[id]&resposta=$linha2[id]\">Re:$linha[titulo]</A></TD></TR>\n";
  print "<TR><TD> &nbsp &nbsp &nbsp <I>Remetente: $linha2[remetente] * Data: $data2</I></TD></TR>\n";
 }

 print "<TR><TD><BR></TD></TR>\n";
}

print "</TABLE>\n";

print "<BR><BR><BR>\n";

print "<HR>\n";

print "<BR>\n";

print "<A HREF=\"index.php\">Voltar</A>\n";


require("footer.php");
?>
