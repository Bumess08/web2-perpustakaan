<?php
class Buku
{
    public $id;
    public $judul;
    public $pengarang;
    public $tahun_terbit;
    public $status;
    public $isbn;
    public $penerbit;

    public function __construct($id, $judul, $pengarang, $tahun_terbit, $status, $isbn, $penerbit)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->pengarang = $pengarang;
        $this->tahun_terbit = $tahun_terbit;
        $this->status = $status;
        $this->isbn = $isbn;
        $this->penerbit = $penerbit;
    }
}

class Perpustakaan
{
    public $koleksi = array();
    public $pinjamin = array();
    public $limitPinjam = 6;
    public $biayaDendaPerHari = 500;

    public function tambahBuku($buku)
    {
        array_push($this->koleksi, $buku);
    }

    public function pinjamBuku($id)
    {
        $buku = $this->findBookById($id);
        if ($buku) {
            if (count($this->pinjamin) >= $this->limitPinjam) {
                return "Peminjaman sudah mencapai batas";
            }
            if ($buku->status == 1) {
                $buku->status = 0;
                $this->pinjamin[$id] = $buku;
                return "Buku berhasil dipinjam";
            } else {
                return "Buku tidak tersedia";
            }
        }
        return "Buku tidak ditemukan";
    }

    public function kembalikanBuku($id, $hariTerlambat)
    {
        $buku = $this->findBookById($id);
        if ($buku) {
            if ($this->isBookBorrowed($id)) {
                $buku->status = 1;
                unset($this->pinjamin[$id]);
                $dendaTerlambat = $hariTerlambat * $this->biayaDendaPerHari;
                return $dendaTerlambat;
            } else {
                return "Buku tidak dipinjam";
            }
        }
        return "Buku tidak ditemukan";
    }

    private function findBookById($id)
    {
        foreach ($this->koleksi as $buku) {
            if ($buku->id == $id) {
                return $buku;
            }
        }
        return false;
    }

    private function isBookBorrowed($id)
    {
        return isset($this->pinjamin[$id]);
    }

    public function cariBuku($katakunci)
  {
    $hasil = [];
    foreach ($this->koleksi as $buku) {
      if (stripos($buku->judul, $katakunci) !== false || stripos($buku->pengarang, $katakunci) !== false) {
        $hasil[] = $buku;
      }
    }
    return $hasil;
  }
}

$dataBuku = [
    [1, "Prisoner of Azkaban", "J.K. Rowling", 1999, 1, "978-0-7475-4215-2", "Bloomsbury"],
    [2, "Goblet of Fire", "J.K. Rowling", 2000, 1, "978-0-7475-4624-1", "Bloomsbury"],
    [3, "Order of the Phoenix", "J.K. Rowling", 2003, 1, "978-0-7475-5100-7", "Bloomsbury"],
    [4, "Half-Blood Prince", "J.K. Rowling", 2005, 1, "978-0-7475-8108-1", "Bloomsbury"],
    [5, "Deathly Hallows", "J.K. Rowling", 2007, 1, "978-0-545-01022-1", "Arthur A. Levine Books"],
    [6, "The Da Vinci Code", "Dan Brown", 2003, 1, "978-0-385-50420-5", "Doubleday"],
    [7, "Angels & Demons", "Dan Brown", 2000, 1, "978-0-671-02735-7", "Pocket Books"],
    [8, "The Girl with the Dragon Tattoo", "Stieg Larsson", 2005, 1, "978-0-307-26926-0", "Norstedts Förlag"],
    [9, "The Hunger Games", "Suzanne Collins", 2008, 1, "978-0-439-02348-1", "Scholastic"],
    [10, "The Girl on the Train", "Paula Hawkins", 2015, 1, "978-1-59-463402-4", "Riverhead Books"],
];

$perpustakaan = new Perpustakaan();

foreach ($dataBuku as $buku) {
    $perpustakaan->tambahBuku(new Buku($buku[0], $buku[1], $buku[2], $buku[3], $buku[4], $buku[5], $buku[6]));
}

$katakunci = isset($_GET['katakunci']) ? $_GET['katakunci'] : '';

if (!empty($katakunci)) {
    $hasilPencarian = $perpustakaan->cariBuku($katakunci);
} else {
    $hasilPencarian = $perpustakaan->koleksi;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['borrow'])) {
        $id = $_POST['book_id'];
        $message = $perpustakaan->pinjamBuku($id);
        echo "<script>alert('$message');</script>";
    } elseif (isset($_POST['return'])) {
        $id = $_POST['book_id'];
        $lateFee = $perpustakaan->kembalikanBuku($id, 0);
        if (is_numeric($lateFee)) {
            echo "<script>alert('Buku berhasil dikembalikan. Denda keterlambatan: $' + $lateFee);</script>";
        } else {
            echo "<script>alert('$lateFee');</script>";
        }
    }
}
