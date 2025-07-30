<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Division;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $divisions = Division::all();

        $employees = [
            ['name' => 'John Doe', 'phone' => '081234567890', 'position' => 'Senior Developer'],
            ['name' => 'Jane Smith', 'phone' => '081234567891', 'position' => 'QA Engineer'],
            ['name' => 'Bob Johnson', 'phone' => '081234567892', 'position' => 'Mobile Developer'],
            ['name' => 'Alice Brown', 'phone' => '081234567893', 'position' => 'UI/UX Designer'],
            ['name' => 'Charlie Wilson', 'phone' => '081234567894', 'position' => 'Backend Developer'],
            ['name' => 'Diana Davis', 'phone' => '081234567895', 'position' => 'Frontend Developer'],
            ['name' => 'Edward Miller', 'phone' => '081234567896', 'position' => 'Full Stack Developer'],
            ['name' => 'Fiona Garcia', 'phone' => '081234567897', 'position' => 'QA Tester'],
        ];

        foreach ($employees as $index => $employee) {
            Employee::create([
                'name' => $employee['name'],
                'phone' => $employee['phone'],
                'position' => $employee['position'],
                'division_id' => $divisions->random()->id,
                'image' => null, // Nanti bisa diisi via API create
            ]);
        }
    }
}
