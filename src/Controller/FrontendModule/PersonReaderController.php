<?php

declare(strict_types=1);

namespace Mstudio\ContaoPersonenBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Database;
use Contao\FilesModel;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(category: 'person')]
class PersonReaderController extends AbstractFrontendModuleController
{
    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        // Get person ID from URL
        $personId = $request->query->getInt('show', 0);
        
        if (!$personId) {
            return new Response('');
        }

        // Get member data
        $db = Database::getInstance();
        $member = $db->prepare(
            "SELECT * FROM tl_member WHERE id = ? AND disable != 1"
        )->execute($personId);

        if (!$member->numRows) {
            return new Response('');
        }

        $data = $member->row();

        // Get profile image
        if ($data['profileImage']) {
            $fileModel = FilesModel::findByUuid($data['profileImage']);
            $data['profileImagePath'] = $fileModel ? $fileModel->path : null;
        }

        // Get hero image
        if ($data['heroImage']) {
            $fileModel = FilesModel::findByUuid($data['heroImage']);
            $data['heroImagePath'] = $fileModel ? $fileModel->path : null;
        }

        $template->person = $data;

        return $template->getResponse();
    }
}
