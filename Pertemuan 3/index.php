<?php

# membuat class Animal
class Animal
{
    # property animals
    private $animals;

    # method constructor - mengisi data awal
    # parameter: data hewan (array)
    public function __construct($data)
    {
        $this->animals = $data;
    }

    # method index - menampilkan data animals
    public function index()
    {
        # gunakan foreach untuk menampilkan data animals (array)
        echo "Data Hewan : ";
        foreach ($this->animals as $animal) {
            echo $animal . ", ";
        }
        echo "<br>";
    }

    # method store - menambahkan hewan baru
    # parameter: hewan baru
    public function store($data)
    {
        # gunakan method array_push untuk menambahkan data baru
        array_push($this->animals, $data);
        echo "Hewan baru berhasil ditambahkan: " . $data . "<br>";
    }

    # method update - mengupdate hewan
    # parameter: index dan hewan baru
    public function update($index, $data)
    {
        if (isset($this->animals[$index])) {
            $this->animals[$index] = $data;
            echo "Hewan di indeks " . $index . " berhasil diperbarui menjadi: " . $data . "<br>";
        } else {
            echo "Indeks " . $index . " tidak valid.<br>";
        }
    }

    # method delete - menghapus hewan
    # parameter: index
    public function destroy($index)
    {
        # gunakan method unset atau array_splice untuk menghapus data array
        if (isset($this->animals[$index])) {
            $removedAnimal = array_splice($this->animals, $index, 1);
            echo "Hewan di indeks " . $index . " berhasil dihapus: " . $removedAnimal[0] . "<br>";
        } else {
            echo "Indeks " . $index . " tidak valid.<br>";
        }
    }
}

# membuat object
# kirimkan data hewan (array) ke constructor
// $animal = new Animal([]);
$animal = new Animal(['kucing']);

echo "Index - Menampilkan seluruh hewan <br>";
$animal->index();
echo "<br>";

echo "Store - Menambahkan hewan baru <br>";
$animal->store('burung');
$animal->index();
echo "<br>";

echo "Update - Mengupdate hewan <br>";
$animal->update(0, 'Kucing Anggora');
$animal->index();
echo "<br>";

echo "Destroy - Menghapus hewan <br>";
$animal->destroy(1);
$animal->index();
echo "<br>";