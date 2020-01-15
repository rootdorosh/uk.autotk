<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Admin\Http\Requests\Page;

use App\Base\Requests\BaseFormRequest;
use App\Modules\Core\Services\Fetch\DomainFetchService;
use App\Modules\Core\Models\Banner;
use App\Modules\Core\Models\Seo;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Core
 *
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->page) ? 'store' : 'update';
        
        return $this->user()->hasPermission('core.page.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $domainIds = array_keys((new DomainFetchService)->getList());
        
        $rules = [
            'alias' => [
                'required',
                'string',
            ],
            'title' => [
                'required',
                'string',
            ],
            'banners' => [
                'nullable',
                'array',
                function($attribute, $value, $fail) use ($domainIds) {
                    foreach (array_keys($value) as $inputDomainId) {
                        if (!in_array($inputDomainId, $domainIds)) {
                            return $fail($attribute.' is invalid.');
                        }
                    }
                }
            ],
            'banners.*' => [
                'nullable',
                'array',
                function($attribute, $value, $fail) {
                    foreach (array_keys($value) as $inputBannerPosition) {
                        if (!in_array($inputBannerPosition, Banner::POSITIONS)) {
                            return $fail($attribute.' is invalid.');
                        }
                    }
                }
            ],
            'seo' => [
               'required',
               'array',
               function($attribute, $value, $fail) {
                    $ids = array_keys($value);
                    if (count((new DomainFetchService)->getList()) != count($ids)) {
                       return $fail($attribute.' is invalid.');
                    }
                }
            ],
            'seo.*.url' => [
                'required',
                'string',
                'max:255',
            ],    
            'seo.*.title' => [
                'required',
                'string',
                'max:255',
            ],    
            'seo.*.description' => [
                'required',
                'string',
                'max:255',
            ],    
            'seo.*.keywords' => [
                'nullable',
                'string',
                'max:255',
            ],    
            'seo.*.breadc_label' => [
                'required',
                'string',
                'max:255',
            ],    
            'seo.*.breadc_title' => [
                'required',
                'string',
                'max:255',
            ],    
            'seo.*.header_text' => [
                'nullable',
                'string',
            ],    
            'seo.*.footer_text' => [
                'nullable',
                'string',
            ],    
            'seo.*.h1' => [
                'required',
                'string',
                'max:255',
            ],    
        ];
                
        return $rules;
    }
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        $attributes = $this->getAttributesLabels('Core', 'Page');
        
        foreach ((new Seo)->fillable as $attr) {
            $attributes["seo.*.$attr"] = __('core::seo.fields.' . $attr);
        }
        
        return $attributes;
    }
}