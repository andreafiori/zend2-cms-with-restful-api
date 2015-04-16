<?php

namespace Admin\Controller\Posts;

use Admin\Model\Posts\CategoriesGetter;
use Admin\Model\Posts\CategoriesGetterWrapper;
use Admin\Model\Posts\PostsGetter;
use Admin\Model\Posts\PostsGetterWrapper;
use Admin\Model\Posts\PostsSearchForm;
use Application\Controller\SetupAbstractController;
use Zend\View\Model\ViewModel;

/**
 * @author Andrea Fiori
 * @since  12 April 2015
 */
class BlogsSummaryController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $entityManager  = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $page       = $this->params()->fromRoute('page');
        $perPage    = $this->params()->fromRoute('perpage');

        $wrapper = new PostsGetterWrapper( new PostsGetter($entityManager) );
        $wrapper->setInput( array(
                'moduleCode' => 'blogs',
                'userId'     => null,
                'orderBy'    => 'p.id DESC',
            )
        );
        $wrapper->setupQueryBuilder();
        $wrapper->setupPaginator($wrapper->setupQuery($entityManager));
        $wrapper->setupPaginatorCurrentPage(isset($page) ? $page : null);
        $wrapper->setupPaginatorItemsPerPage(isset($perPage) ? $perPage : null);

        $paginator      = $wrapper->getPaginator();

        $postsRecords = $wrapper->setupRecords();

        foreach($postsRecords as &$postsRecord) {

            $wrapper = new PostsGetterWrapper( new PostsGetter($entityManager) );
            $wrapper->setInput( array(
                    'fields'     => 'co.id, co.name',
                    'id'         => $postsRecord['postid'],
                    'orderBy'    => 'co.name',
                )
            );
            $wrapper->setupQueryBuilder();
            $postsRecord['categories'] = $wrapper->getRecords();
        }

        $columnRecords  = $this->formatColumnRecords($postsRecords);

        $wrapper = new CategoriesGetterWrapper(new CategoriesGetter($entityManager));
        $wrapper->setInput(array(
            'fields'        => 'category.id, co.name',
            'orderBy'       => 'co.name',
            'moduleCode'    => 'blogs',
        ));
        $wrapper->setupQueryBuilder();

        $categoriesRecords = $wrapper->getRecords();

        $selectArray = array();
        foreach($categoriesRecords as $categoriesRecord) {
            $id = isset($categoriesRecord['id']) ? $categoriesRecord['id'] : null;
            $name = isset($categoriesRecord['name']) ? $categoriesRecord['name'] : null;
            $selectArray[$id] = $name;
        }

        $form = new PostsSearchForm();
        $form->addCategories($selectArray);

        $this->layout()->setVariables(array(
            'tableTitle'        => 'Blogs',
            'tableDescription'  => $paginator->getTotalItemCount().' posts in archivio',

            'columns' => array(
                "Titolo",
                "Categorie",
                "Tags",
                "Inserito da",
                "Ultima modifica",
                "&nbsp;",
                "&nbsp;",
                "&nbsp;"
            ),

            'paginator'         => $paginator,
            'records'           => $columnRecords,
            'searchFilterForm'  => $form,
        ));

        $this->layout()->setVariable('templatePartial', 'datatable/datatable_posts.phtml');

        $this->layout()->setTemplate($mainLayout);

        return new ViewModel();
    }

        /**
         * @param mixed $records
         * @return array
         */
        private function formatColumnRecords($records)
        {
            $recordsToReturn = array();
            foreach($records as $record) {

                $categoryToPrint = '';
                foreach($record['categories'] as $category) {
                    $categoryToPrint .= $category['name']."<br>";
                }

                $recordsToReturn[] = array(
                    $record['title'],
                    $categoryToPrint,
                    '',
                    $record['userName'].' '.$record['userSurname'],
                    "<strong>Inserito il:</strong> ".date("d-m-Y", strtotime($record['insertDate']))."<br><br><strong>Ultima modifica:</strong> ".date("d-m-Y", strtotime($record['lastUpdate'])),
                    array(
                        'type'      => 'updateButton',
                        'href'      => $this->url()->fromRoute('admin/posts-form', array(
                            'lang'  => 'it',
                            'formtype' => 'blogs',
                            'id'    => $record['postid']
                        )),
                        'title'     => 'Modifica'
                    ),
                    array(
                        'type'      => 'deleteButton',
                        'title'     => 'Elimina',
                        'href'      => '#',
                        'data-id'   => $record['postoptionid']
                    ),
                    array(
                        'type'      => 'attachButton',
                        'href'      => '#',
                    ),
                );
            }

            return $recordsToReturn;
        }
}