<?
setcookie("Usuario","");

if($senha=="admin")
{
 setcookie("Usuario","SuperUsuario");
 require("header.php");
 printok("<CENTER>Você está logado como administrador do HelpDesk!</CENTER>");
}

else
{
 require("header.php");

 $Hoje=hoje();

 print "<CENTER>Informe a senha de administrador:";
 print "<BR>\n";
 print "<FORM ACTION=\"$PATH_INFO\" METHOD=\"POST\">\n";
 print "<INPUT TYPE=\"PASSWORD\" SIZE=20 NAME=\"senha\" VALUE=\"\">\n";
 print "<INPUT TYPE=\"SUBMIT\" NAME=\"entrar\" VALUE=\"Entrar\">\n";
 print "</FORM></CENTER>\n";

 print "<BR><HR><BR>\n";
 print "<CENTER><A HREF=\"consulta.php\">Consultar Estatísticas</A></CENTER>\n";

}

require("footer.php");
?>
