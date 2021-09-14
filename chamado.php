<?
require("header.php");

if($cadastrar)
{
 $Hoje=hoje();
 $Hora=hora();
 $Minuto=minuto();

 $queryult="SELECT MAX(id) FROM chamados";

 $resultado=mysql_query($queryult,$link);

 $linha=mysql_fetch_array($resultado);
 $cham_atual=$linha["MAX(id)"]+1;
 $titulo="$setor - $Hoje - $cham_atual";
 $remetente="$nome / $setor";

 $query="INSERT INTO chamados VALUES (\"\",\"$titulo\",\"$texto\",\"$remetente\",\"$Hoje\",NULL,NULL,\"$Hora\",\"$Minuto\",NULL,NULL,NULL,NULL)";

 if(mysql_query($query,$link))
 {
  printok("OK. Seu chamado foi enviado com sucesso e registrado como: $titulo.");

  $queryemail="SELECT email FROM emails WHERE setor = \"$setor\" OR setor = \"CPD\"";
  $resultado=mysql_query($queryemail,$link);

  $titulo_email="Help Desk Memovip - Abertura de Chamado - $titulo";
  $texto_email="Chamado aberto as $Hora:$Minuto por $nome:";
  $texto_email.="\n\n";
  $texto_email.=$texto;

  while($linha=mysql_fetch_array($resultado))
   mail($linha[email],$titulo_email,$texto_email,"From: memovip@memovip.com.br");
 }
 else
  printerro("Atenção: Seu chamado não foi enviado devido um erro em nosso banco de dados!");
}
else
{
 print "<FORM ACTION=\"$PATH_INFO\" METHOD=\"POST\">\n";

 print "Breve descrição do problema:\n";
 print "<BR>\n";
 print "<TEXTAREA COLS=80 NAME=\"texto\" STYLE=\"background-color:LIGHTGRAY\"></TEXTAREA>\n";

 print "<BR><BR>";

 print "Informe seu nome:\n";
 print "<BR>\n";
 print "<INPUT TYPE=\"TEXT\" SIZE=\"80\" NAME=\"nome\" VALUE=\"\" STYLE=\"background-color:LIGHTGRAY\">";

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

 print "<INPUT TYPE=\"RESET\" NAME=\"limpar\" VALUE=\"Limpar\">";

 print "<INPUT TYPE=\"SUBMIT\" NAME=\"cadastrar\" VALUE=\"Abrir Chamado\">";

 print "</FORM>\n";
}

require("footer.php");
?>
