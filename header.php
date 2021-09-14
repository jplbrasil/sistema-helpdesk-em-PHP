<?

function printok($string)
{
 print "<B><FONT SIZE=3 COLOR=\"GREEN\">$string</FONT></B><BR><BR>\n";
}

function printerro($string)
{
 print "<B><FONT SIZE=3 COLOR=\"RED\">$string</FONT></B><BR><BR>\n";
}

function hoje()
{
 return date("y") . date("m") . date("d");
}

function hora()
{
 return date("H");
}

function minuto()
{
 return date("i");
}

function dataie($data)
{
 $data=explode("-",$data);
 return $data[2] . "/" . $data[1] . "/" . $data[0];
}

//subtrai datas: $da - $db
function datasub($da,$db)
{
 $data=explode("-",$db);
 $dia1=$data[2];
 $mes1=$data[1];
 $ano1=$data[0];
 $data=explode("-",$da);
 $dia2=$data[2];
 $mes2=$data[1];
 $ano2=$data[0];
 $anos=$ano2-$ano1;
 if($anos==0)
  $meses=$mes2-$mes1;
 else
  $meses=(12-$mes1)+$mes2; 
 if($meses==0)
  $dias=$dia2-$dia1;
 else
  $dias=(30-$dia1)+$dia2; 
 if($anos>0)
  $anos=$anos-1; 
 if($meses>0)
  $meses=$meses-1; 
 return ($anos*365+$meses*30+$dias);
}	

$link=mysql_connect("localhost","root","smellslike");
mysql_select_db("HELPDESK",$link);

print "<HTML>\n";
print "<TITLE>Help Desk - Memovip Guarda de Documentos</TITLE>\n";
print "<BODY BGCOLOR=\"WHITE\" LINK=\"BLUE\" VLINK=\"BLUE\" ALINK=\"BLUE\">\n";

print "<TABLE ALIGN=\"CENTER\">\n";
print "<TR>\n";
print "<TD WIDTH=50>\n";
print "<IMG SRC=\"logo.gif\" WHIDTH=50 HEIGHT=50 BORDER=0>\n";
print "</TD>\n";
print "<TD BGCOLOR=\"LIGHTBLUE\" ALIGN=\"CENTER\" WIDTH=1950>\n";
print "<FONT SIZE=5 COLOR=\"BLUE\"><B>Help Desk Memovip</B></FONT>\n";
print "</TD>\n";
print "</TR>\n";
print "</TABLE>\n";
print "<BR>\n";
print "<TABLE ALIGN=\"CENTER\" BORDER=1 CELLPADDING=5>\n";
print "<TR>\n";

if(!$Pag)
 $Pag="index";

if($Pag=="index")
 print "<TD BGCOLOR=\"DDDDDDDD\"><A HREF=\"index.php?Pag=index\"><FONT COLOR=\"GRAY\">Acompanhamento de Chamados</FONT></TD>\n";
else
 print "<TD BGCOLOR=\"DDDDDDDD\"><A HREF=\"index.php?Pag=index\"><FONT COLOR=\"BLACK\">Acompanhamento de Chamados</FONT></TD>\n";
if($Pag=="chamado")
 print "<TD BGCOLOR=\"DDDDDDDD\"><A HREF=\"chamado.php?Pag=chamado\"><FONT COLOR=\"GRAY\">Abrir Chamado</FONT></TD>\n";
else
 print "<TD BGCOLOR=\"DDDDDDDD\"><A HREF=\"chamado.php?Pag=chamado\"><FONT COLOR=\"BLACK\">Abrir Chamado</FONT></TD>\n";
if($Pag=="login")
 print "<TD BGCOLOR=\"DDDDDDDD\"><A HREF=\"login.php?Pag=login\"><FONT COLOR=\"GRAY\">Administração do Help Desk</FONT></TD>\n";
else
 print "<TD BGCOLOR=\"DDDDDDDD\"><A HREF=\"login.php?Pag=login\"><FONT COLOR=\"BLACK\">Administração do Help Desk</FONT></TD>\n";
print "</TR>\n";
print "</TABLE>\n";
print "<HR>\n";
print "<BR>\n";
?>
