<?php 

namespace App\Modules\Core\Admin\Http\Controllers;

use App\Base\AdminController;
use App\Modules\Core\Services\Crud\PageCrudService;
use App\Modules\Core\Models\Page;
use App\Modules\Core\Admin\Http\Requests\Page\{
    IndexFilter,
    FormRequest,
    CreateRequest,
    EditRequest,
    DestroyRequest,
    BulkDestroyRequest,
    BulkToggleRequest
};

/**
 */
class PageController extends AdminController
{
    /*
     * var PageCrudService
     */
    protected $crudService;
            
    /*
     * @param  PageCrudService     $crudService
     */
    public function __construct(PageCrudService $crudService)
    {
        $this->crudService = $crudService;
    }
    
    /**
     * Pages list
     *
     * @param      IndexFilter $request
     */
    public function index(IndexFilter $modelFilter)
    {
        if ($modelFilter->ajax()) {
            return $modelFilter->getData();
        }
        
        return $this->view('page.index', compact('modelFilter'));
    }

    /**
     * Page create
     *
     * @param      CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $page = new Page;
        
        return $this->view('page.create', compact('page'));       
    }

    /**
     * Page store
     *
     * @param      FormRequest $request
     */
    public function store(FormRequest $request)
    {
        $page = $this->crudService->store($request->validated());
        
        return redirect(r('admin.core.pages.index'))
            ->with('success', __('core::page.success.created'));       
    }

    /**
     * Page edit
     *
     * @param      Page $page
     * @param      EditRequest $request
     */
    public function edit(Page $page, EditRequest $request)
    {
        return $this->view('page.update', compact('page'));       
    }

    /**
     * Page update
     *
     * @param      Page $page
     * @param      FormRequest $request
     */
    public function update(Page $page, FormRequest $request)
    {
        $page = $this->crudService->update($page, $request->validated());
        
        return redirect(r('admin.core.pages.index')) 
            ->with('success', __('core::page.success.updated'));       
    }

    /**
     * Page destroy
     *
     * @param      DestroyRequest $request
     * @param      Page $page
     */
    public function destroy(Page $page, DestroyRequest $request)
    {
        $this->crudService->destroy($page);
        
        return response()->json(null, 204);
    }
    
    /**
     * Pages bulk destroy
     *
     * @param      BulkDestroyRequest $request
     */
    public function bulkDestroy(BulkDestroyRequest $request)
    {
        $this->crudService->bulkDestroy($request->ids);
        
        return response()->json(null, 204);
    }
    
    /**
     * Pages bulk toggle attribute
     *
     * @param      BulkToggleRequest $request
     */
    public function bulkToggle(BulkToggleRequest $request)
    {
        $this->crudService->bulkToggle($request->validated());
        
        return response()->json(null, 204);
    }
}