<?php

declare(strict_types=1);

$target = __DIR__ . '/../vendor/voku/portable-ascii/src/voku/helper/ASCII.php';

if (!is_file($target)) {
    fwrite(STDOUT, "portable-ascii patch skipped: target file not found.\n");
    exit(0);
}

$original = file_get_contents($target);

if ($original === false) {
    fwrite(STDERR, "portable-ascii patch failed: could not read target file.\n");
    exit(1);
}

$patched = str_replace(
    '        bool $replace_single_chars_only = null',
    '        ?bool $replace_single_chars_only = null',
    $original,
    $count
);

if ($count === 0) {
    if (strpos($original, '?bool $replace_single_chars_only = null') !== false) {
        fwrite(STDOUT, "portable-ascii patch already applied.\n");
        exit(0);
    }

    fwrite(STDERR, "portable-ascii patch failed: expected signature not found.\n");
    exit(1);
}

if (file_put_contents($target, $patched) === false) {
    fwrite(STDERR, "portable-ascii patch failed: could not write target file.\n");
    exit(1);
}

fwrite(STDOUT, "portable-ascii patch applied.\n");