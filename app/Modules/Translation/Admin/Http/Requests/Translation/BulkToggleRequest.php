<?php 

namespace App\Modules\Translation\Admin\Http\Requests\Translation;

/**
 * Class BulkToggleRequest
 * 
 * @package  App\Modules\Translation
 *
 */
class BulkToggleRequest extends DestroyRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return allow('translation.translation.update');
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
                'exists:translations,id',
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
