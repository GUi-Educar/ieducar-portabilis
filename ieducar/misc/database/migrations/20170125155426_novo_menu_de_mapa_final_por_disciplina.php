<?php

use Phinx\Migration\AbstractMigration;

class NovoMenuDeMapaFinalPorDisciplina extends AbstractMigration
{
    public function up()
    {
        $this->execute("INSERT INTO portal.menu_submenu VALUES (999884,55,2,'Mapa final por disciplina','module/Reports/MapaFinalPorDisciplina',NULL,3);");
        $this->execute("INSERT INTO pmicontrolesis.menu VALUES (999884,999884,999450,'Mapa final por disciplina',6,'module/Reports/MapaFinalPorDisciplina','_self',1,15,192);");
        $this->execute("INSERT INTO pmieducar.menu_tipo_usuario VALUES(1,999884,1,1,1);");
    }

    public function down()
    {
        $this->execute("DELETE FROM pmieducar.menu_tipo_usuario WHERE ref_cod_menu_submenu = 999876;");
        $this->execute("DELETE FROM pmicontrolesis.menu WHERE cod_menu = 999884;");
        $this->execute("DELETE FROM portal.menu_submenu WHERE cod_menu_submenu = 999884;");
    }
}
