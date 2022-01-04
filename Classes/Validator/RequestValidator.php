<?php

    namespace Validator;

use Controller\EMRCControllers;
use Util\ConstantesUtil;
use Util\CorpoJsonUtil;

class RequestValidator {

        private $request;
        private object $EMRC;
        private array $dadosRequest = [];

        public function __construct($request)
        {   
            $this->request = $request;
        }

        public function ProcesarRequest() {

            $retorno = utf8_encode(ConstantesUtil::MSG_ERRO_TIPO_ROTA);

            $this->request['metodo'] == 'POST';
            if(in_array($this->request['metodo'], ConstantesUtil::TIPO_REQUEST, true)):
                $retorno = $this->DirecionarRequest();
            endif;

            return $retorno;
        }

        private function DirecionarRequest() {
            
            if($this->request['metodo'] !== 'GET'):
                $this->dadosRequest = CorpoJsonUtil::TratarCorpoRequisicaoJson();
            endif;

            $metodo = $this->request['metodo'];
            return $this->$metodo();
        }

        private function get() {

            $retorno = utf8_encode(ConstantesUtil::MSG_ERRO_GENERICO);

            if(in_array($this->request['rota'], ConstantesUtil::TIPO_GET)):
                $this->EMRC = new EMRCControllers($this->request);
                return $this->EMRC->ValidarGet();
            endif;

            return $retorno;
        }

        private function post() {

            $retorno = utf8_encode(ConstantesUtil::MSG_ERRO_TIPO_ROTA);

            if(in_array($this->request['rota'], ConstantesUtil::TIPO_POST)):
                $this->EMRC = new EMRCControllers($this->request);
                $this->EMRC->setDados($this->dadosRequest);
                $retorno = $this->EMRC->ValidarPost();
            endif;

            return $retorno;
        }

    }