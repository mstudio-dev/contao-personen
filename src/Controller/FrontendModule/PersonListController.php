<?php

declare(strict_types=1);

namespace Mstudio\ContaoPersonenBundle\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Database;
use Contao\FilesModel;
use Contao\ModuleModel;
use Contao\Pagination;
use Contao\StringUtil;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(category: 'person')]
class PersonListController extends AbstractFrontendModuleController
{
    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        // Get selected member groups
        $selectedGroups = StringUtil::deserialize($model->person_groups, true);
        
        if (empty($selectedGroups)) {
            return new Response('');
        }

        // Build WHERE clause for member groups
        $groupConditions = [];
        foreach ($selectedGroups as $groupId) {
            $groupConditions[] = "groups LIKE '%:\"" . (int)$groupId . "\"%'";
        }
        
        $where = '(' . implode(' OR ', $groupConditions) . ') AND disable != 1';

        // Get sorting
        $sorting = $this->getSorting($model->person_sortBy ?: 'lastname_asc');
        
        // Count total results
        $db = Database::getInstance();
        $total = $db->prepare("SELECT COUNT(*) as total FROM tl_member WHERE " . $where)
                    ->execute()
                    ->total;

        // Pagination
        $perPage = (int)$model->person_perPage ?: 0;
        $page = $request->query->getInt('page', 1);
        $offset = 0;
        
        if ($perPage > 0) {
            $offset = ($page - 1) * $perPage;
        }

        // Get members
        $query = "SELECT id, firstname, lastname, academicTitle, qualification, profileImage 
                  FROM tl_member 
                  WHERE " . $where . " 
                  ORDER BY " . $sorting;
        
        if ($perPage > 0) {
            $query .= " LIMIT " . $perPage . " OFFSET " . $offset;
        }
        
        $members = $db->execute($query);

        // Prepare data
        $items = [];
        while ($members->next()) {
            $item = $members->row();
            
            // Get profile image
            if ($item['profileImage']) {
                $fileModel = FilesModel::findByUuid($item['profileImage']);
                $item['profileImagePath'] = $fileModel ? $fileModel->path : null;
            }
            
            $items[] = $item;
        }

        $template->items = $items;
        $template->empty = empty($items);

        // Pagination
        if ($perPage > 0 && $total > $perPage) {
            $pagination = new Pagination($total, $perPage, 7, 'page', $template);
            $template->pagination = $pagination->generate();
        }

        return $template->getResponse();
    }

    private function getSorting(string $sortBy): string
    {
        return match($sortBy) {
            'lastname_desc' => 'lastname DESC',
            'firstname_asc' => 'firstname ASC',
            'firstname_desc' => 'firstname DESC',
            'dateAdded_asc' => 'dateAdded ASC',
            'dateAdded_desc' => 'dateAdded DESC',
            default => 'lastname ASC',
        };
    }
}
