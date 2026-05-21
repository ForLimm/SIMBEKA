<?php

$dir = new RecursiveDirectoryIterator('c:\laragon\www\simbeka\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$replacements = [
    '/rounded-\[2\.5rem\]/' => 'rounded-lg',
    '/rounded-xl/' => 'rounded-lg',
    '/rounded-2xl/' => 'rounded-lg',
    '/<div class="absolute[^"]*blur-3xl[^"]*"><\/div>/is' => '',
    '/<div class="absolute[^"]*opacity-\[0\.03\][^"]*">\s*<svg.*?>.*?<\/svg>\s*<\/div>/is' => '',
    '/uppercase tracking-\[0\.2em\]/i' => '',
    '/w-20 h-20/' => 'w-12 h-12', // Slightly smaller icons
    '/text-\[10px\] font-bold font-medium/' => 'text-xs text-slate-500 font-medium'
];

$count = 0;
foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    foreach ($replacements as $pattern => $replacement) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    file_put_contents($path, $content);
    $count++;
}

echo "Processed $count files for second pass UI cleanup.\n";
