<?php

namespace Tests\Unit\Eloquent;

use App\Models\EmployeeAllocation;
use App\Models\School;
use Database\Factories\EmployeeAllocationFactory;
use Tests\EloquentTestCase;

class EmployeeAllocationTest extends EloquentTestCase
{
    /**
     * @return string
     */
    protected function getEloquentModelName()
    {
        return EmployeeAllocation::class;
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->employeeAllocation = EmployeeAllocationFactory::new()->create();

    }

    public function testRelationshipSchool()
    {
        $this->assertInstanceOf(School::class, $this->employeeAllocation->school);
    }
}
