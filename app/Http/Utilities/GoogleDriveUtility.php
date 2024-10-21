<?php

namespace App\Http\Utilities;

use App\Models\ErrorLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Storage;

class GoogleDriveUtility implements StatusInterface
{
    private $storage;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->storage = Storage::disk('google');
    }

    /**
     * Summary of storeImage
     * @param string $imgName
     * @param array|UploadedFile|null $img
     * @return string[]|\Illuminate\Http\RedirectResponse
     */
    public function storeImage($imgName, $img)
    {
        try {
            DB::beginTransaction();

            $this->storage->write($imgName, file_get_contents($img));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => 'Image upload failed!',
            ];

            return back()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'Image uploaded successfully!',
        ];

        return $response;
    }

    /**
     * Summary of getImage
     * @param string $imgPath
     * @return string
     */
    public function getImage($imgPath)
    {
        $img = $this->storage->read($imgPath);
        return response($img, 200)
            ->header('Content-Type', 'image/jpeg');
    }

    /**
     * Summary of deleteImage
     * @param string $imgPath
     * @return string[]|\Illuminate\Http\RedirectResponse
     */
    public function deleteImage($imgPath)
    {
        try {
            DB::beginTransaction();

            $this->storage->delete($imgPath);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            $response = [
                'status' => self::STATUS_ERROR,
                'message' => 'Image deletion failed!',
            ];

            return back()->with($response);
        }

        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => 'Image deleted successfully!',
        ];

        return $response;
    }
}
