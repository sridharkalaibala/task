<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\ApiTools\Admin\Module as AdminModule;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use function class_exists;

class IndexController extends AbstractActionController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->redirect()->toUrl('api-tools/swagger/Api-v1');
    }

    /**
     * @return Response|ViewModel
     */
    public function toolsAction()
    {
        if (class_exists(AdminModule::class, false)) {
            return $this->redirect()->toRoute('api-tools/ui');
        }
        return new ViewModel();
    }
}
