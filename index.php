<?php

use Util\ConstantesUtil;
use Util\CorpoJsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

   include 'config.php';

   try {
       
    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $Retorno = $RequestValidator->ProcesarRequest();
    $JSon = new CorpoJsonUtil();
    $JSon->ProcessarArrayRetornar($Retorno);

   } catch (Exception $exception) {
       
    header('HTTP/1.1 404');

    echo json_encode([
        ConstantesUtil::TIPO => ConstantesUtil::TIPO_ERRO,
        ConstantesUtil::RESPOSTA => utf8_encode($exception->getMessage())
    ]);
    exit;

   }