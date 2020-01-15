<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Services\Crud;

use App\Modules\Core\Models\Page;
use App\Modules\Core\Models\Seo;
use App\Modules\Core\Models\Banner;

/**
 * Class PageCrudService
 */
class PageCrudService
{
    /*
     * @param    array $data
     * @return  Page
     */
    public function store(array $data): Page
    {
        $page = Page::create($data);
        
        $this->syncSeo($page, $data);
        $this->syncBanners($page, $data);
        
        return $page;
    }

    /*
     * @param    Core $page
     * @param    Page $data
     * @return  Page
     */
    public function update(Page $page, array $data): Page
    {
        $page->update($data);
        
        $this->syncSeo($page, $data, true);
        $this->syncBanners($page, $data, true);
        
        return $page;
    }

    /*
     * @param    Page $page
     * @param    array $data
     * @param    bool $removeOld
     * @return  void
     */
    public function syncSeo(Page $page, array $data, bool $removeOld = false): void
    {
        if ($removeOld) {
            Seo::where('page_id', $page->id)->delete();
        }
        
        if (!empty($data['seo']) && is_array($data['seo'])) {
            foreach ($data['seo'] as $domainId => $seoAttrs) {
                $seoAttrs['page_id'] = $page->id;
                $seoAttrs['domain_id'] = $domainId;
                Seo::create($seoAttrs);
            }
        }
    }

    /*
     * @param    Page $page
     * @param    array $data
     * @param    bool $removeOld
     * @return  void
     */
    public function syncBanners(Page $page, array $data, bool $removeOld = false): void
    {
        if ($removeOld) {
            Banner::where('page_id', $page->id)->delete();
        }
        
        if (!empty($data['banners']) && is_array($data['banners'])) {
            foreach ($data['banners'] as $domainId => $positions) {
                foreach ($positions as $position => $content) {
                    if ($content === null || trim($content) === '') {
                        continue;
                    }
                    
                    $attrs['page_id'] = $page->id;
                    $attrs['domain_id'] = $domainId;
                    $attrs['position'] = $position;
                    $attrs['content'] = $content;
                    Banner::create($attrs);
                }
            }
        }        
    }

    /*
     * @param    Page $page
     * @return  void
     */
    public function destroy(Page $page): void
    {
        $page->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Page::destroy($ids);
    }
    
    /*
     * @param      array $data
     * @return    void
     */
    public function bulkToggle(array $data): void
    {
        foreach (Page::whereIn('id', $data['ids'])->get() as $user) {
            $attr = $data['attribute'];
            $user->$attr = $data['value'];
            $user->save();
        }
    }
    
}
