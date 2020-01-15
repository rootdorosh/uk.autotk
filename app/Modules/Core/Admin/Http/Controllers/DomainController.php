<?php 

namespace App\Modules\Core\Admin\Http\Controllers;

use App\Base\AdminController;
use App\Modules\Core\Services\Crud\DomainCrudService;
use App\Modules\Core\Models\Domain;
use App\Modules\Core\Admin\Http\Requests\Domain\{
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
class DomainController extends AdminController
{
    /*
     * var DomainCrudService
     */
    protected $crudService;
            
    /*
     * @param  DomainCrudService     $crudService
     */
    public function __construct(DomainCrudService $crudService)
    {
        $this->crudService = $crudService;
    }
    
    /**
     * Domains list
     *
     * @param      IndexFilter $request
     */
    public function index(IndexFilter $modelFilter)
    {
        if ($modelFilter->ajax()) {
            return $modelFilter->getData();
        }
        
        return $this->view('domain.index', compact('modelFilter'));
    }

    /**
     * Domain create
     *
     * @param      CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $domain = new Domain;
        
        return $this->view('domain.create', compact('domain'));       
    }

    /**
     * Domain store
     *
     * @param      FormRequest $request
     */
    public function store(FormRequest $request)
    {
        $domain = $this->crudService->store($request->validated());
        
        return redirect(route('admin.core.domains.index'))
            ->with('success', __('core::domain.success.created'));       
    }

    /**
     * Domain edit
     *
     * @param      Domain $domain
     * @param      EditRequest $request
     */
    public function edit(Domain $domain, EditRequest $request)
    {
        return $this->view('domain.update', compact('domain'));       
    }

    /**
     * Domain update
     *
     * @param      Domain $domain
     * @param      FormRequest $request
     */
    public function update(Domain $domain, FormRequest $request)
    {
        $domain = $this->crudService->update($domain, $request->validated());
        
        return redirect(route('admin.core.domains.index')) 
            ->with('success', __('core::domain.success.updated'));       
    }

    /**
     * Domain destroy
     *
     * @param      DestroyRequest $request
     * @param      Domain $domain
     */
    public function destroy(Domain $domain, DestroyRequest $request)
    {
        $this->crudService->destroy($domain);
        
        return response()->json(null, 204);
    }
    
    /**
     * Domains bulk destroy
     *
     * @param      BulkDestroyRequest $request
     */
    public function bulkDestroy(BulkDestroyRequest $request)
    {
        $this->crudService->bulkDestroy($request->ids);
        
        return response()->json(null, 204);
    }
    
    /**
     * Domains bulk toggle attribute
     *
     * @param      BulkToggleRequest $request
     */
    public function bulkToggle(BulkToggleRequest $request)
    {
        $this->crudService->bulkToggle($request->validated());
        
        return response()->json(null, 204);
    }
}