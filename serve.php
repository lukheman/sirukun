#!/usr/bin/env php
<?php

/**
 * Script Laravel Development Server
 * Otomatis membuka browser ke http://localhost:8000
 *
 * @author    Akmal
 * @instagram @lukheeman
 * @phone     082250223147
 * @portfolio https://lukheman.github.io/portfolio/
 */

// ============================================================
//  Konstanta & Inisialisasi
// ============================================================

define('IS_WIN', PHP_OS_FAMILY === 'Windows');
define('IS_MAC', PHP_OS_FAMILY === 'Darwin');
define('USE_COLOR', IS_WIN
    ? (function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT, true))
    : true
);

const C = [
    'reset'  => "\033[0m",
    'green'  => "\033[32m",
    'yellow' => "\033[33m",
    'blue'   => "\033[34m",
    'cyan'   => "\033[36m",
    'bold'   => "\033[1m",
];

// ============================================================
//  Helper Functions
// ============================================================

function out(string $text, string ...$colors): void
{
    if (USE_COLOR && $colors) {
        $open = implode('', array_map(fn($c) => C[$c] ?? '', $colors));
        echo $open . $text . C['reset'] . PHP_EOL;
    } else {
        echo $text . PHP_EOL;
    }
}

function ok(string $msg): void   { out('  ✔  ' . $msg, 'green'); }
function info(string $msg): void { out('  ➜  ' . $msg, 'blue'); }
function warn(string $msg): void { out('  ⚠  ' . $msg, 'yellow'); }

/** Buka browser sesuai OS */
function openBrowser(string $url): void
{
    info("Membuka browser ke {$url}...");

    if (IS_WIN) {
        pclose(popen("start {$url}", "r"));
        return;
    }

    if (IS_MAC) {
        exec("open {$url} > /dev/null 2>&1 &");
        return;
    }

    // Linux — coba satu per satu
    $launchers = ['xdg-open', 'gnome-open', 'kde-open', 'sensible-browser', 'x-www-browser'];
    foreach ($launchers as $bin) {
        if (!empty(trim(shell_exec("which {$bin} 2>/dev/null") ?? ''))) {
            exec("{$bin} {$url} > /dev/null 2>&1 &");
            return;
        }
    }

    warn("Tidak dapat membuka browser secara otomatis.");
    warn("Silahkan buka manual: {$url}");
}

// ============================================================
//  MAIN
// ============================================================

chdir(__DIR__);
$url = 'http://localhost:8000';

out('');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('|' . str_pad('  SIMKA - SERVER', 63) . '|', 'bold', 'green');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('');
info("Lokasi Project : " . __DIR__);
info("Server URL     : {$url}");
out('');
ok('Menjalankan server development...');
out('');

// Buka browser di background setelah server sempat start
if (IS_WIN) {
    pclose(popen("ping -n 3 127.0.0.1 > nul && start {$url}", "r"));
} else {
    exec("(sleep 2 && xdg-open {$url} 2>/dev/null || open {$url} 2>/dev/null) &");
}

passthru('php artisan serve');
