<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Admin\Http\Requests\Translation;

use App\Base\Requests\BaseSimpleRequest;

/**
 * Class CreateRequest
 */
class CreateRequest extends BaseSimpleRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('translation.translation.store');
    }
}
