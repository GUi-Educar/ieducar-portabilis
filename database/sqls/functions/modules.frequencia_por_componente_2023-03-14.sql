CREATE OR REPLACE FUNCTION modules.frequencia_por_componente(cod_matricula_id integer, cod_disciplina_id integer, cod_turma_id integer)
RETURNS character varying
LANGUAGE plpgsql
AS $$
DECLARE
    cod_falta_aluno_id integer;
    v_total_faltas integer;
    qtde_carga_horaria float;
    v_hora_falta float;
    cod_serie_id integer;
    cod_escola_id integer;
BEGIN

    cod_falta_aluno_id := (SELECT id FROM modules.falta_aluno WHERE matricula_id = cod_matricula_id ORDER BY id DESC LIMIT 1);
	cod_escola_id := (SELECT t.ref_ref_cod_escola FROM pmieducar.turma t WHERE cod_turma = cod_turma_id);

    qtde_carga_horaria := (
        SELECT carga_horaria :: float
        FROM modules.componente_curricular_turma
        WHERE componente_curricular_turma.componente_curricular_id = cod_disciplina_id
        AND componente_curricular_turma.turma_id = cod_turma_id
    );

    cod_serie_id := (
        SELECT ref_ref_cod_serie
        FROM pmieducar.matricula
        WHERE cod_matricula = cod_matricula_id
    );

    IF (qtde_carga_horaria IS NULL) THEN
        qtde_carga_horaria := (
            SELECT carga_horaria :: float
            FROM pmieducar.escola_serie_disciplina
            WHERE escola_serie_disciplina.ref_cod_disciplina = cod_disciplina_id
            AND escola_serie_disciplina.ref_ref_cod_serie = cod_serie_id
            AND escola_serie_disciplina.ref_ref_cod_escola = cod_escola_id);
    END IF;

    IF (qtde_carga_horaria IS NULL) THEN
        qtde_carga_horaria := (
            SELECT carga_horaria :: float
            FROM modules.componente_curricular_ano_escolar
            WHERE componente_curricular_ano_escolar.componente_curricular_id = cod_disciplina_id
            AND componente_curricular_ano_escolar.ano_escolar_id = cod_serie_id
        );
    END IF;

    v_hora_falta := (
        SELECT hora_falta :: float
        FROM pmieducar.escola_serie_disciplina
        WHERE escola_serie_disciplina.ref_cod_disciplina = cod_disciplina_id
        AND escola_serie_disciplina.ref_ref_cod_serie = cod_serie_id
        AND escola_serie_disciplina.ref_ref_cod_escola = cod_escola_id
    );

    IF (v_hora_falta IS NULL) THEN
        v_hora_falta := (
            SELECT hora_falta :: float
            FROM modules.componente_curricular_ano_escolar
            WHERE componente_curricular_ano_escolar.componente_curricular_id = cod_disciplina_id
            AND componente_curricular_ano_escolar.ano_escolar_id = cod_serie_id
        );
    END IF;

    IF (v_hora_falta IS NULL) THEN
        v_hora_falta := (
	        SELECT hora_falta
	        FROM pmieducar.curso c
	        INNER JOIN pmieducar.matricula m
	        ON (c.cod_curso = m.ref_cod_curso)
	        WHERE m.cod_matricula = cod_matricula_id
	   );
    END IF;

    IF (qtde_carga_horaria = 0) THEN
        RETURN 0;
    END IF;

    RETURN  trunc((100 - ((v_total_faltas * (v_hora_falta*100))/qtde_carga_horaria))::numeric, 1);

END;
$$;
