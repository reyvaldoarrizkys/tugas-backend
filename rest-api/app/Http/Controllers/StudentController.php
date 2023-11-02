<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        $data = [
            'message' => 'Get All Students',
            'data'=> $students
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = [
            'nama'=> $request->nama,
            'nim'=> $request->nim,
            'email'=> $request->email,
            'jurusan'=> $request->jurusan,
        ];
        #menggunakan model student untuk insert data
        $student = Student::create($input);

        $data = [
            'message'=> 'Student is Created Successfully',
            'data'=> $student
        ];
        #mengembalikan data json dan kode 201
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $input = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'email' => $request->email
        ];
        $student->update($input);
        $data = [
            'message' => 'Students di Index ' . $id . ' Berhasil Diupdate',
            'data' => $student
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        $student->delete();

        $data = [
            'message' => 'Students di Index ' . $id . ' Berhasil Dihapus',
            'data' => $student
        ];

        return response()->json($data, 200);
    }
}
