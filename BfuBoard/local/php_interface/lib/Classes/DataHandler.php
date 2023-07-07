<?php

namespace ScrumBoard;

class DataHandler
{
    private $OPERATION_TYPE;
    private $REQUEST_DATA;
    private $ELEMENT_ID;

    private static $IBLOCK_TASK_ID = 1;
    private $ELEMENT_DATA;
    private static $DEL_ACTION = 'delete';
    private static $ADD_ACTION = 'create';
    private static $CHANGE_ACTION = 'change';
    public function __construct(array $data)
    {

        $this -> OPERATION_TYPE = $data['operation'];
        \Bitrix\Main\Loader::includeModule('iblock');
        unset($data['operation']);
        $this -> REQUEST_DATA = $data;
        $this -> ELEMENT_ID = $data['id'];
    }

    public function Initialize()
    {
        if($this->OPERATION_TYPE === self::$DEL_ACTION)
        {
            return  ( $this -> DeleteTask($this -> REQUEST_DATA['ID']) );
        }
        $this->CollectFields();
        if($this->OPERATION_TYPE === self::$ADD_ACTION)
        {
            $this->ELEMENT_DATA['IBLOCK_ID'] = self::$IBLOCK_TASK_ID;
            return ( $this -> CreateTask() );
        }
        elseif($this->OPERATION_TYPE === self::$CHANGE_ACTION)
        {
           return( $this -> ChangeTask() );
        }
    }

    private function CollectFields()
    {

        $elementFields = array(
            'NAME' => $this -> REQUEST_DATA['name'],
            'DETAIL_TEXT' => $this -> REQUEST_DATA['description'],
            'IBLOCK_SECTION_ID' => $this -> REQUEST_DATA['status'],
        );
        $imageData = array();
        if($this -> REQUEST_DATA['image'])
        {
            $imageData = CFile::MakeFileArray($this -> REQUEST_DATA['image']);
        }

        $elementFields['PREVIEW_PICTURE'] = $imageData;
        $elementFields['DETAIL_PICTURE'] = $imageData;
        $properties = array(
            'DATE_END' => $this -> REQUEST_DATA['date-end'],
            'TASK_MEMBERS' => $this -> REQUEST_DATA['member-list'],
        );
        $elementFields['PROPERTY_VALUES'] = $properties;

        $this -> ELEMENT_DATA = $elementFields;

    }
    private function DeleteTask($id)
    {
        $element = new \CIBlockElement();
        return($element -> Delete($id));
    }

    private function CreateTask()
    {
        $element = new \CIBlockElement();

        return ($element -> Add($this -> ELEMENT_DATA));
    }

    private function ChangeTask()
    {
        $element = new \CIBlockElement();
        return ($element -> Update($this -> ELEMENT_ID ,$this -> ELEMENT_DATA));
    }
}