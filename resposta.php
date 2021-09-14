<?
require("header.php");

if($cadastrar)
{

 $Hoje=hoje();
 $Hora=hora();
 $Minuto=minuto();

 $query="UPDATE chamados SET data_res=\"$Hoje\", hora_res=\"$Hora\", min_res=\"$Minuto\" WHERE id = $chamado";

 if(!mysql_query($query,$link))
  printerro("Atenção: Sua resposta não foi enviada devido um erro em nosso banco de dados!");
 else
 {
  $remetente="$nome / $setor";


  $query="INSERT INTO respostas VALUES (\"\",\"$chamado\",\"$resposta\",\"$remetente\",\"$Hoje\")";



 if(mysql_query($query,$link))
 {
  printok("OK. Sua resposta foi enviada com sucesso.");

  $querycham="SELECT titulo,remetente FROM chamados WHERE id = $chamado";
  $resultado=mysql_query($querycham,$link);
  $linha=mysql_fetch_array($resultado);
  $titulo=$linha[titulo];
  $autor=$linha[remetente];
  $dados=explode(" / ",$autor);
  $setor_sol=$dados[1];

  $titulo_email="Help Desk Memovip - Resposta ao Chamado $titulo";
  $texto_email="Resposta enviada as $Hora:$Minuto por $nome:";
  $texto_email.="\n\n";
  $texto_email.="$resposta"; 
  
  $queryemail="SELECT email FROM emails WHERE setor = \"$setor_sol\" OR setor = \"CPD\"";
  $resultado=mysql_query($queryemail,$link);
  while($linha=mysql_fetch_array($resultado))
   mail($linha[email],$titulo_email,$texto_email,"From: memovip@memovip.com.br");
 }
  else
   printerro("Atenção: Sua resposta não foi enviada devido a um erro em nosso banco de dados!");
 }

}
else
{

 $query="SELECT titulo,texto FROM chamados WHERE id = $chamado";
 $resultado=mysql_query($query,$link);
 $linha=mysql_fetch_array($resultado);

 print "<B>Chamado: &nbsp $linha[titulo]</B>\n";

 print "<BR><BR>";

 print "<FONT COLOR=\"GREEN\"<I>$linha[texto]</I></FONT>\n";

 print "<BR><BR>";

 print "<FORM ACTION=\"$PATH_INFO\" METHOD=\"POST\">\n";

 print "Resposta:\n";
 print "<BR>\n";
 print "<TEXTAREA COLS=80  NAME=\"resposta\" STYLE=\"background-color:LIGHTGRAY\"></TEXTAREA>\n";

 print "<BR><BR>";

 print "Informe seu nome:\n";
 print "<BR>\n";
 print "<INPUT TYPE=\"TEXT\" SIZE=80 NAME=\"nome\" STYLE=\"background-color:LIGHTGRAY\">\n";

 print "<BR><BR>";

 print "Informe seu setor:\n";
 print "<BR>\n";

 print "<SELECT NAME=\"setor\" STYLE=\"background-color:LIGHTGRAY\">";

 $querysetor="SELECT DISTINCT setor FROM emails ORDER BY setor";
 $resultado=mysql_query($querysetor,$link);
 while($linha=mysql_fetch_array($resultado))
  print "<OPTION VALUE=\"$linha[setor]\">$linha[setor]</OPTION>";

 print "</SELECT>";

 print "<BR><BR>";

 print "<INPUT TYPE=\"HIDDEN\" NAME=\"chamado\" VALUE=\"$chamado\">";

 print "<INPUT TYPE=\"RESET\" NAME=\"limpar\" VALUE=\"Limpar\">";

 print "<INPUT TYPE=\"SUBMIT\" NAME=\"cadastrar\" VALUE=\"Responder\">";

 print "</FORM>\n";
}

require("footer.php");
?>
