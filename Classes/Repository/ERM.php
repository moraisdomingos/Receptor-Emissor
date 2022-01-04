<?php

    namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantesUtil;

class ERM {

        private object $MySQL;
        private const TABELA_USER = 'usuarios';
        private const TABELA_MSG = 'mensagens';

        public function __construct()
        {
            $this->MySQL = new MySQL();
        }

        public function MSG($id) {
            
             
             $nomeEmissor = [];
             $MSGS = [];
             $retorno = [];
            foreach ($result = $this->SelectMsg($id) as  $value) {

                array_push($MSGS, $value['msg']);
                array_push($nomeEmissor, $this->SelectName($value['id_emissor']));
                
            }
           
            $msgPrint = array_map(null, $MSGS, $nomeEmissor);
            $size = count($msgPrint);
            
            for ($i=0; $i < $size; $i++) {        
                array_push($retorno,  'Assunto: '. $msgPrint[$i][0] . '. <br>' .  'Mensagem enviada por: '. $msgPrint[$i][1]['nome']);
            }

            return $retorno;

        }

        public function Insert($dado) {

            $Insert = 'INSERT INTO '. self::TABELA_USER . '(nome) VALUES (:nome)';
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($Insert);
            $stmt->bindParam(':nome', $dado);
            $stmt->execute();

            return $stmt->rowCount();

        }

        public function EnviarMsg($dados) {

            $Enviar = 'INSERT INTO '. self::TABELA_MSG . '(msg, id_emissor, id_receptor) VALUES (:msg, :id_emissor, :id_receptor)';
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($Enviar);
            $stmt->bindParam(':msg', $dados[0]);
            $stmt->bindParam(':id_emissor', $dados[1]);
            $stmt->bindParam(':id_receptor', $dados[2]);
            $stmt->execute();
            $this->MySQL->getDb()->commit();
            return $stmt->rowCount();
            
        }

        private function SelectMsg($id) {

            $SELECT = 'SELECT id, msg, id_emissor FROM ' . self::TABELA_MSG . ' WHERE id_receptor = :id_receptor';
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($SELECT);
            $stmt->bindParam(':id_receptor', $id);
            $stmt->execute();
            $this->MySQL->getDb()->commit();
            $return = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);

            if(count($return) > 0):
                return $return;
            else:
                throw new InvalidArgumentException(ConstantesUtil::MSG_ERRO_NENUMA_MSG);
            endif;
        }

        private function SelectName($id) {

            $SelectName = 'SELECT nome FROM '. self::TABELA_USER .' WHERE id = :id';
            $this->MySQL->getDb()->beginTransaction();
            $stmt = $this->MySQL->getDb()->prepare($SelectName);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $this->MySQL->getDb()->commit();
             $result =  $stmt->fetch($this->MySQL->getDb()::FETCH_ASSOC);
           
            if(empty($result)):
                return ['nome' => 'Anónimo'];
            else:
                return $result;
            endif;
            
        }

        public function getMySQL() {
            return $this->MySQL;
        }

    }