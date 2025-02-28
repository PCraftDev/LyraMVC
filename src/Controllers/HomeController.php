<?php

namespace Lyramvc\Lyramvc\Controllers;

use Lyramvc\Lyramvc\Core\View; // Mengimpor class View untuk merender tampilan

class HomeController
{
    protected $userModel; // Properti untuk menampung instance model

    // Konstruktor untuk menginisialisasi model
    public function __construct()
    {
        //
    }

    // Method untuk menampilkan data user
    public function index()
    {
        // Mengirim data pengguna ke tampilan untuk dirender
        View::render('Wellcome', ['title' => 'Wellcome']); // 🔥 Render view dengan data
    }
}
