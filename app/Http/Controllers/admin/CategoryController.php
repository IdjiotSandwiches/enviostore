<?php

namespace App\Http\Controllers\admin;

use App\Services\Admin\CategoryService;
use App\Models\Category;
use App\Utilities\ErrorUtility;
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
    private $categoryService;
    private $errorUtility;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->googleDriveUtility = new GoogleDriveUtility();
        $this->categoryService = new CategoryService();
        $this->errorUtility = new ErrorUtility();
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
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editCategoryIndex($id)
    {
        $category = Category::find($id);
        $categoryImage = $this->googleDriveUtility->getFile($category->url);

        return view('admin.category.edit', compact('category', 'categoryImage'));
    }

    /**
     * Summary of addCategory
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCategory(CategoryRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $this->categoryService->addCategory($validated);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->errorUtility->errorLog($e->getMessage());
            
            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to add category',
            ]);
        }

        return to_route('admin.category.index')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Category added successfully.',
        ]);
    }

    /**
     * Summary of updateCategory
     * @param \App\Http\Requests\CategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(CategoryRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $this->categoryService->updateCategory($id, $validated);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->errorUtility->errorLog($e->getMessage());
            
            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to update category',
            ]);
        }

        return to_route('admin.category.index')->with([
            'status' => self::STATUS_SUCCESS,
            'message' => 'Category updated successfully.',
        ]);
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

            $this->categoryService->deleteCategory($request->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->errorUtility->errorLog($e->getMessage());

            return back()->with([
                'status' => self::STATUS_ERROR,
                'message' => 'Failed to update category',
            ]);
        }

        return back()->with([
            'status' => self::STATUS_SUCCESS,
            'message' => __('message.remove_item'),
        ]);
    }
}
