<?php

namespace App\Http\Utilities;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use Illuminate\Support\Facades\Storage;

class GoogleDriveUtility implements StatusInterface
{
    public function storeProductImage($imgName, $img)
    {
        try {
            DB::beginTransaction();

            Storage::disk('google')->write($imgName, file_get_contents($img));

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

    public function getProductImage()
    {

    }
}
