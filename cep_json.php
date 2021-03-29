<?php
//JSON
//Func buscar endereço atraves do cep
function get_endereco_cep($cep_pesquisa){
	$cep_pesquisa = preg_replace( '/[^0-9]/is', '', $cep_pesquisa ); // Limpa string
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


function mask($val){
  $mask = "#####-###";
  $val = preg_replace( '/[^0-9]/is', '', $val);
  $maskared = '';
  $k = 0;
  for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
    if ($mask[$i] == '#') {
      if (isset($val[$k])) {
        $maskared .= $val[$k++];
      }
    } else {
      if (isset($mask[$i])) {
        $maskared .= $mask[$i];
      }
    }
  }
  return $maskared;
}

function endereço($cep){
	$endereço = @get_endereco_cep($cep);
	return $endereço==false ? false : $endereço->logradouro;
}
function complemento($cep){
	$endereço =@get_endereco_cep($cep);
	return $endereço==false ? false : $endereço->complemento;
}
function bairro($cep){
	$endereço =@get_endereco_cep($cep);
	return $endereço==false ? false : $endereço->bairro;
}
function cidade($cep){
	$endereço =@get_endereco_cep($cep);
	return $endereço==false ? false : $endereço->localidade;
}
function uf($cep){
	$endereço =@get_endereco_cep($cep);
	return $endereço==false ? false : $endereço->uf;
}
function json($cep){
	$endereço =@get_endereco_cep($cep);
	return $endereço==false ? false : print_r($endereço);
}


//CEP UTILIZADO 
$cep = '11701390';
$endereço = get_endereco_cep($cep);
echo $endereço==false ? "" : "<br>CEP: " . mask($cep);
echo $endereço==false ? "" : "<br>Logradouro: " . $endereço->logradouro;
echo $endereço==false ? "" : "<br>Complemento: " . $endereço->complemento;
echo $endereço==false ? "" : "<br>Bairro: " . $endereço->bairro;
echo $endereço==false ? "" : "<br>Cidade: " . $endereço->localidade;
echo $endereço==false ? "" : "<br>UF: " . $endereço->uf;
//echo get_endereco_cep($cep)==false ? "" : "--". json($cep) ."";


?>