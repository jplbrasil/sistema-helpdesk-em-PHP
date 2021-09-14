<?

 $Hoje=hoje();
 $Hora=hora();
 $Minuto=minuto();

  //Links para criacao das tabelas de dados
  print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
  print "<TR>\n";
  print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
  print "<A HREF=\"$PATH_INFO?criar=bd&senha=$senha\">Criar base de dados HELPDESK</A>\n";
  print "</TD>\n";
  print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
  print "<A HREF=\"$PATH_INFO?criar=chamados&senha=$senha\">Criar tabela de chamados</A>\n";
  print "</TD>\n";
  print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
  print "<A HREF=\"$PATH_INFO?criar=respostas&senha=$senha\">Criar tabela de respostas</A>\n";
  print "</TD>\n";
  print "<TD WIDTH=25% ALIGN=\"CENTER\">\n";
  print "<A HREF=\"$PATH_INFO?criar=emails&senha=$senha\">Criar tabela de emails</A>\n";
  print "</TD>\n";
  print "<TD>\n";

  if($cadastrar)
  {
   $query="INSERT INTO emails VALUES (\"\",\"$setor\",\"$email\")";

   if(!mysql_query($query,$link))
    printerro("Atenção: Email não foi cadastrado devido a um erro em nosso banco de dados!");
  }

  if($remover)
  {
   $query="DELETE FROM emails WHERE email = \"$email\"";

   if(mysql_query($query,$link))
    printok("OK. Email foi <B>descadastrado</B> com sucesso!");
   else
    printerro("Atenção: Email não foi <B>descadastrado</B> devido a um erro em nosso banco de dados!");
  }
  else
  {
   print "<FORM ACTION=\"$PATH_INFO?senha=$senha\" METHOD=\"POST\">\n";
   print "Setor: &nbsp <INPUT TYPE=\"TEXT\" SIZE=20 NAME=\"setor\" VALUE=\"\">\n";
   print "Email: &nbsp <INPUT TYPE=\"TEXT\" SIZE=20 NAME=\"email\" VALUE=\"\">\n";
   print "<INPUT TYPE=\"SUBMIT\" NAME=\"cadastrar\" VALUE=\"Cad\">\n";
   print "<INPUT TYPE=\"SUBMIT\" NAME=\"remover\" VALUE=\"Rem\">\n";
   print "<A HREF=\"lista_emails.php\">lista</A>\n";
   print "</FORM>\n";
  }
  print "</TD>\n";
  print "</TR>\n";
  print "</TABLE>\n";
  print "<BR><BR>\n";

  //Procedimento para criacao de tabelas de dados
  if($criar)
  {
   if($criar=="bd")
   {
    $query="CREATE DATABASE HELPDESK";

    if(mysql_query($query,$link))
     printok("OK. Base de dados \"HELPDESK\" criada com sucesso!");
    else
     printerro("Atenção: A base de dados não foi criada devido um erro em nosso banco de dados!");
   }

   if($criar=="chamados")
   {
    $query="CREATE TABLE chamados (id INT PRIMARY KEY AUTO_INCREMENT, titulo TEXT, texto TEXT, remetente TEXT, data_abe DATE, data_res DATE, data_fec DATE, hora_abe INT, min_abe INT, hora_res INT, min_res INT, hora_fec INT, min_fec INT)";

    if(mysql_query($query,$link))
     printok("OK. Tabela \"chamados\" criada com sucesso!");
    else
     printerro("Atenção: A tabela \"chamados\" não foi criada devido um erro em nosso banco de dados!");
   }

   if($criar=="respostas")
   {
    $query="CREATE TABLE respostas (id INT PRIMARY KEY AUTO_INCREMENT, chamado INT, texto TEXT, remetente TEXT, data DATE)";

    if(mysql_query($query,$link))
     printok("OK. Tabela \"respostas\" criada com sucesso!");
    else
     printerro("Atenção: A tabela \"respostas\" não foi criada devido um erro em nosso banco de dados!");
   }

   if($criar=="emails")
   {
    $query="CREATE TABLE emails (id INT PRIMARY KEY AUTO_INCREMENT, setor TEXT, email TEXT)";

    if(mysql_query($query,$link))
     printok("OK. Tabela \"emails\" criada com sucesso!");
    else
     printerro("Atenção: A tabela \"emails\" não foi criada devido um erro em nosso banco de dados!");
   }

  }

  //Procedimento para excuir chamados
  if($excluirc)
  {
   $query="DELETE FROM chamados WHERE id = $excluirc";

   if(mysql_query($query,$link))
    printok("OK. Chamado excluído com sucesso!");
   else
    printerro("Atenção: O chamado não foi excluído devido um erro em nosso banco de dados!");

   $query="DELETE FROM respostas WHERE chamado = $excluirc";

   if(mysql_query($query,$link))
    printok("OK. Resposta(s) do chamado excluída(s) com sucesso!");
   else
    printerro("Atenção: A(s) resposta(s) do chamado não foi(foram) excluída(s) devido um erro em nosso banco de dados!");
  }

  //Procedimento para excluir respostas
  else if($excluirr)
  {
   $query="DELETE FROM respostas WHERE id = $excluirr";

   if(mysql_query($query,$link))
    printok("OK. Resposta excluída com sucesso!");
   else
    printerro("Atenção: A resposta não foi excluída devido um erro em nosso banco de dados!");
  }

  //Procedimento para fechar chamados
  else if($fecharc)
  {
   $query="UPDATE chamados SET data_fec=\"$Hoje\",hora_fec=\"$Hora\",min_fec=\"$Minuto\" WHERE id = $fecharc";

   if(!mysql_query($query,$link))
    printerro("Atenção: O chamado não foi fechado devido a um erro em nosso banco de dados!");
  }

  //Procedimento para reabrir chamados
  else if($reabrirc)
  {
   $query="UPDATE chamados SET data_fec=NULL,hora_fec=0,min_fec=0 WHERE id = $reabrirc";

   if(!mysql_query($query,$link))
    printerro("Atenção: O chamado não foi reaberto devido a um erro em nosso banco de dados!");
  }

?>
