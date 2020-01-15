<?php 

namespace App\Modules\Translation\Admin\Http\Requests\Translation;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Translation
 *
 */
class BulkDestroyRequest extends DestroyRequest
{
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
        ];
    }
}
