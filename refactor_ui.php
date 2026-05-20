<?php

$dir = new RecursiveDirectoryIterator('c:\laragon\www\simbeka\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    '/rounded-3xl/' => 'rounded-xl',
    '/rounded-2xl/' => 'rounded-lg',
    '/font-black uppercase tracking-widest/i' => 'font-medium',
    '/uppercase tracking-widest/i' => 'font-medium',
    '/font-black/i' => 'font-semibold',
    '/card-premium/i' => 'bg-white border border-slate-200 rounded-xl shadow-sm',
    '/shadow-2xl shadow-[^\s\'"]+/' => 'shadow-md',
    '/shadow-lg shadow-[^\s\'"]+/' => 'shadow-sm',
    '/class="absolute -right-4 -top-4 opacity-[0-9]+".*?<\/div>/is' => ''
];

$count = 0;
foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    // Remove the AI watermark SVGs using a multi-line regex
    $content = preg_replace('/<div class="absolute -right-4 -top-4 opacity-5">\s*<svg.*?>.*?<\/svg>\s*<\/div>/is', '', $content);

    foreach ($replacements as $pattern => $replacement) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    file_put_contents($path, $content);
    $count++;
}

echo "Processed $count files.\n";

