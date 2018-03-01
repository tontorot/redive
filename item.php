<?php
require("common/db.php");

switch ($_REQUEST['action'])
{
  case 'キャラ詳細表示':
    $_temp['chara_info'] = get_chara_info($_REQUEST);
    break;
  case 'キャラ名新規登録':
    add_chara_name($_REQUEST);
    break;
  case 'アイテム新規登録':
    add_item($_REQUEST);
    break;
  case 'キャラ装備登録':
    add_chara_equip($_REQUEST);
    break;

  default:
    # code...
    break;
}

$_temp['item_list'] = get_list('redive','item_info');
$_temp['chara_name_list'] = get_list('redive','chara_name');
$_output = '';
require('header.tpl');
require('item.tpl');
require('footer.tpl');
echo $_output;
// $indexed_item_list = get_indexed_item_list();
// print_r($indexed_item_list);

function get_chara_info($request)
{
  $chara_id = $request['chara_id'];
  $where_params = array();
  $where_params['chara_id'] = $chara_id;
  $chara_name_info = get('redive','chara_name',$where_params);
  // print_r($chara_name_info);
  $chara_info = get_list('redive','chara_info',$where_params);
  // print_r($chara_info);
  $indexed_item_list = get_indexed_item_list();
  // print_r($indexed_item_list);

  $return_params = array();
  $return_params['chara_name'] = $chara_name_info['chara_name'];

  $equip_params = array();
  foreach ($chara_info as $equip)
  {
    $rank = $equip['rank'];
    $equip_params[$rank] = array();
    $equip_params[$rank][] = $indexed_item_list[$equip['item_id1']]['item_name'];
    $equip_params[$rank][] = $indexed_item_list[$equip['item_id2']]['item_name'];
    $equip_params[$rank][] = $indexed_item_list[$equip['item_id3']]['item_name'];
    $equip_params[$rank][] = $indexed_item_list[$equip['item_id4']]['item_name'];
    $equip_params[$rank][] = $indexed_item_list[$equip['item_id5']]['item_name'];
    $equip_params[$rank][] = $indexed_item_list[$equip['item_id6']]['item_name'];
  }
  $return_params['equip'] = $equip_params;
  // print_r($return_params);
  // TODO:必要アイテム一覧を出す
  return $return_params;
}

function add_chara_name($request)
{
  $set_params = array();
  $set_params['chara_name'] = "'".htmlspecialchars($request['chara_name'])."'";
  insert('redive', 'chara_name', $set_params);
}

function add_item($request)
{
  //TODO　余裕があれば、アイテム名が重複するものは弾く
  $set_params = array();
  $set_params['item_name'] = "'".htmlspecialchars($request['item_name'])."'";
  $set_params['material_id1'] = $request['material_id1'];
  $set_params['require_num1'] = $request['require_num1'];
  $set_params['material_id2'] = $request['material_id2'];
  $set_params['require_num2'] = $request['require_num2'];
  $set_params['material_id3'] = $request['material_id3'];
  $set_params['require_num3'] = $request['require_num3'];
  insert('redive', 'item_info', $set_params);
}

function add_chara_equip($request)
{
  //TODO　余裕があれば、アイテム名が重複するものは弾く
  $set_params = array();
  $set_params['chara_id'] = $request['chara_id'];
  $set_params['rank'] = $request['rank'];
  $set_params['item_id1'] = $request['item_id1'];
  $set_params['item_id2'] = $request['item_id2'];
  $set_params['item_id3'] = $request['item_id3'];
  $set_params['item_id4'] = $request['item_id4'];
  $set_params['item_id5'] = $request['item_id5'];
  $set_params['item_id6'] = $request['item_id6'];
  insert('redive', 'chara_info', $set_params);
}

function get_indexed_item_list()
{
  $item_list = get_list('redive','item_info');
  $indexed_item_list = array();
  foreach ($item_list as $key => $item_data)
  {
    $item_data['parent_item_list'] = array();
    $item_data['children_item_list'] = array();
    $indexed_item_list[$item_data['item_id']] = $item_data;
  }

  foreach ($indexed_item_list as $item_id => $item_data)
  {
    if(!is_null($item_data['material_id1']))
    {
      $material_id = $item_data['material_id1'];
      $indexed_item_list[$item_id]['children_item_list'][$material_id] = $item_data['require_num1'];
      $indexed_item_list[$material_id]['parent_item_list'][$item_id] = $item_data['require_num1'];
    }
  }
  return $indexed_item_list;
}


?>
