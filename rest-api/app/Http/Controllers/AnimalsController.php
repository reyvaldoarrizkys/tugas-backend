<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalsController extends Controller
{
    private $animals = ['kucing'];
    public function index()
    {
        // echo "Menampilkan Data Animals";
        return response()->json($this->animals);
    }

    public function store(Request $request)
    {
        // echo "Nama Hewan : $request->nama";
        // echo "<br>";
        // echo "Menambahkan Data animals";
        $data = $request->input('animal');
        array_push($this->animals, $data);
        return response()->json('Hewan baru berhasil ditambahkan: ' . $data);
    }
    public function update(Request $request, $id)
    {
        // echo "Nama Hewan : $request->nama";
        // echo "<br>";
        // echo "Mengedit Data animals : $id";
        if (isset($this->animals[$id])) {
            $data = $request->input('animal');
            $this->animals[$id] = $data;
            return response()->json('Hewan di indeks ' . $id . ' berhasil diperbarui menjadi: ' . $data);
        } else {
            return response()->json('Indeks ' . $id . ' tidak valid.', 404);
        }
    }
    public function destroy($id)
    {
        // if (isset($this->animals[$id])) {
        //     $removedAnimal = array_splice($this->animals, $id, 1);
        //     return response()->json('Hewan di indeks ' . $id . ' berhasil dihapus: ' . $removedAnimal[0]);
        // } else {
        //     return response()->json('Indeks ' . $id . ' tidak valid.', 404);
        // }
        if (isset($this->animals[$id])) {
            $removedAnimal = array_splice($this->animals, $id, 1);
            return response()->json('Hewan di indeks ' . $id . ' berhasil dihapus: ' . $removedAnimal[0]);
        } else {
            return response()->json('Indeks ' . $id . ' tidak valid.', 404);
        }
    }
}
