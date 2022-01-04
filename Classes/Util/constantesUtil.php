<?php

    namespace Util;

    abstract class ConstantesUtil {

        /**REQUEST */
        public const TIPO_REQUEST = ['GET', 'POST'];
        public const TIPO_GET = ['RECEPTOR'];
        public const TIPO_POST = ['EMISSOR'];

        /**ERROS */
        public const MSG_ERRO_TIPO_ROTA = 'Rota não perimitida';
        public const MSG_ERRO_RECURSO_INEXISTENTE = 'Recurso inexistente';
        public const MSG_ERRO_GENERICO = 'Algum erro ocorreu na requisição';
        public const MSG_ERRO_SEM_RETORNO = 'Nenhum registro encontrado';
        public const MSG_ERRO_NENUMA_MSG = 'Nenhuma mensagem encontrada';
        public const MSG_ERRO_JSON_VAZIO = 'O corpo da requisição não pode ser vazia';
        public const MSG_ERRO_DADOS_OBRIGATORIO = 'É obrigatorio passar os dados';
        public const MSG_ERRO_ID_OBRIGATORIO = 'É obrigatorio passar o id';

        /**SUCESSO */
        public const MSG_CADASTRO_ID = 'Registro criado com o id:';
        public const MSG_ENVIADA = 'Mensagem enviada';

        /**RETORNO JSON */
        const TIPO_SUCESSO = 'sucesso';
        const TIPO_ERRO = 'erro';

        /**OUTROS */
        public const RESPOSTA = 'resposta';
        public const TIPO = 'tipo';

        /**RECURSOS */
        public const RECURSOS_GET = ['V_MSG'];
        public const RECURSOS_POST = ['CADASTRAR', 'E_MSG'];
    }