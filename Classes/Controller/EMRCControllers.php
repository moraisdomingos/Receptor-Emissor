<?php

    namespace Controller;

use InvalidArgumentException;
use Repository\Cadastrar;
use Repository\ERM;
use Util\ConstantesUtil;

class EMRCControllers {

        private $dados;
        private array $dadosRequest = [];
        private array $dadosCorpoRequest;
        private object $EMCRepository;
        private object $MySQL;
        public $recurso;

        public function __construct($dados = [])
        {
            $this->dados = $dados;
            $this->EMCRepository = new ERM();
            $this->recurso = $dados['recurso'];
        }

        public function ValidarGet() {

            if(in_array($this->recurso, ConstantesUtil::RECURSOS_GET)):
                $retorno = $this->dados['id'] > 0 ?  $this->Ver_MSG() : ConstantesUtil::MSG_ERRO_ID_OBRIGATORIO;
            endif;

            return $retorno;
        }

        public function ValidarPost() {

            $verifica = in_array($this->recurso, ConstantesUtil::RECURSOS_POST);

            if($verifica):
                switch ($verifica) {
                    case $this->recurso === 'CADASTRAR' :
                       $retorno = $this->cadastrar();
                        break;
                        case $this->recurso === 'E_MSG' :
                            $retorno = $this->EnMsg();
                            break;
                    default:
                        throw new InvalidArgumentException(ConstantesUtil::MSG_ERRO_RECURSO_INEXISTENTE);
                        break;
                }
            endif;

            return $retorno;
        }

        private function Ver_MSG() {

            return $this->EMCRepository->MSG($this->dados['id']);

        }

        private function cadastrar() {

            if($this->dadosCorpoRequest['nome']):
                if($this->EMCRepository->Insert($this->dadosCorpoRequest['nome']) > 0):
                  $id_inserido = $this->EMCRepository->getMySQL()->getDb()->lastInsertId();
                  $this->EMCRepository->getMySQL()->getDb()->commit();
                  return ConstantesUtil::MSG_CADASTRO_ID . $id_inserido;
                else:
                    $this->EMCRepository->getMySQL()->getDb()->rollBack();
                    throw new InvalidArgumentException(ConstantesUtil::MSG_ERRO_GENERICO);
                endif;
            endif;

        }

        private function EnMsg() {
            
            if($this->RetornarDados()):
                if($this->EMCRepository->EnviarMsg($this->RetornarDados()) > 0):
                    return ConstantesUtil::MSG_ENVIADA;
                else:
                    throw new InvalidArgumentException(ConstantesUtil::MSG_ERRO_GENERICO);
                endif;
            endif;

        }

        private function RetornarDados() {
            return [$msg, $id_emissor, $id_receptor] = [$this->dadosCorpoRequest['msg'], $this->dadosCorpoRequest['id_emissor'], $this->dadosCorpoRequest['id_receptor']];
        }

        public function setDados($dadosRequest) {
            $this->dadosCorpoRequest = $dadosRequest;
        }

    }