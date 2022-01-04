<?php

    namespace Util;

use InvalidArgumentException;
use JsonException;

class CorpoJsonUtil {

        public function ProcessarArrayRetornar($retorno) {
            
            $dados = [];
            $dados[ConstantesUtil::TIPO] = ConstantesUtil::TIPO_ERRO;

            if((is_array($retorno) && count($retorno) > 0) || strlen($retorno) > 10):
                $dados[ConstantesUtil::TIPO] = ConstantesUtil::TIPO_SUCESSO;
                $dados[ConstantesUtil::RESPOSTA] = $retorno;
            endif;

            $this->RetornarJson($dados);

        }

        private function RetornarJson($json) {
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
            echo json_encode($json);
            exit;
        }

        public static function TratarCorpoRequisicaoJson() {

            try {

                $postJson = json_decode(file_get_contents('php://input'), true);
            
            } catch (JsonException $exception) {
                
                throw new InvalidArgumentException(ConstantesUtil::MSG_ERRO_JSON_VAZIO);

            }

            if(is_array($postJson) && count($postJson) > 0):
                return $postJson;
            endif;
        }

    }