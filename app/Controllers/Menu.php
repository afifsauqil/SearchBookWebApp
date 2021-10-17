<?php

namespace App\Controllers;

use App\Models\MenuModel;

class Menu extends BaseController
{
    protected $menuModel;
    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }
    public function index()
    {
        // $buku = $this->menuModel->findAll();

        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->menuModel->getBuku()
        ];

        // $menuModel = new \App\Models\MenuModel();
        // $menuModel = new MenuModel();


        return view('menu/index', $data);
    }

    public function detail($slug)
    {
        $buku = $this->menuModel->getBuku($slug);
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->menuModel->getBuku($slug)
        ];

        // jika komik tidak ada di tabel
        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul buku ' . $slug . ' tidak ditemukan.');
        }

        return view('menu/detail', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'title' => 'Form Tambah Data Buku',
            'validation' => \Config\Services::validation()
        ];

        return view('menu/create', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[buku.judul]',
                'errors' => [
                    'required' => '{field} buku harus diisi.',
                    'is_unique' => '{field} buku sudah terdaftar.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Harus format png atau jpg'
                ]
            ]
        ])) {
            return redirect()->to('/menu/create')->withInput();
        }

        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //apakah tidak ada gambar yang diupload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            // pindahkan file ke folder img
            $fileSampul->move('img');
            // ambil nama file sampul
            $namaSampul = $fileSampul->getName();
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->menuModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sinopsis' => $this->request->getVar('sinopsis'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/menu');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $buku = $this->menuModel->find($id);

        //cek jika file gambarnya default.png
        if ($buku['sampul'] != 'default.png') {
            // hapus gambar
            unlink('img/' . $buku['sampul']);
        }

        $this->menuModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/menu');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Buku',
            'validation' => \Config\Services::validation(),
            'buku' => $this->menuModel->getBuku($slug)
        ];

        return view('menu/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $bukuLama = $this->menuModel->getBuku($this->request->getVar('slug'));
        if ($bukuLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[buku.judul]';
        }

        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus diisi.',
                    'is_unique' => '{field} buku sudah terdaftar.'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Harus format png atau jpg'
                ]
            ]
        ])) {
            return redirect()->to('/menu/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // pindahkan file ke folder img
            $fileSampul->move('img');
            // ambil nama file sampul
            $namaSampul = $fileSampul->getName();
            // hapus  file lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->menuModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sinopsis' => $this->request->getVar('sinopsis'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/menu');
    }
}
