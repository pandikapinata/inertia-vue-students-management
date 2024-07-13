<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\KelasResource;
use App\Http\Resources\StudentResource;
use App\Models\Kelas;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = StudentResource::collection(Student::paginate(10));
        return inertia('Students/Index', ['students' => $students]);
    }

    public function create() {
        $kelas = KelasResource::collection(Kelas::all());
        return inertia('Students/Create', [
            'kelas' => $kelas
        ]);
    }

    public function store(StoreStudentRequest $request) {
        Student::create($request->validated());
        return redirect()->route('students.index');
    }

    public function edit(Student $student) {
        $kelas = KelasResource::collection(Kelas::all());

        return inertia('Students/Edit', [
            'student' => StudentResource::make($student),
            'kelas' => $kelas
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student) {
        $student->update($request->validated());
        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index');
    }
}
