<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Siswa;

class SiswaPdfController extends Controller
{
    public function generateSiswaPdf()
    {
        // Ambil data siswa dari database
        $siswas = Siswa::all();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Inisialisasi Dompdf
        $pdf = new Dompdf($options);

        // Render view HTML
        $html = view('dompdf.siswa', compact('siswas'))->render();
        $pdf->loadHtml($html);

        // Pengaturan ukuran halaman dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Render PDF
        $pdf->render();

        // Mengirimkan PDF sebagai respons ke browser
        return $pdf->stream('siswas.pdf');
    }
}
