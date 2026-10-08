<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

use App\Models\Course;





Route::get('/', function () {
    return view('welcome');
});

// Show the create form
Route::get('/students/create', function () {
    return view('student.create');
});

// Handle the form submission
Route::post('/students', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255',
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
});

Route::get('/students', function () {
    $students = Student::all();
    return view('student.list', ['students' => $students]);
})->name('students.index');

Route::get('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);
    return view('student.detail', ['student' => $student]);
});


// Show edit form
Route::get('/students/{id}/edit', function ($id) {
    $student = Student::findOrFail($id);
    return view('student.edit', ['student' => $student]);
});

// Handle update
Route::put('/students/{id}', function (Request $request, $id) {
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => ['required', 'email', 'max:255',
                            Rule::unique('students')->ignore($student->id)],
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);

    return redirect()->route('students.index')
        ->with('success', 'Student updated successfully!');
});

// Delete routes

Route::delete('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $student->delete();

    return redirect('/students')
        ->with('success', 'Student deleted successfully!');
});


//COURSE ROUTES 

// List all courses
Route::get('/courses', function () {
    $courses = Course::all();
    return view('course.list', ['courses' => $courses]);
});

// Show create form
Route::get('/courses/create', function () {
    return view('course.create');
});

// Store new course
Route::post('/courses', function (Request $request) {
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'duration'    => 'required|integer|min:1',
        'fee'         => 'required|numeric|min:0',
        'difficulty'  => 'required|in:Easy,Medium,Hard',
        'is_active'   => 'boolean',
    ]);

    // Convert checkbox to boolean
    $validated['is_active'] = $request->boolean('is_active');

    $course = Course::create($validated);

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
});

// Show single course
Route::get('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    return view('course.detail', ['course' => $course]);
})->name('courses.show');

// Show edit form
Route::get('/courses/{id}/edit', function ($id) {
    $course = Course::findOrFail($id);
    return view('course.edit', ['course' => $course]);
})->name('courses.edit');

// Update course
Route::put('/courses/{id}', function (Request $request, $id) {
    $course = Course::findOrFail($id);

    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'duration'    => 'required|integer|min:1',
        'fee'         => 'required|numeric|min:0',
        'difficulty'  => 'required|in:Easy,Medium,Hard',
        'is_active'   => 'boolean',
    ]);

    $validated['is_active'] = $request->boolean('is_active');

    $course->update($validated);

    return redirect()->route('courses.index')
        ->with('success', 'Course updated successfully!');
});

// Delete course
Route::delete('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    $course->delete();

    return redirect('/courses')
        ->with('success', 'Course deleted successfully!');
});

// List all courses
Route::get('/courses', function () {
    $courses = Course::all();
    return view('course.list', ['courses' => $courses]);
})->name('courses.index');   