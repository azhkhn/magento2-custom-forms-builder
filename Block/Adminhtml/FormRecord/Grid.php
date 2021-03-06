<?php
/**
 * Copyright © Alekseon sp. z o.o.
 * http://www.alekseon.com/
 */
namespace Alekseon\CustomFormsBuilder\Block\Adminhtml\FormRecord;

use Alekseon\AlekseonEav\Block\Adminhtml\Entity\Grid as EavGrid;

/**
 * Class Grid
 * @package Alekseon\CustomFormsBuilder\Block\Adminhtml\FormRecord
 */
class Grid extends EavGrid
{
    /**
     * @var \Alekseon\CustomFormsBuilder\Model\ResourceModel\FormRecord\CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Alekseon\CustomFormsBuilder\Model\ResourceModel\FormRecord\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Alekseon\CustomFormsBuilder\Model\ResourceModel\FormRecord\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        $this->setCollection($collection);
        $collection->addFieldToFilter('form_id', $this->getCurrentForm()->getId());
        $collection->getResource()->setCurrentForm($this->getCurrentForm());

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        $this->addAttributeColumns();
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getCurrentForm()
    {
        return $this->coreRegistry->registry('current_form');
    }

    /**
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit',
            [
                'id' => $row->getEntityId(),
                'form_id' => $this->getCurrentForm()->getId()
            ]
        );
    }
}
