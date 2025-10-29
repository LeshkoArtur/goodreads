<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class FileService
{
    /**
     * Зберігає завантажений файл у вказаній директорії та повертає шлях до нього.
     *
     * @param  UploadedFile  $file  Файл, який потрібно зберегти
     * @param  string  $directory  Директорія для зберігання (наприклад, 'covers')
     * @param  string|null  $existingFilePath  Шлях до існуючого файлу для видалення
     * @param  string  $disk  Назва диска для зберігання (за замовчуванням 'public')
     * @return string Шлях до збереженого файлу
     *
     * @throws InvalidArgumentException Якщо файл невалідний
     */
    public function storeFile(UploadedFile $file, string $directory, ?string $existingFilePath = null, string $disk = 'public'): string
    {
        if (! $file->isValid()) {
            throw new InvalidArgumentException('Невалідний файл для завантаження.');
        }

        if ($existingFilePath && Storage::disk($disk)->exists($existingFilePath)) {
            Storage::disk($disk)->delete($existingFilePath);
        }

        $fileName = uniqid().'.'.$file->getClientOriginalExtension();

        return Storage::disk($disk)->putFileAs($directory, $file, $fileName);
    }

    /**
     * Видаляє файл за вказаним шляхом.
     *
     * @param  string  $filePath  Шлях до файлу
     * @param  string  $disk  Назва диска (за замовчуванням 'public')
     * @return bool Чи успішно видалено файл
     */
    public function deleteFile(string $filePath, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }

        return false;
    }
}
