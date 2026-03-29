#!/usr/bin/env php
<?php

/**
 * Script Update Project Laravel
 *
 * 1. Git pull perubahan terbaru
 * 2. Composer install jika ada perubahan dependencies
 * 3. Migrasi database
 * 4. Bersihkan cache
 * 5. Optimasi aplikasi
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

function icon(string $type): string
{
    return '  ' . match($type) {
        'ok'   => IS_WIN ? '[OK]   ' : '✔  ',
        'err'  => IS_WIN ? '[ERR]  ' : '✖  ',
        'warn' => IS_WIN ? '[WARN] ' : '⚠  ',
        'info' => IS_WIN ? '[-]    ' : '➜  ',
        default => '   ',
    };
}

function ok(string $msg): void   { out(icon('ok')   . $msg, 'green'); }
function err(string $msg): void  { out(icon('err')  . $msg, 'red'); }
function warn(string $msg): void { out(icon('warn') . $msg, 'yellow'); }
function info(string $msg): void { out(icon('info') . $msg, 'blue'); }

function step(int $n, string $title): void
{
    out('');
    out(str_repeat('═', 60), 'cyan');
    out("  Langkah {$n}: {$title}", 'bold', 'cyan');
    out(str_repeat('═', 60), 'cyan');
    out('');
}

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

function shell(string $cmd): string
{
    $redirect = IS_WIN ? '2>NUL' : '2>/dev/null';
    return trim(shell_exec("{$cmd} {$redirect}") ?? '');
}

function hasCmd(string $cmd): bool
{
    return !empty(shell(IS_WIN ? "where {$cmd}" : "which {$cmd}"));
}

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
    out('|   ' . $e('🌐','*') . ' Website   : https://aplikasita.my.id/' . str_repeat(' ', 23) . '|', 'bold', 'cyan');
    out('|' . str_repeat(' ', 63) . '|', 'bold', 'cyan');
    out('|   Silahkan hubungi untuk pertanyaan atau bantuan!' . str_repeat(' ', 12) . '|', 'bold', 'cyan');
    out('|' . str_repeat(' ', 63) . '|', 'bold', 'cyan');
    out('+' . str_repeat('-', 63) . '+', 'bold', 'cyan');
    out('');
}

// ============================================================
//  MULAI UPDATE
// ============================================================

$dir   = __DIR__;
$start = microtime(true);
chdir($dir);

out('');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('|' . str_pad('  SIMKA - SCRIPT UPDATE APLIKASI', 63) . '|', 'bold', 'green');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('');
info("Lokasi : {$dir}");
info("Waktu  : " . date('Y-m-d H:i:s'));

// ============================================================
//  Langkah 0 – Cek Kebutuhan
// ============================================================

step(0, 'Mengecek Kebutuhan');

if (!hasCmd('git'))      { err('Git tidak ditemukan!');      exit(1); } ok('Git ditemukan');
if (!is_dir("$dir/.git")){ err('Bukan repository Git!');     exit(1); } ok('Repository Git terdeteksi');
if (!hasCmd('composer')) { err('Composer tidak ditemukan!'); exit(1); } ok('Composer ditemukan');

// ============================================================
//  Langkah 1 – Status Git
// ============================================================

step(1, 'Mengecek Status Git');

$branch = shell('git branch --show-current');
info("Branch saat ini: {$branch}");

$status = shell('git status --porcelain');
if (!empty($status)) {
    warn('Ada perubahan lokal yang belum di-commit:');
    out((USE_COLOR ? C['yellow'] : '') . $status . (USE_COLOR ? C['reset'] : ''));
    out('');
    warn('Perubahan lokal akan tetap dipertahankan.');
    out('');
}

// ============================================================
//  Langkah 2 – Git Pull
// ============================================================

step(2, 'Mengambil Pembaruan dari Repository (Git Pull)');

$hashBefore = shell('git rev-parse HEAD');

if (!run('git pull')) {
    err('Git pull gagal!');
    out('');
    warn('Kemungkinan penyebab:');
    out('  1. Tidak ada koneksi internet', 'yellow');
    out('  2. Ada konflik dengan perubahan lokal', 'yellow');
    out('  3. Remote repository tidak tersedia', 'yellow');
    exit(1);
}

$hashAfter = shell('git rev-parse HEAD');

if ($hashBefore === $hashAfter) {
    ok('Project sudah versi terbaru, tidak ada pembaruan.');
} else {
    ok('Pembaruan berhasil diambil!');
    info('Commit baru:');
    out((USE_COLOR ? C['cyan'] : '') . shell("git log --oneline {$hashBefore}..{$hashAfter}") . (USE_COLOR ? C['reset'] : ''));
}

// ============================================================
//  Langkah 3 – Composer Install (jika ada perubahan)
// ============================================================

step(3, 'Update Dependencies Composer');

$composerUpdated = false;

if ($hashBefore !== $hashAfter) {
    $changed = shell("git diff --name-only {$hashBefore} {$hashAfter}");

    if (str_contains($changed, 'composer.json') || str_contains($changed, 'composer.lock')) {
        info('Terdeteksi perubahan composer.json/composer.lock, menjalankan install...');

        if (!run('composer install --no-interaction --optimize-autoloader')) {
            err('Composer install gagal!'); exit(1);
        }

        $composerUpdated = true;
        ok('Dependencies Composer berhasil diupdate!');
    } else {
        ok('Tidak ada perubahan dependencies, melewati composer install.');
    }
} else {
    ok('Tidak ada update, melewati composer install.');
}

// ============================================================
//  Langkah 4 – Migrasi Database
// ============================================================

step(4, 'Menjalankan Migrasi Database');

if (!run('php artisan migrate:fresh --seed')) {
    err('Migrasi database gagal!');
    out('');
    warn('Kemungkinan penyebab:');
    out('  1. Database tidak terhubung', 'yellow');
    out('  2. Kredensial database pada .env salah', 'yellow');
    out('  3. Ada error pada file migrasi', 'yellow');
    exit(1);
}
ok('Migrasi database selesai!');

// ============================================================
//  Langkah 5 – Bersihkan Cache
// ============================================================

step(5, 'Membersihkan Cache Aplikasi');

foreach (['config', 'route', 'view', 'cache'] as $cache) run("php artisan {$cache}:clear");
run('php artisan clear-compiled');

ok('Semua cache berhasil dibersihkan!');

// ============================================================
//  Langkah 6 – Optimasi
// ============================================================

step(6, 'Mengoptimasi Aplikasi');

run('composer dump-autoload --optimize');
ok('Aplikasi berhasil dioptimasi!');

// ============================================================
//  Selesai!
// ============================================================

$duration = round(microtime(true) - $start, 2);

out('');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('|' . str_pad('  ✅  UPDATE PROJECT BERHASIL!', 63) . '|', 'bold', 'green');
out('+' . str_repeat('-', 63) . '+', 'bold', 'green');
out('');
info("Waktu proses: {$duration} detik");
info('Project berhasil diupdate ke versi terbaru!');
out('');

// Ringkasan
$composerStatus = $composerUpdated ? 'Selesai' : 'Dilewati (tidak ada perubahan)';
out('  Ringkasan Update:', 'bold', 'cyan');
out("  ├─ Git Pull            : Selesai", 'cyan');
out("  ├─ Composer Install    : {$composerStatus}", 'cyan');
out("  ├─ Database Migration  : Selesai", 'cyan');
out("  ├─ Clear Cache         : Selesai", 'cyan');
out("  └─ Optimasi            : Selesai", 'cyan');
out('');
out('  Untuk menjalankan aplikasi, gunakan:', 'yellow');
out('  php serve.php  atau  php artisan serve');
out('');

showContact();
