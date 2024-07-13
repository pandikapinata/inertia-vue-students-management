<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\KelasResource;
use App\Http\Resources\StudentResource;
use App\Models\Kelas;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $studentQuery = Student::query();

        $studentQuery = $this->applySearch($studentQuery, $request->input('search'));

        return inertia('Students/Index', [
            'students' => StudentResource::collection(
                $studentQuery
                ->paginate(5)
                ->withQueryString() // to keep the query string on pagination
            ),
            'filters' => $request->only(['search']),
        ]);
    }

    protected function applySearch(Builder $query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
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
