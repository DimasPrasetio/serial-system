<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    /**
     * Data perusahaan yang digunakan di seluruh halaman publik.
     * Ubah nilai-nilai di sini tanpa perlu menyentuh view.
     */
    private array $company = [
        'name' => 'ElcodeLabs',
        'legal_name' => 'PT. Prayora Karya Pratama',
        'tagline' => 'Digitalisasi Operasional untuk Bisnis yang Berkembang',
        'whatsapp' => '085173471146',
        'whatsapp_intl' => '6285173471146', // format internasional tanpa +
        'email' => 'amandayora1@gmail.com',
        'city' => 'Bandung, Jawa Barat',
        'country' => 'Indonesia',
    ];

    /**
     * Tampilkan halaman Company Profile.
     */
    public function companyProfile(): \Illuminate\Http\Response
    {
        $company = $this->buildCompany();

        return response()
            ->view('pages.company-profile', compact('company'))
            ->header('Cache-Control', 'public, max-age=3600, s-maxage=86400');
    }

    /**
     * Tampilkan halaman Kebijakan Privasi.
     */
    public function privacyPolicy(): \Illuminate\Http\Response
    {
        $company = $this->buildCompany();

        return response()
            ->view('pages.privacy-policy', compact('company'))
            ->header('Cache-Control', 'public, max-age=3600, s-maxage=86400');
    }

    /**
     * Tampilkan halaman Ketentuan Layanan.
     */
    public function termsOfService(): \Illuminate\Http\Response
    {
        $company = $this->buildCompany();

        return response()
            ->view('pages.terms-of-service', compact('company'))
            ->header('Cache-Control', 'public, max-age=3600, s-maxage=86400');
    }

    /**
     * Tampilkan robots.txt untuk search engine.
     */
    public function robots(): \Illuminate\Http\Response
    {
        return response()
            ->view('robots')
            ->header('Content-Type', 'text/plain')
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Tampilkan sitemap.xml untuk search engine.
     */
    public function sitemap(): \Illuminate\Http\Response
    {
        return response()
            ->view('sitemap')
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=43200');
    }

    private function buildCompany(): array
    {
        $company = $this->company;
        $company['whatsapp_url'] = 'https://wa.me/' . $company['whatsapp_intl'];
        $company['mailto_url'] = 'mailto:' . $company['email'];
        $company['maps_url'] = 'https://maps.google.com/?q=' . urlencode($company['city'] . ', ' . $company['country']);

        return $company;
    }
}
