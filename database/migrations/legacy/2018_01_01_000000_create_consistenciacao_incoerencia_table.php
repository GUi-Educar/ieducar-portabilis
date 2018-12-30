<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateConsistenciacaoIncoerenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            '
                SET default_with_oids = true;
                
                CREATE SEQUENCE consistenciacao.incoerencia_idinc_seq
                    START WITH 1
                    INCREMENT BY 1
                    MINVALUE 0
                    NO MAXVALUE
                    CACHE 1;

                CREATE TABLE consistenciacao.incoerencia (
                    idinc integer DEFAULT nextval(\'consistenciacao.incoerencia_idinc_seq\'::regclass) NOT NULL,
                    idcon integer NOT NULL,
                    data_gravacao date NOT NULL,
                    ultima_etapa numeric(1,0) NOT NULL,
                    cpf_cnpj numeric(14,0),
                    nome character varying(150),
                    email character varying(100),
                    url character varying(60),
                    data_nasc character varying(20),
                    fantasia character varying(50),
                    insc_estadual numeric(10,0),
                    sexo character varying(10),
                    nome_mae character varying(150),
                    nome_pai character varying(150),
                    nome_responsavel character varying(150),
                    nome_conjuge character varying(150),
                    ultima_empresa character varying(150),
                    ocupacao character varying(250),
                    escolaridade character varying(60),
                    estado_civil character varying(15),
                    pais_estrangeiro character varying(60),
                    data_chegada_brasil character varying(20),
                    data_obito character varying(20),
                    data_uniao character varying(20)
                );
                
                ALTER TABLE ONLY consistenciacao.incoerencia
                    ADD CONSTRAINT pk_incoerencia PRIMARY KEY (idinc);

                SELECT pg_catalog.setval(\'consistenciacao.incoerencia_idinc_seq\', 1, false);
            '
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consistenciacao.incoerencia');

        DB::unprepared('DROP SEQUENCE consistenciacao.incoerencia_idinc_seq;');
    }
}
