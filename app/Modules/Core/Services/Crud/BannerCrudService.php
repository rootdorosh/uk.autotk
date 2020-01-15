<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Services\Crud;

use App\Modules\Core\Models\Banner;

/**
 * Class BannerCrudService
 */
class BannerCrudService
{
    /*
     * @param    array $data
     * @return  Banner
     */
    public function store(array $data): Banner
    {
        $banner = Banner::create($data);
        
        return $banner;
    }

    /*
     * @param    Core $banner
     * @param    Banner $data
     * @return  Banner
     */
    public function update(Banner $banner, array $data): Banner
    {
        $banner->update($data);
        
        return $banner;
    }

    /*
     * @param    Banner $banner
     * @return  void
     */
    public function destroy(Banner $banner): void
    {
        $banner->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Banner::destroy($ids);
    }
    
    /*
     * @param      array $data
     * @return    void
     */
    public function bulkToggle(array $data): void
    {
        foreach (Banner::whereIn('id', $data['ids'])->get() as $user) {
            $attr = $data['attribute'];
            $user->$attr = $data['value'];
            $user->save();
        }
    }
    
}
