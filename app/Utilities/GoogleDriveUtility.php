<?php

namespace App\Utilities;

use App\Models\ErrorLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Storage;

class GoogleDriveUtility implements StatusInterface
{
    // Mungkin nanti pake has($path) buat cek file.
    private $storage;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->storage = Storage::disk('google');
    }

    /**
     * Summary of storeFile
     * @param string $fileName
     * @param array|UploadedFile|null $file
     * @return string[]|\Illuminate\Http\RedirectResponse
     */
    public function storeFile($fileName, $file)
    {
        try {
            DB::beginTransaction();

            $this->storage->write($fileName, file_get_contents($file));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => 'File upload failed!',
            ];

            return back()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'File uploaded successfully!',
        ];

        return $response;
    }

    /**
     * Summary of getFile
     * @param string $filePath
     * @return string
     */
    public function getFile($filePath)
    {
        $file = $this->storage->read($filePath);
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($file);

        return 'data:' . $mimeType . ';base64,' . base64_encode($file);
    }

    /**
     * Summary of deleteFile
     * @param string $filePath
     * @return string[]|\Illuminate\Http\RedirectResponse
     */
    public function deleteFile($filePath)
    {
        try {
            DB::beginTransaction();

            $this->storage->delete($filePath);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => 'File deletion failed!',
            ];

            return back()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'File deleted successfully!',
        ];

        return $response;
    }
}
