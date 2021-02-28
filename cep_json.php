<?php
//JSON
//Func buscar endereço atraves do cep
function get_endereco_cep($cep_pesquisa){

  //Permissão ssl para acesso
    $arrContextOptions=array(
      "ssl"=>array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
      ),
  );  
  
  // formatar o cep removendo caracteres nao numericos
  $cep_pesquisa = preg_replace("/[^0-9]/", "", $cep_pesquisa);
  //Url de consulta XML
  $url = "https://viacep.com.br/ws/$cep_pesquisa/json/"; 
  $resultado_cep = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)));
  return $resultado_cep;
}

//CEP UTILIZADO 
$endereço = get_endereco_cep("11701390");

echo "<br>CEP: " . $endereço->cep;
echo "<br>Logradouro: " . $endereço->logradouro;
echo "<br>Complemento: " . $endereço->complemento;
echo "<br>Bairro: " . $endereço->bairro;
echo "<br>Cidade: " . $endereço->localidade;
echo "<br>UF: " . $endereço->uf;
echo "<hr><h2>Json:</h2>";
print_r($endereço);
?>