<?php

namespace App\Models;

use iEducar\Modules\Unification\PersonLogUnification;
use iEducar\Modules\Unification\StudentLogUnification;
use Illuminate\Database\Eloquent\Model;

class LogUnification extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(Individual::class, 'updated_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Individual::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function main()
    {
        return $this->morphTo(null, 'type', 'main_id');
    }

    public function getDuplicatesIdAttribute($value)
    {
        return json_decode($value, false);
    }

    /**
     * @return string
     */
    public function getMainName()
    {
        return $this->getAdapter()->getMainPersonName($this);
    }

    public function getDuplicatesName()
    {
        return $this->getAdapter()->getDuplicatedPeopleName($this);
    }

    /**
     * @return PersonLogUnification|StudentLogUnification
     */
    private function getAdapter()
    {
        if ($this->type == Individual::class) {
            $adapter = new PersonLogUnification();
        }

        if ($this->type == Student::class) {
            $adapter = new StudentLogUnification();
        }

        return $adapter;
    }
}
