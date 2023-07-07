<?php

namespace ScrumBoard;
\Bitrix\Main\Loader::includeModule('iblock');
class Helper
{
    private static $BOARDS_IB_ID = 1;
    private static $BASIC_STRUCTURE_NAMES = array(
        'В разработке',
        'Завершено',
        'Нужно сделать',
        'Просрочено'
    );
    private static function GetTeamInfo($teamID){
        $arSelect = Array("ID",'NAME','PROPERTY_TEAM_BOARDS','PROPERTY_TEAM_MEMBERS','PROPERTY_TEAM_LEADER');
        $arFilter = Array("IBLOCK_ID"=>IntVal(3),"ACTIVE"=>"Y",'ID'=> $teamID);
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
        $boards = array();
        $users = array();
        $boardsRaw = array();
        $name = '';
        $leader = 0;
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $boards[$arFields['PROPERTY_TEAM_BOARDS_VALUE']] = $arFields['PROPERTY_TEAM_BOARDS_VALUE'];
            $boardsRaw[] = $arFields['PROPERTY_TEAM_BOARDS_VALUE'];

            $name = $arFields['NAME'];
            $users[$arFields['PROPERTY_TEAM_MEMBERS_VALUE']] = $arFields['PROPERTY_TEAM_MEMBERS_VALUE'];
            if($arFields['PROPERTY_TEAM_LEADER_VALUE'] != 0){
                $leader = $arFields['PROPERTY_TEAM_LEADER_VALUE'];
            }


        }

        return array(
            'BOARDS' => $boards,
            'BOARDS_RAW' => $boardsRaw,
            'MEMBERS' => $users,
            'LEADER' => $leader,
            'NAME' => $name
        );

    }
    public static function GetUserTeam($id)
    {

        $arSelect = Array("ID", "PROPERTY_TEAM_MEMBERS");
        $arFilter = Array("IBLOCK_ID"=>IntVal(3),"ACTIVE"=>"Y");
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            if($arFields['PROPERTY_TEAM_MEMBERS_VALUE'] == $id){
                return $arFields['ID'];
            }
        }
        return 0;
    }
    public static function GetTeamBoards($teamID){
        return(self::GetTeamInfo($teamID)['BOARDS']);
    }

    public static function declination($number, $names) {
        $cases = array (2, 0, 1, 1, 1, 2);
        $format = $names[($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
        return($format);
    }
    public static function GetTeamBoardsRaw($teamID){
        return(self::GetTeamInfo($teamID)['BOARDS_RAW']);
    }
    public static function GetTeamName($teamID){
        return(self::GetTeamInfo($teamID)['NAME']);
    }
    public static function GetTeamMembers($teamID){
        return(self::GetTeamInfo($teamID)['MEMBERS']);
    }
    public static function GetUserNames($arUserID): array
    {
        $arNames = array();
        foreach ($arUserID as $id){
            $rsUser = \CUser::GetByID($id);

            $arUser = $rsUser->Fetch();
            $arNames[] = $arUser['LOGIN'];
        }
        return $arNames;
    }

    public static function AddMemberToTeam($teamID,$userID){
        $members = self::GetTeamMembers($teamID);
        $members[$userID] = strval($userID);
        \CIBlockElement::SetPropertyValuesEx($teamID, false, array('TEAM_MEMBERS' => $members));
    }

    public static function AddBoardToTeam($teamID,$boardID){
        $boards = array();
        if(!empty($boards = self::GetTeamBoardsRaw($teamID))){
            $boards = self::GetTeamBoardsRaw($teamID);
        }
        $boards[] = $boardID;
        \CIBlockElement::SetPropertyValuesEx($teamID,3,array('TEAM_BOARDS' => $boards));
    }

    public static function IsTeamLeader($teamID,$userID){
        return($userID == self::GetTeamInfo($teamID)['LEADER']);
    }

    public static function GetBoardName($boardID){

        $arFilter = Array('IBLOCK_ID'=>self::$BOARDS_IB_ID, 'GLOBAL_ACTIVE'=>'Y','ID'=>$boardID);
        $db_list = \CIBlockSection::GetList(Array(), $arFilter, false,array('NAME',"ID"));
        $ar_result = $db_list->GetNext();
        return $ar_result['NAME'];
    }
    private static function CreateBaseBoardStructure($boardID){
        foreach (self::$BASIC_STRUCTURE_NAMES as $name){
            $bs = new \CIBlockSection;
            $arFields = Array(
                "IBLOCK_ID" => self::$BOARDS_IB_ID,
                "NAME" => $name,
                'IBLOCK_SECTION_ID' => $boardID
            );

            $bs->Add($arFields);
        }
    }

    public static function CreateNewBoard($team,$name){
        $bs = new \CIBlockSection;

        $arFields = Array(
            "IBLOCK_ID" => self::$BOARDS_IB_ID,
            "NAME" => $name,
        );

        $id = $bs->Add($arFields);
        self::CreateBaseBoardStructure($id);
        self::AddBoardToTeam($team,$id);
    }
}