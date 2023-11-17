<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $students = Student::all();
        // $data = [
        //     'message' => 'Get All Students',
        //     'data' => $students
        // ];
        // return response()->json($data, 200);
        try {
            $students = Student::all();

            $order = (isset($request->order)) ? $request->order : NULL;
            if ($order == NULL) {
                $order = 'asc';
            }
            $sort = (isset($request->sort)) ? $request->sort : NULL;
            if ($sort == NULL) {
                $sort = 'nama';
            }
            $pageSize = (isset($request->page_size)) ? $request->page_size : 5;
            $pageNumber = (isset($request->page_number)) ? $request->page_number : 1;
            $offset = ($pageNumber - 1) * $pageSize;
            $pages = [];
            $pages['pageSize'] = (int) $pageSize;
            $pages['pageNumber'] = (int) $pageNumber;

            $students = Student::query();
            $name = (isset($request->nama)) ? $request->nama : NULL;
            if ($name != NULL) {
                $students = $students->where('nama', $name);
            }

            $students = $students->orderBy($sort, $order)->offset($offset)
                ->limit($pageSize)->get();

            // get total
            $studentTotal = Student::query();
            $name = (isset($request->nama)) ? $request->nama : NULL;
            if ($name != NULL) {
                $studentTotal = $studentTotal->where('nama', $name);
            }

            $pageSize = (isset($request->page_size)) ? $request->page_size : 5;
            $pageNumber = (isset($request->page_number)) ? $request->page_number : 1;
            $offset = ($pageNumber - 1) * $pageSize;

            $studentTotal = $studentTotal->count();
            ;

            $pages['totalData'] = $studentTotal;
            $totalPage = ceil($studentTotal / $pageSize);
            $pages['totalPage'] = $totalPage;

            $data = [];
            $data['pages'] = $pages;
            $data['table'] = $students;

            if (count($students) > 0) {
                $result = [
                    "message" => "get all students",
                    "data" => $data
                ];
            } else {
                $result = [
                    'message' => "data not found"
                ];
            }

            return response()->json($result, 200);

        } catch (\Throwable $th) {
            return response()->json(["message" => "error", "error" => $th], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'nim' => 'required|numeric',
            'email' => 'required|email',
            'jurusan' => 'required',
        ]);

        #menggunakan model student untuk insert data
        $student = Student::create($validated);

        $data = [
            'message' => 'Student is Created Successfully',
            'data' => $student
        ];
        #mengembalikan data json dan kode 201
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::where('id', $id)->first();

        if ($student) {
            $data = [
                'message' => 'Detail Mahasiswa dengan ID ' . $id,
                'data' => $student
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Mahasiswa dengan ID ' . $id . ' tidak ditemukan.',
            ];
            return response()->json($data, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if ($student) {
            $input = [
                'nama' => $request->nama ?? $student->nama,
                'nim' => $request->nim ?? $student->nim,
                'jurusan' => $request->jurusan ?? $student->jurusan,
                'email' => $request->email ?? $student->email
            ];
            $student->update($input);
            $data = [
                'message' => 'Students di Index ' . $id . ' Berhasil Diupdate',
                'data' => $student
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Students tidak ditemukan!',
            ];

            return response()->json($data, 404);
        }
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

        if ($student) {

        }

        return response()->json($data, 200);
    }
}
