<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\CustomFormsBuilder\Block\Adminhtml\Form\Edit\Tab;

use Alekseon\AlekseonEav\Model\Adminhtml\System\Config\Source\InputType;
use Alekseon\AlekseonEav\Api\Data\EntityInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class General
 * @package Alekseon\CustomFormsBuilder\Block\Adminhtml\Form\Edit\Tab
 */
class General extends \Alekseon\AlekseonEav\Block\Adminhtml\Entity\Edit\Form implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $dataObject;

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('General');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getDataObject()
    {
        if (null === $this->dataObject) {
            return $this->_coreRegistry->registry('current_form');
        }
        return $this->dataObject;
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $dataObject = $this->getDataObject();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $baseFieldset = $form->addFieldset('base_fieldset', ['legend' => __('Form Properties')]);

        if ($dataObject->getId()) {
            $baseFieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $this->addAllAttributeFields($baseFieldset, $dataObject);
        $this->setForm($form);

        return parent::_prepareForm();
    }


    /**
     * Initialize form fileds values
     *
     * @return $this
     */
    protected function _initFormValues()
    {
        $this->getForm()->addValues($this->getDataObject()->getData());
        return parent::_initFormValues();
    }
}