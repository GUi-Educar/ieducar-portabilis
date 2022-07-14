<?php

namespace App\Models;

use App\Models\Builders\LegacySchoolAcademicYearBuilder;
use App\Traits\LegacyAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LegacySchoolAcademicYear extends Model
{
    use LegacyAttribute;

    /**
     * @var string
     */
    protected $table = 'pmieducar.escola_ano_letivo';

    /**
     * @var string
     */
    protected $primaryKey = 'ref_cod_escola';

    /**
     * Builder dos filtros
     *
     * @var string
     */
    protected $builder = LegacySchoolAcademicYearBuilder::class;

    /**
     * Atributos legados para serem usados nas queries
     *
     * @var string[]
     */
    public $legacy = [
        'year' => 'ano'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'ref_cod_escola',
        'ano',
        'ref_usuario_cad',
        'ref_usuario_exc',
        'andamento',
        'data_cadastro',
        'data_exclusao',
        'ativo',
        'turmas_por_ano',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function scopeActive(Builder $builder)
    {
        return $builder->where('escola_ano_letivo.ativo', 1);
    }

    public function scopeLastYear(Builder $query): Builder
    {
        return $query->where('escola_ano_letivo.ano', date('Y') - 1);
    }

    public function scopeCurrentYear(Builder $query): Builder
    {
        return $query->where('escola_ano_letivo.ano', date('Y'));
    }

    /**
     * @return int
     */
    public function getYearAttribute(): int {
        return $this->ano;
    }

    /**
     * Filtra por ano letivos em andamento
     *
     * @param Builder $query
     * @return void
     */
    public function scopeInProgress(Builder $query): void
    {
        $query->where('escola_ano_letivo.andamento',1);
    }

    /**
     * Filtra pelo ano
     *
     * @param Builder $query
     * @param int $year
     * @return void
     */
    public function scopeWhereYear(Builder $query, int $year ): void
    {
        $query->where('escola_ano_letivo.ano',$year);
    }

    /**
     * Ordena por Ano
     *
     * @param Builder $query
     * @param string $direction
     * @return void
     */
    public function scopeOrderByYear(Builder $query, string $direction = 'desc'): void
    {
        $query->orderBy('ano',$direction);
    }

    /**
     * Filtra por Instituição
     *
     * @param Builder $query
     * @param int $school
     * @return void
     */
    public function scopeWhereSchool(Builder $query, int $school): void
    {
        $query->where('ref_cod_escola', $school);
    }

    /**
     * Filtra por anos maiores
     *
     * @param Builder $query
     * @param int $year
     * @return void
     */
    public function scopeWhereGteYear(Builder $query, int $year): void
    {
        $query->where('ano', '>=', $year);
    }

}
