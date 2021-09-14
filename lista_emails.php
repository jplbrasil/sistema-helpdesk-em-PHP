<?
require("header.php");

 print "<TABLE BORDER=1 ALIGN=CENTER CELLPADDING=5>";
 print "<TR><TD><B>Setor</B></TD><TD><B>Email</B></TD></TR>";

 $queryemail="SELECT setor,email FROM emails ORDER BY setor";
 $resultado=mysql_query($queryemail,$link);
 while($linha=mysql_fetch_array($resultado))
  print "<TR><TD>$linha[setor]</TD><TD>$linha[email]</TD></TR>";

 print "</TABLE>";

require("footer.php");
?>
