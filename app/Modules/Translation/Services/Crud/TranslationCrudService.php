<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Services\Crud;

use App\Modules\Translation\Models\Translation;

/**
 * Class TranslationCrudService
 */
class TranslationCrudService
{
    /*
     * @param    array $data
     * @return  Translation
     */
    public function store(array $data): Translation
    {
        $translation = Translation::create($data);
        
        return $translation;
    }

    /*
     * @param    Translation $translation
     * @param    Translation $data
     * @return  Translation
     */
    public function update(Translation $translation, array $data): Translation
    {
        $translation->update($data);
        
        return $translation;
    }

    /*
     * @param    Translation $translation
     * @return  void
     */
    public function destroy(Translation $translation): void
    {
        $translation->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Translation::destroy($ids);
    }
    
    /*
     * @param      array $data
     * @return    void
     */
    public function bulkToggle(array $data): void
    {
        foreach (Translation::whereIn('id', $data['ids'])->get() as $user) {
            $attr = $data['attribute'];
            $user->$attr = $data['value'];
            $user->save();
        }
    }
    
}
