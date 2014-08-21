<?

$atual_dir = getcwd();

$nome_arquivos = "contador_contato.txt";
$file = fopen($nome_arquivos,"r+");
$contador = fread($file, filesize($nome_arquivos));
fclose($file);
$contador +=1;
$file = fopen($nome_arquivos,"w+");

fputs($file, $contador);
fclose($file); 
chdir($atual_dir);	

?>