<?php

namespace App\Models\Services;

/**
 * Image Upload and Processing Service
 * Handles file upload, validation, resize, and optimization
 */
class ImageUploadService
{
    private string $uploadPath;
    private bool $useCloudinary = false;
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxFileSize = 5242880; // 5MB
    private array $thumbnailSizes = [
        'thumb' => ['width' => 150, 'height' => 150],
        'medium' => ['width' => 400, 'height' => 600],
        'large' => ['width' => 800, 'height' => 1200]
    ];

    public function __construct(?string $uploadPath = null)
    {
        $this->uploadPath = $uploadPath ?? ROOT_PATH . '/public/uploads/';
        
        if (!empty($_ENV['CLOUDINARY_URL'])) {
            $this->useCloudinary = true;
            \Cloudinary\Configuration\Configuration::instance($_ENV['CLOUDINARY_URL']);
        } else {
            // Create upload directory if not exists
            if (!is_dir($this->uploadPath)) {
                mkdir($this->uploadPath, 0755, true);
            }
        }
    }

    /**
     * Upload and process image
     * 
     * @param array $file $_FILES array element
     * @param string $subfolder Subfolder name (movies, cinemas, etc.)
     * @param bool $createThumbnails Whether to create thumbnails
     * @return array ['success' => bool, 'url' => string, 'thumbnails' => array, 'error' => string]
     */
    public function upload(array $file, string $subfolder = 'general', bool $createThumbnails = true): array
    {
        // Validate file
        $validation = $this->validate($file);
        if (!$validation['success']) {
            return $validation;
        }

        if ($this->useCloudinary) {
            return $this->uploadToCloudinary($file, $subfolder, $createThumbnails);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $this->generateFilename($extension);
        
        // Create subfolder
        $targetDir = $this->uploadPath . $subfolder . '/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                'success' => false,
                'error' => 'Failed to move uploaded file'
            ];
        }

        // Optimize image
        $this->optimize($targetPath);

        // Create thumbnails
        $thumbnails = [];
        if ($createThumbnails) {
            $thumbnails = $this->createThumbnails($targetPath, $subfolder, pathinfo($filename, PATHINFO_FILENAME));
        }

        return [
            'success' => true,
            'url' => "/uploads/{$subfolder}/{$filename}",
            'path' => $targetPath,
            'thumbnails' => $thumbnails,
            'size' => filesize($targetPath)
        ];
    }

    private function uploadToCloudinary(array $file, string $subfolder, bool $createThumbnails): array
    {
        try {
            $uploadApi = new \Cloudinary\Api\Upload\UploadApi();
            $result = $uploadApi->upload($file['tmp_name'], [
                'folder' => 'cinemax/' . $subfolder,
            ]);

            $url = $result['secure_url'];
            $thumbnails = [];
            
            if ($createThumbnails) {
                $baseUrl = explode('/upload/', $url);
                if (count($baseUrl) == 2) {
                    $thumbnails = [
                        'thumb' => $baseUrl[0] . '/upload/c_fill,w_150,h_150/' . $baseUrl[1],
                        'medium' => $baseUrl[0] . '/upload/c_fill,w_400,h_600/' . $baseUrl[1],
                        'large' => $baseUrl[0] . '/upload/c_fill,w_800,h_1200/' . $baseUrl[1],
                    ];
                }
            }

            return [
                'success' => true,
                'url' => $url,
                'path' => $url,
                'thumbnails' => $thumbnails,
                'size' => $result['bytes'] ?? $file['size']
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Cloudinary upload failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validate uploaded file
     */
    private function validate(array $file): array
    {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'error' => $this->getUploadErrorMessage($file['error'])
            ];
        }

        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            return [
                'success' => false,
                'error' => 'File size exceeds maximum limit of ' . ($this->maxFileSize / 1024 / 1024) . 'MB'
            ];
        }

        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedTypes)) {
            return [
                'success' => false,
                'error' => 'Invalid file type. Allowed types: JPG, PNG, GIF, WebP'
            ];
        }

        // Check if it's actually an image
        if (!getimagesize($file['tmp_name'])) {
            return [
                'success' => false,
                'error' => 'Uploaded file is not a valid image'
            ];
        }

        return ['success' => true];
    }

    /**
     * Generate unique filename
     */
    private function generateFilename(string $extension): string
    {
        return uniqid('img_', true) . '.' . strtolower($extension);
    }

    /**
     * Optimize image (reduce quality for smaller file size)
     */
    private function optimize(string $path): bool
    {
        $imageInfo = getimagesize($path);
        if (!$imageInfo) {
            return false;
        }

        [$width, $height, $type] = $imageInfo;

        // Load image based on type
        $image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_GIF => imagecreatefromgif($path),
            IMAGETYPE_WEBP => imagecreatefromwebp($path),
            default => false
        };

        if (!$image) {
            return false;
        }

        // Save optimized image
        $result = match ($type) {
            IMAGETYPE_JPEG => imagejpeg($image, $path, 85), // 85% quality
            IMAGETYPE_PNG => imagepng($image, $path, 8), // Compression level 8
            IMAGETYPE_GIF => imagegif($image, $path),
            IMAGETYPE_WEBP => imagewebp($image, $path, 85),
            default => false
        };

        imagedestroy($image);
        return $result;
    }

    /**
     * Create thumbnails in multiple sizes
     */
    private function createThumbnails(string $sourcePath, string $subfolder, string $baseFilename): array
    {
        $thumbnails = [];
        
        foreach ($this->thumbnailSizes as $sizeName => $dimensions) {
            $thumbPath = $this->uploadPath . $subfolder . '/' . $baseFilename . '_' . $sizeName . '.jpg';
            
            if ($this->resize($sourcePath, $thumbPath, $dimensions['width'], $dimensions['height'])) {
                $thumbnails[$sizeName] = "/uploads/{$subfolder}/{$baseFilename}_{$sizeName}.jpg";
            }
        }

        return $thumbnails;
    }

    /**
     * Resize image
     */
    private function resize(string $sourcePath, string $destPath, int $maxWidth, int $maxHeight): bool
    {
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }

        [$width, $height, $type] = $imageInfo;

        // Calculate new dimensions (maintain aspect ratio)
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        // Load source image
        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => imagecreatefrompng($sourcePath),
            IMAGETYPE_GIF => imagecreatefromgif($sourcePath),
            IMAGETYPE_WEBP => imagecreatefromwebp($sourcePath),
            default => false
        };

        if (!$source) {
            return false;
        }

        // Create new image
        $dest = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
        }

        // Resize
        imagecopyresampled($dest, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save as JPEG
        $result = imagejpeg($dest, $destPath, 85);

        imagedestroy($source);
        imagedestroy($dest);

        return $result;
    }

    /**
     * Delete image and its thumbnails
     */
    public function delete(string $url): bool
    {
        if ($this->useCloudinary && strpos($url, 'res.cloudinary.com') !== false) {
            $parts = explode('/upload/', $url);
            if (count($parts) == 2) {
                $path = $parts[1];
                if (preg_match('/^v\d+\/(.+)$/', $path, $matches)) {
                    $path = $matches[1];
                }
                $publicId = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);
                
                try {
                    $uploadApi = new \Cloudinary\Api\Upload\UploadApi();
                    $uploadApi->destroy($publicId);
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            }
        }

        $path = ROOT_PATH . '/public' . $url;
        
        if (!file_exists($path)) {
            return false;
        }

        // Delete main image
        unlink($path);

        // Delete thumbnails
        $pathInfo = pathinfo($path);
        $baseFilename = $pathInfo['filename'];
        $dir = $pathInfo['dirname'];

        foreach (array_keys($this->thumbnailSizes) as $sizeName) {
            $thumbPath = $dir . '/' . $baseFilename . '_' . $sizeName . '.jpg';
            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }
        }

        return true;
    }

    private function getUploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'File is too large',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'Upload stopped by extension',
            default => 'Unknown upload error'
        };
    }
}
