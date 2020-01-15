<?php

namespace App\Modules\Auto\Services\View;

use Illuminate\Support\Collection;
use App\Modules\Auto\Models\ModelView;
use App\Modules\Auto\Models\Model;
use App\Modules\Core\Models\Domain;
use App\Base\ViewService;
use FrontPage;

/**
 * Class ModelViewService
 */
class ModelViewService extends ViewService
{    
    /**
     * @param int $modelId
     * @return void
     */
    public function add(int $modelId)
    {
        $key = '_model_' . $modelId;
        
        if (!$this->hasView($key)) {
        
            ModelView::create([
                'model_id' => $modelId,
                'domain_id' => FrontPage::getDomain()->id,
            ]);
            
            $this->setView($key);
        }
    } 
}
