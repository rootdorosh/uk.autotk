<?php 

namespace App\Modules\Core\Admin\Http\Requests\Page;

/**
 * Class BulkDestroyRequest
 * 
 * @package  App\Modules\Core
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
                'exists:core_pages,id',
            ],
        ];
    }
}
