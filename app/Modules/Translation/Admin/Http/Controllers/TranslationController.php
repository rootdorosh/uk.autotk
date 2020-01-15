<?php 

namespace App\Modules\Translation\Admin\Http\Controllers;

use App\Base\AdminController;
use App\Modules\Translation\Services\Crud\TranslationCrudService;
use App\Modules\Translation\Models\Translation;
use App\Modules\Translation\Admin\Http\Requests\Translation\{
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
class TranslationController extends AdminController
{
    /*
     * var TranslationCrudService
     */
    protected $crudService;
            
    /*
     * @param  TranslationCrudService     $crudService
     */
    public function __construct(TranslationCrudService $crudService)
    {
        $this->crudService = $crudService;
    }
    
    /**
     * Translations list
     *
     * @param      IndexFilter $request
     */
    public function index(IndexFilter $modelFilter)
    {
        if ($modelFilter->ajax()) {
            return $modelFilter->getData();
        }
        
        return $this->view('translation.index', compact('modelFilter'));
    }

    /**
     * Translation create
     *
     * @param      CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $translation = new Translation;
        
        return $this->view('translation.create', compact('translation'));       
    }

    /**
     * Translation store
     *
     * @param      FormRequest $request
     */
    public function store(FormRequest $request)
    {
        $translation = $this->crudService->store($request->validated());
        
        return redirect(r('admin.translation.translations.index'))
            ->with('success', __('translation::translation.success.created'));       
    }

    /**
     * Translation edit
     *
     * @param      Translation $translation
     * @param      EditRequest $request
     */
    public function edit(Translation $translation, EditRequest $request)
    {
        return $this->view('translation.update', compact('translation'));       
    }

    /**
     * Translation update
     *
     * @param      Translation $translation
     * @param      FormRequest $request
     */
    public function update(Translation $translation, FormRequest $request)
    {
        $translation = $this->crudService->update($translation, $request->validated());
        
        return redirect(r('admin.translation.translations.index')) 
            ->with('success', __('translation::translation.success.updated'));       
    }

    /**
     * Translation destroy
     *
     * @param      DestroyRequest $request
     * @param      Translation $translation
     */
    public function destroy(Translation $translation, DestroyRequest $request)
    {
        $this->crudService->destroy($translation);
        
        return response()->json(null, 204);
    }
    
    /**
     * Translations bulk destroy
     *
     * @param      BulkDestroyRequest $request
     */
    public function bulkDestroy(BulkDestroyRequest $request)
    {
        $this->crudService->bulkDestroy($request->ids);
        
        return response()->json(null, 204);
    }
    
    /**
     * Translations bulk toggle attribute
     *
     * @param      BulkToggleRequest $request
     */
    public function bulkToggle(BulkToggleRequest $request)
    {
        $this->crudService->bulkToggle($request->validated());
        
        return response()->json(null, 204);
    }
}