<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Admin\Http\Requests\Page;

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
        return $this->user()->hasPermission('core.page.store');
    }
}
