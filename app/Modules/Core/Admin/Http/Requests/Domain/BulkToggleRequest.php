<?php 

namespace App\Modules\Core\Admin\Http\Requests\Domain;

/**
 * Class BulkToggleRequest
 * 
 * @package  App\Modules\Core
 *
 */
class BulkToggleRequest extends DestroyRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return allow('core.domain.update');
    }    

    /*
     * @return  array
     */
    public function rules(): array
    {
        return [
            'ids'   => [
                'required',
                'array',
            ],
            'ids.*' => [
                'required',
                'integer',
                'exists:core_domains,id',
            ],
            'attribute' => [
                'required',
                'string',
                'in:is_active',
            ],
            'value' => [
                'required',
                'integer',
                'in:0,1',
            ],
        ];
    }
}
