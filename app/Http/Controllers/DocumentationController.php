<?php

namespace App\Http\Controllers;

use League\CommonMark\CommonMarkConverter;

class DocumentationController extends Controller
{
    public function apiContract()
    {
        $path = base_path('docs/API_CONTRACT.md');

        abort_unless(file_exists($path), 404, 'File dokumentasi API Contract belum tersedia.');

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $html = $converter->convert(file_get_contents($path))->getContent();

        return view('docs.api-contract', ['html' => $html]);
    }
}