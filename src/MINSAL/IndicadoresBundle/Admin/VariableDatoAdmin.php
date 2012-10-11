<?php

namespace MINSAL\IndicadoresBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class VariableDatoAdmin extends Admin {

    protected $datagridValues = array(
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'nombre' // name of the ordered field (default = the model id field, if any)
    );

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('idSentencia', null, array('label' => $this->getTranslator()->trans('sentencia_sql'), 'required'=>false))
                ->add('nombre', null, array('label' => $this->getTranslator()->trans('nombre_variable')))
                ->add('iniciales', null, array('label' => $this->getTranslator()->trans('iniciales')))
                ->add('idFuenteDato', null, array('label' => $this->getTranslator()->trans('fuente_datos')))
                ->add('idResponsableDato', null, array('label' => $this->getTranslator()->trans('responsable_datos')))
                ->add('confiabilidad', null, array('label' => $this->getTranslator()->trans('confiabilidad')))
                ->add('comentario', null, array('label' => $this->getTranslator()->trans('comentario'), 'required'=>false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('nombre', null, array('label' => $this->getTranslator()->trans('nombre')))
                ->add('iniciales', null, array('label' => $this->getTranslator()->trans('iniciales')))
                ->add('idResponsableDato', null, array('label' => $this->getTranslator()->trans('responsable_datos')))
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('idFuenteDato', null, array('label' => $this->getTranslator()->trans('fuente_datos')))
                ->add('idResponsableDato', null, array('label' => $this->getTranslator()->trans('responsable_datos')))
                ->addIdentifier('nombre', null, array('label' => $this->getTranslator()->trans('nombre_variable')))
                ->add('iniciales', null, array('label' => $this->getTranslator()->trans('iniciales')))
                ->add('confiabilidad', null, array('label' => $this->getTranslator()->trans('confiabilidad')))
                ->add('idSentencia', null, array('label' => $this->getTranslator()->trans('sentencia_sql')))

        ;
    }

    public function validate(ErrorElement $errorElement, $object) {
        $errorElement
                ->with('confiabilidad')
                    ->assertMin(array('limit'=>0))
                    ->assertMax(array('limit'=>100))
                ->end()
        ;
    }

    public function getBatchActions() {
        $actions = parent::getBatchActions();
        $actions['delete'] = null;
    }

}

?>