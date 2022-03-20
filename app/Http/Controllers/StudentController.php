<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('id','desc')->get();
        return view('student.index',compact('students'));
    }
    public function addStudent(Request $request)
    {
        $data  = $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
        ]);
        Student::create($data);
        return redirect()->back()->with('message','Student Added Successfully!!!');
    }
    public function getStudentById($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }
    public function updateStudent(Request $request,Student $student)
    {
        $student = Student::find($request->id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->update();
        // $data = $this->validate($request,[
        //     'first_name'=>'required',
        //     'last_name'=>'required',
        //     'email'=>'required',
        //     'id'=> 'required'
        // ]);
        // $student->update($data);
        return response()->json($student);
    }
    public function delete($id)
    {
        $student=Student::find($id);
        $student->delete();
    }
}
