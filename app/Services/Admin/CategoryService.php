<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Utilities\GoogleDriveUtility;

class CategoryService
{
    private $googleDriveUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
    }

    /**
     * Summary of addCategory
     * @param array $validated
     * @return void
     */
    public function addCategory($validated)
    {
        $lastCategory = Category::orderBy('id', 'desc')->first();
        $lastSerialNumber = 0;

        if ($lastCategory && preg_match('/CATEGORY_(\d+)/', $lastCategory->category_serial_code, $matches)) {
            $lastSerialNumber = (int) $matches[1];
        }

        $newSerialNumber = $lastSerialNumber + 1;
        $newCategorySerialCode = 'CATEGORY_' . str_pad($newSerialNumber, 3, '0', STR_PAD_LEFT);

        $newCategory = new Category();
        $newCategory->name_en = $validated['name_en'];
        $newCategory->name_id = $validated['name_id'];
        $newCategory->category_serial_code = $newCategorySerialCode;

        if (isset($validated['category_image'])) {
            $file = $validated['category_image'];
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = 'category_images/' . uniqid('category_') . '.' . $fileExtension;

            $this->googleDriveUtility->storeFile($fileName, $file);

            $newCategory->url = $fileName;
        }

        $newCategory->save();
    }

    /**
     * Summary of updateCategory
     * @param int $id
     * @param array $validated
     * @return void
     */
    public function updateCategory($id, $validated)
    {
        $category = Category::find($id);

        $category->name_en = $validated['name_en'];
        $category->name_id = $validated['name_id'];

        if (isset($validated['category_image'])) {
            if ($category->url) {
                $this->googleDriveUtility->deleteFile($category->url);
            }

            $file = $validated['category_image'];
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = 'category_images/' . uniqid('category_') . '.' . $fileExtension;

            $this->googleDriveUtility->storeFile($fileName, $file);
            $category->url = $fileName;
        }

        $category->save();
    }

    /**
     * Summary of deleteCategory
     * @param int $id
     * @throws \Exception
     * @return void
     */
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            throw new \Exception(__('message.invalid'));
        }

        $this->googleDriveUtility->deleteFile($category->url);

        $category->delete();
    }
}