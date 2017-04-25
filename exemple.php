<?php

$valUser = new ValidateFieldInsert();
$valUserData = new ValidateFieldInsert();

$email 			= request_var('email', '');
$email2 		= request_var('email-2', '');
$pass			= request_var('senha', '');
$pass2 			= request_var('senha-2', '');

$tipoUsu 		= request_var('tipo-usuario', '');
$nome 			= request_var('nome', '');
$sobrenome		= request_var('sobrenome', '');
$celular 		= request_var('celular', '');
$telefone		= request_var('telefone', '');
$cpf			= request_var('cpf', '');
$rg				= request_var('rg', '');

$infTrib		= request_var('informacoes-tributarias', '');
$cnpj			= request_var('cnpj', '');
$razaoSocial	= request_var('razao-social', '');
$inscricaoEst	= request_var('inscricao-estadual', '');

$cep			= request_var('cep', '');
$numero			= request_var('numero', '');
$complemento	= request_var('complemento', '');
$bairro			= request_var('bairro', '');
$estado			= request_var('estado', '');
$cidade			= request_var('cidade', '');

$termos			= request_var('termos', '');

//Validação e criação dos arrays de insert
$valUser->mail($email, 'email', 'user_email');
$valUser->equals($email, $email2, 'email-2');
$valUser->lenght($pass, 8, 'senha', 'user_password');
$valUser->equals($pass, $pass2, 'senha-2');

$valUserData->inRange($tipoUsu, 0, 1, 'tipo-usuario', 'data_tipo_usuario');
$valUserData->lenght($nome, 3, 'nome', 'data_nome');
$valUserData->lenght($sobrenome, 3, 'sobrenome', 'data_sobrenome');
$valUserData->phone($celular, 'celular', 'data_celular');
$valUserData->phone($telefone, 'telefone', 'data_telefone');

$valUserData->addInsert($tipoUsu, 'data_tipo_usuario');

if($tipoUsu == '0') {
	//Juridica
	$valUserData->inRange($infTrib, 1, 3, 'informacoes-tributarias', 'data_informacoes_tributarias');
	$valUserData->cnpj($cnpj, 'cnpj', 'data_cnpj');
	$valUserData->lenght($razaoSocial, 4, 'razao-social', 'data_razao_social');
	$valUserData->lenght($inscricaoEst, 4, 'inscricao-estadual', 'data_inscricao_estadual');
} else {
	//Fisica
	$valUserData->cpf($cpf, 'cpf', 'data_cpf');
	$valUserData->lenght($rg, 12,'rg', 'data_rg');
}

$valUserData->cep($cep, 'cep', 'data_endereco_cep');
$valUserData->lenght($numero, 1,'numero', 'data_endereco_numero');
$valUserData->lenght($bairro, 4, 'bairro', 'data_endereco_bairro');
$valUserData->lenght($estado, 2, 'estado', 'data_endereco_estado');
$valUserData->lenght($cidade, 4, 'cidade', 'data_endereco_cidade');
$valUserData->addInsert($complemento, 'data_endereco_complemento');
$valUserData->exist($termos, 'termos', 'noinsert', false);

$return['user'] = $valUser->results();
$return['data'] = $valUserData->results();

return $return;