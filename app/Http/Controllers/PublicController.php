<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    /**
     * Data perusahaan yang digunakan di seluruh halaman publik.
     * Ubah nilai-nilai di sini tanpa perlu menyentuh view.
     */
    private array $company = [
        'name'          => 'ElcodeLabs',
        'tagline'       => 'Mitra Digital untuk Bisnis Terstruktur',
        'whatsapp'      => '085173471146',
        'whatsapp_intl' => '6285173471146', // format internasional tanpa +
        'email'         => 'amandayora1@gmail.com',
        'city'          => 'Bandung, Jawa Barat',
        'country'       => 'Indonesia',
    ];

    /**
     * Tampilkan halaman Company Profile.
     */
    public function companyProfile(): \Illuminate\View\View
    {
        $company = $this->company;

        // URL siap pakai untuk link
        $company['whatsapp_url'] = 'https://wa.me/' . $company['whatsapp_intl'];
        $company['mailto_url']   = 'mailto:' . $company['email'];
        $company['maps_url']     = 'https://maps.google.com/?q=' . urlencode($company['city'] . ', ' . $company['country']);

        return view('pages.company-profile', compact('company'));
    }
}
