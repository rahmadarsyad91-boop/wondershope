@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url><loc>{{ url('/') }}</loc><changefreq>daily</changefreq><priority>1.0</priority><lastmod>{{ now()->toW3cString() }}</lastmod></url>
<url><loc>{{ url('/login') }}</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
<url><loc>{{ url('/register') }}</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
@foreach ($products as $product)
<url><loc>{{ url('/product/' . $product->slug) }}</loc><changefreq>weekly</changefreq><priority>0.8</priority><lastmod>{{ $product->updated_at->toW3cString() }}</lastmod></url>
@endforeach
</urlset>
