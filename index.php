<?
require("header.php");

if($Usuario == "SuperUsuario")
 require("admin.php");

if(!$ordem)
 $ordem="id";

if(!$situacao)
 $situacao="ER"; //Exibir respondidos tambem

if(!$fechados)
 $fechados="OF"; //Ocultar chamados fechados, por default

print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
print "<TR>\n";
print "<TD WIDTH=20% ALIGN=\"CENTER\" BGCOLOR=\"DDDDDDDD\">\n";
if($ordem=="titulo") $Color="GRAY"; else $Color="BLACK";
print "<A HREF=\"$PATH_INFO?ordem=titulo&situacao=$situacao\"><FONT COLOR=$Color>Classificar pelo título</FONT></A>\n";
print "</TD>\n";
print "<TD WIDTH=20% ALIGN=\"CENTER\" BGCOLOR=\"DDDDDDDD\">\n";
if($ordem=="remetente") $Color="GRAY"; else $Color="BLACK";
print "<A HREF=\"$PATH_INFO?ordem=remetente&situacao=$situacao\"><FONT COLOR=$Color>Classificar pelo remetente</FONT></A>\n";
print "</TD>\n";
print "<TD WIDTH=20% ALIGN=\"CENTER\" BGCOLOR=\"DDDDDDDD\">\n";
if($ordem=="data_abe") $Color="GRAY"; else $Color="BLACK";
print "<A HREF=\"$PATH_INFO?ordem=data_abe&situacao=$situacao\"><FONT COLOR=$Color>Classificar pela data</FONT></A>\n";
print "</TD>\n";
//Exibir ou ocultar respondidos
print "<TD WIDTH=20% ALIGN=\"CENTER\" BGCOLOR=\"DDDDDDDD\">\n";
if($situacao=="ER")
{
 print "<A HREF=\"$PATH_INFO?ordem=$ordem&situacao=OR&fechados=$fechados\"><FONT COLOR=\"BLACK\">Ocultar respondidos</FONT></A>\n";
 $query="SELECT id,titulo,remetente,data_abe,data_fec FROM chamados WHERE id > 0";
}
else
{
 print "<A HREF=\"$PATH_INFO?ordem=$ordem&situacao=ER&fechados=$fechados\"><FONT COLOR=\"BLACK\">Exibir respondidos</FONT></A>\n";
 $query="SELECT id,titulo,remetente,data_abe,data_fec FROM chamados WHERE data_res IS NULL";
}
print "</TD>\n";
//Exibir ou ocultar fechados
print "<TD WIDTH=20% ALIGN=\"CENTER\" BGCOLOR=\"DDDDDDDD\">\n";
if($fechados=="EF")
{
 print "<A HREF=\"$PATH_INFO?ordem=$ordem&fechados=OF&situacao=$situacao\"><FONT COLOR=\"BLACK\">Ocultar fechados</FONT></A>\n";
}
else
{
 print "<A HREF=\"$PATH_INFO?ordem=$ordem&fechados=EF&situacao=$situacao\"><FONT COLOR=\"BLACK\">Exibir fechados</FONT></A>\n";
 $query = $query . " AND data_fec IS NULL";
}
print "</TD>\n";


$query = $query . " ORDER BY $ordem";

print "</TR>\n";
print "</TABLE>\n";

print "<BR>\n";

$resultado=mysql_query($query,$link);

print "<TABLE BORDER=0>\n";

$color="PINK";

while($linha=mysql_fetch_array($resultado))
{
 if($color=="LIGHTGREEN")
  $color="LIGHTBLUE";
 else
  $color="LIGHTGREEN";

 $data_fec=$linha[data_fec];
 $data=dataie($linha[data_abe]);
 print "<TR><TD BGCOLOR=\"$color\" WIDTH=2000>\n";
 if($data_fec=="")
 {
  print "-> &nbsp <B> $linha[titulo] </B>\n";
  print "&nbsp <A HREF=\"resposta.php?chamado=$linha[id]&Pag=1\">[ Adicionar Resposta ]</A>\n";
  if($Usuario == "SuperUsuario")
  {
   print "&nbsp <A HREF=\"index.php?fecharc=$linha[id]\">[ Fechar Chamado ]</A>\n";
   print "&nbsp <A HREF=\"index.php?excluirc=$linha[id]\">[ Excluir Chamado ]</A>\n";
  }
 }
 else
 {
  print "-> &nbsp <B> $linha[titulo] &nbsp <I>(Fechado)</B></I>\n";
  if($Usuario == "SuperUsuario")
   print "&nbsp <A HREF=\"index.php?reabrirc=$linha[id]\">[ Reabrir Chamado ]</A>\n";
 }

 print "</TD></TR>\n";
 print "<TR><TD BGCOLOR=\"$color\"><I><FONT SIZE=2>Remetente: $linha[remetente] * Data: $data</I></FONT></TD></TR>\n";

 $query2="SELECT id,remetente,data FROM respostas WHERE chamado = $linha[id]";
 $resultado2=mysql_query($query2,$link);

 while($linha2=mysql_fetch_array($resultado2))
 {
  $data2=dataie($linha2[data]);
  print "<TR><TD BGCOLOR=\"$color\"> &nbsp &nbsp &nbsp --> &nbsp <B> Re: $linha[titulo] </B>\n";
  print "&nbsp <A HREF=\"ver_resposta.php?chamado=$linha[id]&resposta=$linha2[id]\"> [ Ver Resposta ] </A>\n";
  if( ($Usuario == "SuperUsuario") && ($data_fec=="") )
   print "&nbsp <A HREF=\"index.php?excluirr=$linha2[id]\">[ Excluir Resposta ]</A>\n";
  print "</TD></TR>\n";
  print "<TR><TD BGCOLOR=\"$color\"> &nbsp &nbsp &nbsp <FONT SIZE=2><I>Remetente: $linha2[remetente] * Data: $data2</I></FONT></TD></TR>\n";
 }

 print "<TR><TD><BR></TD></TR>\n";
}

print "</TABLE>\n";

require("footer.php");
?>
