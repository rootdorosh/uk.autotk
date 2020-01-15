<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Services\Crud;

use App\Modules\Core\Models\Seo;

/**
 * Class SeoCrudService
 */
class SeoCrudService
{
    /*
     * @param    array $data
     * @return  Seo
     */
    public function store(array $data): Seo
    {
        $seo = Seo::create($data);
        
        return $seo;
    }

    /*
     * @param    Core $seo
     * @param    Seo $data
     * @return  Seo
     */
    public function update(Seo $seo, array $data): Seo
    {
        $seo->update($data);
        
        return $seo;
    }

    /*
     * @param    Seo $seo
     * @return  void
     */
    public function destroy(Seo $seo): void
    {
        $seo->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Seo::destroy($ids);
    }
    
    /*
     * @param      array $data
     * @return    void
     */
    public function bulkToggle(array $data): void
    {
        foreach (Seo::whereIn('id', $data['ids'])->get() as $user) {
            $attr = $data['attribute'];
            $user->$attr = $data['value'];
            $user->save();
        }
    }
    
}
