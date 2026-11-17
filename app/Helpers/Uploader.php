<?php
declare(strict_types=1);

namespace App\Helpers;

use RuntimeException;

class Uploader {
    private const ALLOWED_MIMES = [
        'image/jpeg'    => 'jpg',
        'image/pjpeg'   => 'jpg',
        'image/jpg'     => 'jpg',
        'image/png'     => 'png',
        'image/x-png'   => 'png',
        'image/webp'    => 'webp',
        'image/gif'     => 'gif',
        'image/avif'    => 'avif',
        'image/svg+xml' => 'svg'
    ];

    private const ALLOWED_EXTS = [
        'jpg'  => 'jpg',
        'jpeg' => 'jpg',
        'png'  => 'png',
        'webp' => 'webp',
        'gif'  => 'gif',
        'avif' => 'avif',
        'svg'  => 'svg'
    ];

    private const MAX_FILE_SIZE = 26214400; // 25 MB

    public static function uploadImage(array $file, string $subfolder = ''): array {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'message' => 'Invalid upload parameters provided.'];
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['success' => false, 'message' => 'No file uploaded.'];
            case UPLOAD_ERR_INI_SIZE:
                return ['success' => false, 'message' => 'File size exceeds server upload_max_filesize limit.'];
            case UPLOAD_ERR_FORM_SIZE:
                return ['success' => false, 'message' => 'File size exceeds maximum form upload limit.'];
            case UPLOAD_ERR_PARTIAL:
                return ['success' => false, 'message' => 'The uploaded file was only partially received.'];
            case UPLOAD_ERR_NO_TMP_DIR:
                return ['success' => false, 'message' => 'Missing server temporary upload folder.'];
            case UPLOAD_ERR_CANT_WRITE:
                return ['success' => false, 'message' => 'Failed to write uploaded file to server disk.'];
            default:
                return ['success' => false, 'message' => "Upload error encountered (Code: {$file['error']})."];
        }

        if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'message' => 'Invalid or missing uploaded temporary file.'];
        }

        if (($file['size'] ?? 0) > self::MAX_FILE_SIZE) {
            return ['success' => false, 'message' => 'Uploaded file exceeds 25MB maximum size limit.'];
        }

        // Deep MIME inspection using finfo with graceful fallback
        $mime = '';
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $detected = finfo_file($finfo, $file['tmp_name']);
                if ($detected !== false) {
                    $mime = strtolower(trim((string) $detected));
                }
                finfo_close($finfo);
            }
        }

        if ($mime === '' && function_exists('mime_content_type')) {
            $detected = mime_content_type($file['tmp_name']);
            if ($detected !== false) {
                $mime = strtolower(trim((string) $detected));
            }
        }

        // Determine extension from MIME or client filename
        $extension = null;
        if ($mime !== '' && array_key_exists($mime, self::ALLOWED_MIMES)) {
            $extension = self::ALLOWED_MIMES[$mime];
        }

        // Fallback to client filename extension if MIME was generic (e.g. application/octet-stream)
        $clientExt = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
        if ($extension === null && array_key_exists($clientExt, self::ALLOWED_EXTS)) {
            $extension = self::ALLOWED_EXTS[$clientExt];
        }

        if ($extension === null) {
            return ['success' => false, 'message' => 'Invalid image format. Supported formats: JPEG, PNG, WebP, GIF, AVIF, SVG.'];
        }

        // Prepare destination upload directory
        $config = require dirname(__DIR__) . '/Config/config.php';
        $targetDir = rtrim($config['upload_dir'], '/');
        if ($subfolder !== '') {
            $targetDir .= '/' . trim($subfolder, '/');
        }

        if (!is_dir($targetDir)) {
            if (!@mkdir($targetDir, 0777, true)) {
                return ['success' => false, 'message' => "Failed to create destination upload directory: {$subfolder}."];
            }
        }
        @chmod($targetDir, 0777);

        // Generate cryptographically unique filename
        $uniqueName = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = $targetDir . '/' . $uniqueName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => false, 'message' => 'Failed to save uploaded file into destination folder.'];
        }
        @chmod($destination, 0666);

        // Compute web-accessible relative URL with leading slash
        $relativeUrl = '/uploads/' . ($subfolder !== '' ? trim($subfolder, '/') . '/' : '') . $uniqueName;

        return [
            'success' => true,
            'filename' => $uniqueName,
            'filepath' => $destination,
            'url' => $relativeUrl
        ];
    }
}
