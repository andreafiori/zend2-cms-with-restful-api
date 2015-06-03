<?php

namespace Admin\Controller\Photo;

use ModelModule\Model\Posts\PostsControllerHelper;
use ModelModule\Model\Posts\PostsForm;
use ModelModule\Model\Posts\PostsGetter;
use ModelModule\Model\Posts\PostsGetterWrapper;
use Application\Controller\SetupAbstractController;

class PhotoFormController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params()->fromRoute('id');

        $helper = new PostsControllerHelper();
        $recordFromDb = $helper->recoverWrapperRecordsById(
            new PostsGetterWrapper(new PostsGetter($em)),
            array('id' => $id, 'limit' => 1),
            $id
        );

        $form = new PostsForm();
        $form->addUploadImageRequired();
        $form->addTitle();
        $form->addSubtitle();
        $form->addMainFields();

        if (!empty($recordFromDb)) {
            $form->setData($recordFromDb[0]);

            $submitButtonValue  = 'Modifica';
            $formTitle          = 'Modifica foto';
            $formAction         = '#';
        } else {
            $formTitle          = 'Nuova foto';
            $submitButtonValue  = 'Inserisci';
            $formAction         = '#';
        }

        $this->layout()->setVariables( array(
                'formTitle'                     => $formTitle,
                'formDescription'               => 'Compila i dati relativi alla foto',
                'form'                          => $form,
                'formAction'                    => $formAction,
                'submitButtonValue'             => $submitButtonValue,
                'formBreadCrumbCategory'        => 'Galleria foto',
                'imageValidation'               => 1,
                'formBreadCrumbCategoryLink'    => $this->url()->fromRoute('admin/photo-summary', array(
                    'lang'              => 'it',
                    'languageSelection' => 'it',
                )),
                'noCKEditor'                    => 1,
                'templatePartial'               => self::formTemplate,
            )
        );

        $this->layout()->setTemplate($mainLayout);
    }
}