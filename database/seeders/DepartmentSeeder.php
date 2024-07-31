<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::create(['name' => 'IT']);
        Department::create(['name' => 'HR']);
        Department::create(['name' => 'Finance']);
    }
}
