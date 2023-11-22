<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Validator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        // $patients = Patient::all();
        // $data = [
        //     'message' => 'Get All patients$patients',
        //     'data' => $patients
        // ];
        // return response()->json($data, 200);
        try {
            $order = $request->order ?? 'asc';
            $sort = $request->sort ?? 'name';
            $pageSize = $request->page_size ?? 5;
            $pageNumber = $request->page_number ?? 1;
            $offset = ($pageNumber - 1) * $pageSize;

            $patients = Patient::query();

            // Filters
            if ($request->has('name')) {
                $patients->where('name', 'like', $request->name . '%');
            }

            if ($request->has('address')) {
                $patients->where('address', 'like', $request->address . '%');
            }

            if ($request->has('status')) {
                $patients->where('status', 'like', $request->status . '%');
            }

            // Sorting
            $patients->orderBy($sort, $order);

            $totalData = $patients->count();
            $totalPage = ceil($totalData / $pageSize);

            $patients = $patients->offset($offset)->limit($pageSize)->get();

            $pages = [
                'pageSize' => (int) $pageSize,
                'pageNumber' => (int) $pageNumber,
                'totalData' => $totalData,
                'totalPage' => $totalPage,
            ];

            $data = [
                'pages' => $pages,
                'table' => $patients,
            ];

            $message = count($patients) > 0 ? 'mencari data semua pasien' : 'data tidak ditemukan';

            return response()->json(['message' => $message, 'data' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'error', 'error' => $th], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'required|date',
        ]);

        #menggunakan model Patient untuk insert data
        $patient = Patient::create($validated);

        $data = [
            'message' => 'Pasien Berhasil Dibuat',
            'data' => $patient
        ];
        #mengembalikan data json dan kode 201
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::where('id', $id)->first();

        if ($patient) {
            $data = [
                'message' => 'Detail Pasien dengan ID ' . $id,
                'data' => $patient
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Pasien dengan ID ' . $id . ' tidak ditemukan.',
            ];
            return response()->json($data, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            $input = [
                'name' => $request->name ?? $patient->name,
                'phone' => $request->phone ?? $patient->phone,
                'address' => $request->address ?? $patient->address,
                'status' => $request->status ?? $patient->status,
                'in_date_at' => $request->in_date_at ?? $patient->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patient->out_date_at
            ];
            $patient->update($input);
            $data = [
                'message' => 'Pasien di Index ' . $id . ' Berhasil Diupdate',
                'data' => $patient
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'patients tidak ditemukan!',
            ];

            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::find($id);
        $patient->delete();

        $data = [
            'message' => 'patients di Index ' . $id . ' Berhasil Dihapus',
            'data' => $patient
        ];

        if ($patient) {

        }

        return response()->json($data, 200);
    }
}
