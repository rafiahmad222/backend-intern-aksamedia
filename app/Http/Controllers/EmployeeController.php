<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'division_id' => 'nullable|uuid|exists:divisions,id',
        ]);

        $query = Employee::with('division');

        // Filter berdasarkan nama jika ada
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter berdasarkan divisi jika ada
        if ($request->has('division_id') && !empty($request->division_id)) {
            $query->where('division_id', $request->division_id);
        }

        $employees = $query->paginate(10);

        // Format response sesuai requirement
        $formattedEmployees = $employees->getCollection()->map(function ($employee) {
            return [
                'id' => $employee->id,
                'image' => $employee->image,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'division' => [
                    'id' => $employee->division->id,
                    'name' => $employee->division->name,
                ],
                'position' => $employee->position,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diambil',
            'data' => [
                'employees' => $formattedEmployees,
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ],
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division' => 'required|uuid|exists:divisions,id',
            'position' => 'required|string|max:255',
        ]);

        $imageName = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Simpan langsung ke public/storage/employees
            $path = $image->storeAs('employees', $imageName, 'public');
        }

        // Create employee
        $employee = Employee::create([
            'image' => $path,
            'name' => $request->name,
            'phone' => $request->phone,
            'division_id' => $request->division,
            'position' => $request->position,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil ditambahkan',
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // Cari employee berdasarkan UUID
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division' => 'required|uuid|exists:divisions,id',
            'position' => 'required|string|max:255',
        ]);

        // Update field tanpa image
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->division_id = $request->division;
        $employee->position = $request->position;

        $employee->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diperbarui',
        ]);
    }
    public function updateImage(Request $request, $id)
    {
        // Cari employee berdasarkan UUID
        $employee = Employee::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload new image
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('employees', $imageName, 'public');

        // Update dengan assignment biasa
        $employee->image = $imagePath;
        $employee->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Foto karyawan berhasil diperbarui',
            'data' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'image_path' => $imagePath,
                'image_url' => url('storage/' . $imagePath)
            ]
        ]);
    }
    public function destroy($id)
    {
        // Cari employee berdasarkan UUID
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data karyawan tidak ditemukan',
            ], 404);
        }

        // Delete image file if exists
        if ($employee->getRawOriginal('image')) {
            $imagePath = storage_path('app/public/' . $employee->getRawOriginal('image'));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete employee from database
        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil dihapus',
        ]);
    }
}
