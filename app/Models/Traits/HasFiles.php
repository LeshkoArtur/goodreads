<?php

namespace App\Models\Traits;

use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

trait HasFiles
{
    /**
     * Обробляє завантаження файлу та повертає шлях до збереженого файлу.
     *
     * @param  string|UploadedFile|null  $file  Файл або шлях до файлу
     * @param  string  $directory  Директорія для зберігання (наприклад, 'covers')
     * @param  string|null  $existingFilePath  Шлях до існуючого файлу для заміни
     * @param  string  $disk  Назва диска (за замовчуванням 'public')
     * @return string|null Шлях до збереженого файлу або null, якщо файл не надано
     */
    public function handleFileUpload(string|UploadedFile|null $file, string $directory, ?string $existingFilePath = null, string $disk = 'public'): ?string
    {
        if (! $file instanceof UploadedFile && ! is_string($file)) {
            return null;
        }

        if (is_string($file)) {
            return $file;
        }

        $fileService = App::make(FileService::class);

        return $fileService->storeFile($file, $directory, $existingFilePath, $disk);
    }
}
