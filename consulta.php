<?
require("header.php");

if( $inicio && $fim )
{

print "<BR>\n";

if($inicio!="dd/mm/aaaa")
 print "<CENTER><B>Estatísticas do período $inicio até $fim:</B></CENTER>\n";
else
 print "<CENTER><B>Estatísticas de todos os registros:</B></CENTER>\n";
 
$data=explode("/",$inicio);
$inicio=$data[2] . "-" . $data[1] . "-" . $data[0];
$data=explode("/",$fim);
$fim=$data[2] . "-" . $data[1] . "-" . $data[0];

if( ($inicio=="aaaa-mm-dd") || ($fim=="aaaa-mm-dd") )
 $query="SELECT * FROM chamados";
else
 $query="SELECT * FROM chamados WHERE data_abe BETWEEN \"$inicio\" AND \"$fim\"";

$resultado=mysql_query($query,$link);
$total=0;
$fechados=0;
$tempo_total=0;

print "<TABLE BORDER=1>\n";

while($linha=mysql_fetch_array($resultado))
{

 $total++;
 
 if($linha[data_fec]!="")
 {
  $fechados++;

  //calcula o tempo de atendimento em minutos durante o dia da abertura do chamado
  //se abriu e fechou no mesmo dia, a hora final do dia e' a hora de fechamento
  if($linha[data_abe]==$linha[data_fec])
   $hora_final=$linha[hora_fec];
  else 
   $hora_final=18;
  //se abriu e fechou no mesmo dia e hora, o minuto final da hora e' o minuto de fechamento
  if( ($linha[data_abe]==$linha[data_fec]) && ($linha[hora_abe]==$linha[hora_fec]) )
   $min_final=$linha[min_fec];
  else 
   $min_final=60;
  $min_dia_abe=(($hora_final-$linha[hora_abe]-1)*60) + $min_final-$linha[min_abe];

  //calcula o tempo de atendimento em minutos durante o dia do fechamento do chamado
  //se abriu e fechou no mesmo dia, a hora inicial do dia e' a hora de abertura
  if($linha[data_abe]==$linha[data_fec])
   $hora_inicial=$linha[hora_abe];
  else 
   $hora_inicial=8;
  //se abriu e fechou no mesmo dia e hora, o minuto inicial da hora e' o minuto de abertura
  if( ($linha[data_abe]==$linha[data_fec]) && ($linha[hora_abe]==$linha[hora_fec]) )
   $min_inicial=$linha[min_abe];
  else 
   $min_inicial=0;
  $min_dia_fec=(($linha[hora_fec]-$hora_inicial)*60) + $linha[min_fec]-$min_inicial;
 
  //calcula o tempo de atendimento em minutos durante os dias em que o chamado ficou aberto
  //se abriu e fechou no mesmo dia, nao tem minutos intermediarios
  if($linha[data_abe]!=$linha[data_fec])
  {
   $dias_int=datasub($linha[data_fec],$linha[data_abe]);
   if($dias_int>0)
    $dias_int=$dias_int-1;  
   $min_dia_int=$dias_int*480;
  } 
  else 
   $min_dia_int=0;

  $tempo=$min_dia_abe+$min_dia_fec+$min_dia_int;
   
 }
 else
  $tempo=0; 

 $tempo_total=$tempo_total+$tempo; 
 
 //print "<TR>\n";
 //print "<TD>$linha[titulo]</TD>\n";
 //print "<TD>$linha[data_abe]</TD>\n";
 //print "<TD>$linha[data_fec]</TD>\n";
 //print "<TD>$linha[hora_abe]</TD>\n";
 //print "<TD>$linha[hora_fec]</TD>\n";
 //print "<TD>$linha[min_abe]</TD>\n";
 //print "<TD>$linha[min_fec]</TD>\n";
 //print "<TD>$tempo</TD>\n";
 //print "<TD>$min_dia_abe+$min_dia_fec+$min_dia_int</TD>\n";
 //$temp=datasub($linha[data_fec],$linha[data_abe]);
 //print "<TD>$temp</TD>\n";
 //print "</TR>\n";
  
}
print "</TABLE>\n";

$em_aberto=$total-$fechados;
$tempo_medio=$tempo_total/$fechados/60;
$per_fec=$fechados/$total*100;
$per_abe=$em_aberto/$total*100;

print "<BR>\n";
print "<TABLE BORDER=1 ALIGN=CENTER>\n";
print "<TR><TD>Total de chamados registrados:</TD><TD>$total</TD><TD>100%</TD></TR>\n";
print "<TR><TD>Total de chamados fechados:</TD><TD>$fechados</TD><TD>\n";
printf("%01.0f",$per_fec);
print "%</TD></TR>\n";
print "<TR><TD>Total de chamados em aberto:</TD><TD>$em_aberto</TD><TD>\n";
printf("%01.0f",$per_abe);
print "%</TD></TR>\n";
print "<TR><TD>Tempo médio de atendimento (em horas):</TD><TD>\n";
printf("%01.2f",$tempo_medio);
print "</TD><TD>-</TD></TR>\n";

print "</TABLE>\n";

} //fim do se $inicio e $fim definidos

else
{
 print "<CENTER>\n";
 print "<FORM ACTION=\"$PATH_INFO?inicio=$inicio&fim=$fim\" METHOD=\"POST\">\n";
 print "Data Inicial:&nbsp<INPUT TYPE=\"TEXT\" SIZE=12 NAME=\"inicio\" VALUE=\"dd/mm/aaaa\">\n";
 print "&nbsp\n";
 print "Data Final:&nbsp<INPUT TYPE=\"TEXT\" SIZE=12 NAME=\"fim\" VALUE=\"dd/mm/aaaa\">\n";
 print "<INPUT TYPE=\"SUBMIT\" NAME=\"consultar\" VALUE=\"Consultar\">\n";
 print "</FORM>\n";
 print "</CENTER>\n";
}	


require("footer.php");
?>
