#!/usr/bin/env php
<?php

/**
 * Script Setup Project Laravel
 *
 * 1. Composer install
 * 2. Copy .env.example ke .env
 * 3. Generate application key
 * 4. Konfigurasi database MySQL
 * 5. Migrasi database
 * 6. Seeder database
 * 7. Pengecekan akhir & artisan serve
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
define('USE_COLOR', IS_WIN
    ? (function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT, true))
    : true
);

const C = [
    'reset'  => "\033[0m",
    'green'  => "\033[32m",
    'red'    => "\033[31m",
    'yellow' => "\033[33m",
    'blue'   => "\033[34m",
    'cyan'   => "\033[36m",
    'bold'   => "\033[1m",
    'dim'    => "\033[2m",
];

// ============================================================
//  Helper Functions
// ============================================================

/** Cetak teks dengan warna opsional */
function out(string $text, string ...$colors): void
{
    if (USE_COLOR && $colors) {
        $open = implode('', array_map(fn($c) => C[$c] ?? '', $colors));
        echo $open . $text . C['reset'] . PHP_EOL;
    } else {
        echo $text . PHP_EOL;
    }
}

/** Prefix berdasarkan tipe pesan */
function icon(string $type): string
{
    $icons = [
        'ok'   => IS_WIN ? '[OK]   ' : '✔  ',
        'err'  => IS_WIN ? '[ERR]  ' : '✖  ',
        'warn' => IS_WIN ? '[WARN] ' : '⚠  ',
        'info' => IS_WIN ? '[-]    ' : '➜  ',
    ];
    return '  ' . ($icons[$type] ?? '   ');
}

function ok(string $msg): void   { out(icon('ok')   . $msg, 'green'); }
function err(string $msg): void  { out(icon('err')  . $msg, 'red'); }
function warn(string $msg): void { out(icon('warn') . $msg, 'yellow'); }
function info(string $msg): void { out(icon('info') . $msg, 'blue'); }

/** Header per langkah */
function step(int $n, string $title): void
{
    out('');
    out(str_repeat('═', 60), 'cyan');
    out("  Langkah {$n}: {$title}", 'bold', 'cyan');
    out(str_repeat('═', 60), 'cyan');
    out('');
}

/** Jalankan shell command dengan output live */
function run(string $cmd): bool
{
    info("Menjalankan: {$cmd}");
    out('');
    $proc = proc_open($cmd, [STDIN, STDOUT, STDERR], $pipes);
    if (!is_resource($proc)) return false;
    $code = proc_close($proc);
    out('');
    return $code === 0;
}

/** Cek apakah command tersedia */
function hasCmd(string $cmd): bool
{
    $out = IS_WIN ? shell_exec("where {$cmd} 2>NUL") : shell_exec("which {$cmd} 2>/dev/null");
    return !empty(trim($out ?? ''));
}

/** Ambil versi command (baris pertama) */
function getVer(string $cmd): string
{
    $redirect = IS_WIN ? '2>NUL' : '2>/dev/null';
    $out = shell_exec("{$cmd} --version {$redirect}");
    return explode("\n", trim($out ?? ''))[0] ?: 'Tidak diketahui';
}

/** Baca input user */
function input(string $prompt, string $default = ''): string
{
    $hint = $default !== '' ? " [{$default}]" : '';
    echo (USE_COLOR ? C['yellow'] : '') . "  {$prompt}{$hint}: " . (USE_COLOR ? C['reset'] : '');
    $val = trim(fgets(STDIN));
    return $val !== '' ? $val : $default;
}

/** Update atau tambah key di file .env */
function setEnv(string $file, string $key, string $val): void
{
    $content = file_get_contents($file);
    $line    = "{$key}={$val}";
    $content = preg_match("/^{$key}=/m", $content)
        ? preg_replace("/^{$key}=.*/m", $line, $content)
        : $content . PHP_EOL . $line;
    file_put_contents($file, $content);
}

/** Tampilkan box kontak developer */
function showContact(): void
{
    $e = fn(string $u, string $w) => IS_WIN ? $w : $u;
    out('');
    out('+' . str_repeat('-', 63) . '+', 'bold', 'cyan');
    out('|' . str_repeat(' ', 63) . '|', 'bold', 'cyan');
    out('|   ' . $e('👤','*') . ' Nama      : Akmal' . str_repeat(' ', 43) . '|', 'bold', 'cyan');
    out('|   ' . $e('📸','*') . ' Instagram : @lukheeman' . str_repeat(' ', 38) . '|', 'bold', 'cyan');
    out('|   ' . $e('📱','*') . ' No. HP    : 082250223147' . str_repeat(' ', 36) . '|', 'bold', 'cyan');
    out('|   ' . $e('🌐','*') . ' Portfolio : https://lukheman.github.io/portfolio/' . str_repeat(' ', 11) . '|', 'bold', 'cyan');
    out('|' . str_repeat(' ', 63) . '|', 'bold', 'cyan');
    out('+' . str_repeat('-', 63) . '+', 'bold', 'cyan');
    out('');
}

// ============================================================
//  MULAI SETUP
// ============================================================

$dir = __DIR__;
chdir($dir);

out('');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('|' . str_pad('  IMKA - SCRIPT SETUP PROJECT LARAVEL', 63) . '|', 'bold', 'green');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('');
info("Lokasi  : {$dir}");
info("PHP     : " . phpversion());
info("OS      : " . PHP_OS_FAMILY . ' (' . php_uname('s') . ' ' . php_uname('r') . ')');

// ============================================================
//  Langkah 0 – Cek Kebutuhan Sistem
// ============================================================

step(0, 'Mengecek Kebutuhan Sistem');

$missing = [];
foreach (['php' => 'PHP CLI', 'composer' => 'Composer'] as $cmd => $label) {
    if (hasCmd($cmd)) {
        ok("{$label}: " . getVer($cmd));
    } else {
        err("{$label} tidak ditemukan!");
        $missing[] = $label;
    }
}

hasCmd('mysql') ? ok('MySQL Client: ' . getVer('mysql')) : warn('MySQL Client tidak ditemukan');

if ($missing) {
    err('Kebutuhan kurang: ' . implode(', ', $missing));
    exit(1);
}

// ============================================================
//  Langkah 1 – Composer Install
// ============================================================

step(1, 'Menginstall Dependensi Composer');

if (is_dir("{$dir}/vendor")) warn('Folder vendor/ sudah ada, tetap memperbarui...');

if (!run('composer install --no-interaction --ignore-platform-reqs')) {
    err('Composer install gagal!'); exit(1);
}
ok('Dependensi Composer berhasil diinstall!');

// ============================================================
//  Langkah 2 – Copy .env
// ============================================================

step(2, 'Menyiapkan File Environment');

$env    = "{$dir}/.env";
$envEx  = "{$dir}/.env.example";

if (file_exists($env)) {
    warn('File .env sudah ada, melewati copy.');
} else {
    if (!file_exists($envEx)) { err('.env.example tidak ditemukan!'); exit(1); }
    copy($envEx, $env) ? ok('.env berhasil dibuat.') : (err('Gagal membuat .env') & exit(1));
}

// ============================================================
//  Langkah 3 – Generate App Key
// ============================================================

step(3, 'Membuat Application Key');

if (preg_match('/^APP_KEY=base64:.+/m', file_get_contents($env))) {
    warn('Application key sudah ada, dilewati.');
} else {
    run('php artisan key:generate --ansi') ? ok('Application key berhasil dibuat!') : (err('Gagal generate key') & exit(1));
}

// ============================================================
//  Langkah 4 – Konfigurasi Database
// ============================================================

step(4, 'Konfigurasi Database MySQL');

info('Masukkan konfigurasi database:');
out('');
$db = [
    'HOST'     => input('Host MySQL',    '127.0.0.1'),
    'PORT'     => input('Port MySQL',    '3306'),
    'DATABASE' => input('Nama Database', 'simka'),
    'USERNAME' => input('Username',      'root'),
    'PASSWORD' => input('Password',      ''),
];

foreach ($db as $key => $val) setEnv($env, "DB_{$key}", $val);
setEnv($env, 'DB_CONNECTION', 'mysql');

ok('Konfigurasi database tersimpan!');
out('');
foreach ($db as $key => $val) {
    $display = $key === 'PASSWORD' ? ($val ? str_repeat('*', strlen($val)) : '(kosong)') : $val;
    out("     " . str_pad($key, 10) . ": {$display}", 'cyan');
}
out('');
warn("Pastikan database '{$db['DATABASE']}' sudah dibuat di MySQL!");

// ============================================================
//  Langkah 5 – Migrasi
// ============================================================

step(5, 'Menjalankan Migrasi Database');

if (!run('php artisan migrate --force')) {
    err('Migrasi gagal! Cek koneksi database dan coba lagi.');
    exit(1);
}
ok('Migrasi berhasil!');

// ============================================================
//  Langkah 6 – Seeder
// ============================================================

step(6, 'Menjalankan Seeder Database');

run('php artisan db:seed --force') ? ok('Seeder berhasil!') : (err('Seeder gagal!') & exit(1));

// ============================================================
//  Langkah 7 – Pengecekan Akhir
// ============================================================

step(7, 'Pengecekan Akhir');

if (!file_exists("{$dir}/public/storage")) {
    run('php artisan storage:link') ? ok('Symlink storage dibuat.') : warn('Gagal buat storage link.');
} else {
    ok('Symlink storage sudah ada.');
}

foreach (['config', 'view', 'route'] as $cache) run("php artisan {$cache}:clear");

// ============================================================
//  Selesai!
// ============================================================

out('');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('|' . str_pad('  ✅  SETUP PROJECT BERHASIL DISELESAIKAN!', 63) . '|', 'bold', 'green');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('');
info('Jalankan server dengan: php artisan serve');

showContact();

out(str_repeat('─', 60), 'cyan');
out('  Jalankan server development sekarang? (y/n)', 'bold', 'cyan');
out(str_repeat('─', 60), 'cyan');

$ans = strtolower(trim(fgets(STDIN)));
if ($ans === 'y' || $ans === 'ya') {
    out('');
    info('Server berjalan di http://localhost:8000  |  Ctrl+C untuk berhenti');
    out('');
    passthru('php artisan serve');
} else {
    ok("Setup selesai! Jalankan 'php artisan serve' jika sudah siap.");
}
