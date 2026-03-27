<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        <lastmod>{{ now()->toDateString() }}</lastmod>
    </url>
    <url>
        <loc>{{ route('public.privacy') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ route('public.terms') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.3</priority>
    </url>
</urlset>
