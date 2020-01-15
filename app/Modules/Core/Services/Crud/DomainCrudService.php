<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Services\Crud;

use App\Modules\Core\Models\Domain;

/**
 * Class DomainCrudService
 */
class DomainCrudService
{
    /*
     * @param    array $data
     * @return  Domain
     */
    public function store(array $data): Domain
    {
        $domain = Domain::create($data);
        
        return $domain;
    }

    /*
     * @param    Core $domain
     * @param    Domain $data
     * @return  Domain
     */
    public function update(Domain $domain, array $data): Domain
    {
        $domain->update($data);
        
        return $domain;
    }

    /*
     * @param    Domain $domain
     * @return  void
     */
    public function destroy(Domain $domain): void
    {
        $domain->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Domain::destroy($ids);
    }
    
    /*
     * @param      array $data
     * @return    void
     */
    public function bulkToggle(array $data): void
    {
        foreach (Domain::whereIn('id', $data['ids'])->get() as $user) {
            $attr = $data['attribute'];
            $user->$attr = $data['value'];
            $user->save();
        }
    }
    
}
