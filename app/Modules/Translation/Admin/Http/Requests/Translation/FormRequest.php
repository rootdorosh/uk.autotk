<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Admin\Http\Requests\Translation;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\Translation
 *
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->translation) ? 'store' : 'update';
        
        return $this->user()->hasPermission('translation.translation.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'slug' => [
                'required',
                'string',
            ],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.value'] = [
                'required',
                'string',
                'max:255',
            ];
        }
                
        return $rules;
    }
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Translation', 'Translation');
    }
}