<?php

class ItemModel extends Model{
    public function AddNewItemType($item_id, $item_name, $item_category, $min_stock, $max_stock){
        return $this->insert('items', ['item_id'=>$item_id, 'item_name'=>$item_name, 'item_category'=>$item_category, 'min_stock'=>$min_stock, 'max_stock'=>$max_stock, 'current_quantity'=>0]);
    }

    public function ViewItems(){
        return $this->select('items');
    }
}