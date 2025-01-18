<?php

namespace App\Http\Controllers\admin;

use Exception;
use App\Models\Category;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use App\Utilities\ProductsUtility;
use Illuminate\Support\Facades\DB;
use App\Interfaces\StatusInterface;
use App\Http\Controllers\Controller;
use App\Utilities\GoogleDriveUtility;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller implements StatusInterface
{
    private $googleDriveUtility;
    private $productsUtility;
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->productsUtility = new ProductsUtility();
    }

    /**
     * Summary of categoryIndex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function categoryIndex()
    {
        $categories = Category::all()->map(function ($category) {
            $id = $category->id;
            $name = $category->name;
            $url = $category->url;
            $image = $this->googleDriveUtility->getFile($url);

            return (object) compact('id', 'name', 'image');
        });

        // dd($categories); 
        return view('admin.category.categories', compact('categories'));
    }

    /**
     * Summary of addCategoryIndex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addCategoryIndex()
    {
        return view('admin.category.add');
    }

    /**
     * Summary of editCategoryIndex
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editCategoryIndex($id)
    {
        $category = Category::find($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Summary of addCategory
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCategory(CategoryRequest $request)
    {
        $validate = $request->validated();

        try {
            DB::beginTransaction();

            $lastCategory = Category::orderBy('id', 'desc')->first();
            $lastSerialNumber = 0;

            if ($lastCategory && preg_match('/CATEGORY_(\d+)/', $lastCategory->category_serial_code, $matches)) {
                $lastSerialNumber = (int) $matches[1];
            }

            $newSerialNumber = $lastSerialNumber + 1;
            $newCategorySerialCode = 'CATEGORY_' . str_pad($newSerialNumber, 3, '0', STR_PAD_LEFT);

            $newCategory = new Category();
            $newCategory->name_en = $validate['name_en'];
            $newCategory->name_id = $validate['name_id'];
            $newCategory->category_serial_code = $newCategorySerialCode;

            if ($request->hasFile('category_image')) {
                $file = $request->file('category_image');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = 'category_images/' . uniqid('category_') . '.' . $fileExtension;

                $this->googleDriveUtility->storeFile($fileName, $file);

                $newCategory->url = $fileName;
            }

            $newCategory->save();

            DB::commit();

            return to_route('admin.addCategoryIndex')->with('success', 'Category added successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            return back()->with('error', 'Failed to add category: ' . $e->getMessage());
        }
    }


    public function updateCategory(CategoryRequest $request, $id)
    {
        $validate = $request->validated();

        try {
            DB::beginTransaction();

            $category = Category::find($id);

            $category->name_en = $validate['name_en'];
            $category->name_id = $validate['name_id'];

            if ($request->hasFile('category_image')) {
                if ($category->url) {
                    $this->googleDriveUtility->deleteFile($category->url);
                }

                $file = $validate['category_image'];
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = 'category_images/' . uniqid('category_') . '.' . $fileExtension;

                $this->googleDriveUtility->storeFile($fileName, $file);
                $category->url = $fileName;
            }

            $category->save();

            DB::commit();

            return to_route('admin.editCategory', $id)->with('success', 'Category updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            return back()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }


    /**
     * Summary of deleteCategory
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory(Request $request)
    {
        try {
            DB::beginTransaction();

            $id = $request->id;

            $category = Category::find($id);

            if (!$category) {
                throw new Exception(__('message.invalid'));
            }

            $this->googleDriveUtility->deleteFile($category->url);

            $category->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $errorLog = new ErrorLog();
            $errorLog->error = $e->getMessage();
            $errorLog->save();

            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
        $response = [
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.remove_item'),
        ];

        return back()->with($response);
    }
}
