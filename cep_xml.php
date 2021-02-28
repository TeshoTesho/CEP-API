<?php

//Func buscar endereço atraves do cep
function get_endereco_cep($cep_pesquisa){

  //Permissão ssl para acesso
  $context = stream_context_create(array('ssl'=>array(
    'verify_peer' => true,
    'cafile' => 'ca-bundle.crt'
  )));
  libxml_set_streams_context($context);
  
  // formatar o cep removendo caracteres nao numericos
  $cep_pesquisa = preg_replace("/[^0-9]/", "", $cep_pesquisa);
  //Url de consulta XML
  $url = "https://viacep.com.br/ws/$cep_pesquisa/xml/"; // Para usar json: https://viacep.com.br/ws/$cep_pesquisa/json/
  //echo "<hr>https://viacep.com.br/ws/$cep_pesquisa/xml/<hr>";
  $resultado_cep = simplexml_load_file($url);
  return $resultado_cep;
}

$endereço = get_endereco_cep("11701390");

echo "<br>CEP: " . $endereço->cep;
echo "<br>Logradouro: " . $endereço->logradouro;
echo "<br>Complemento: " . $endereço->complemento;
echo "<br>Bairro: " . $endereço->bairro;
echo "<br>Cidade: " . $endereço->localidade;
echo "<br>UF: " . $endereço->uf;
echo "<hr><h2>XML:</h2>";
print_r($endereço);
?>