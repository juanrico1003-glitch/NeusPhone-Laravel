<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('tienda') }}</loc>
        <priority>0.9</priority>
    </url>
    @foreach($categorias as $cat)
    <url>
        <loc>{{ route('tienda', ['categoria' => $cat->id]) }}</loc>
        <priority>0.8</priority>
    </url>
    @endforeach
    @foreach($productos as $p)
    <url>
        <loc>{{ route('tienda.producto', $p->id) }}</loc>
        <priority>0.7</priority>
        <lastmod>{{ $p->updated_at?->toW3cString() ?? $p->created_at?->toW3cString() }}</lastmod>
    </url>
    @endforeach
</urlset>
