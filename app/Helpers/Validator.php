<?php

namespace App\Helpers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Item;

class Validator
{
    /**
     * Validate the category's fields on its storing
     * Fill the description on its absence
     * @param Request $request
     * @param array $data
     * @return array - validation rules
     */
    public static function categoryStore(Request $request, array &$data) {
        $validationRules = [
            'name' => 'required|min:3|max:128',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        // Validate Description if it's given
        if($request->description) {
            $validationRules['description'] = 'required|min:10|max:1024';
        } else {
            $data['description'] = '';
        }
        // Validate Alias if it's given
        if($request->alias) {
            $validationRules['alias'] = 'min:2|max:256';
        }
        return $validationRules;
    }

    /**
     * Validate the category's fields on its updating
     * Fill the description on its absence
     * Fill and validate the alias on its change
     * @param Request $request
     * @param $category
     * @param $data
     * @return array - validation rules
     */
    public static function categoryUpdate(Request $request, Category $category, &$data) {
        $validationRules = [
            'name' => 'required|min:3|max:128',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        if($request->description) {
            $validationRules['description'] = 'required|min:10|max:1024';
        } else {
            $data['description'] = '';
        }
        // Validate Alias if it was changed
        if($request->alias != $category->alias) {
            // Change Alias automatically by deleting
            if ($request->alias == null)
                $alias = $request->name;
            else {
                $validationRules['alias'] = 'min:2|max:256|unique:categories';
                $alias = $request->alias;
            }
            $data['alias'] = AliasProcessor::getAlias($alias, $category);
        }
        return $validationRules;
    }

    /**
     * Validate the item's fields on its updating
     * Fill and validate the alias on its change
     * @param $request
     * @param Item $item
     * @return array - validation rules
     */
    public static function itemUpdate($request, Item $item) {
        $validationRules =  [
            'title' => 'required|min:3|max:128',
            'text' => 'required|min:50|max:2048',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        // Validate Alias if it was changed
        if($request->alias != $item->alias) {
            // Change Alias automatically by deleting
            if ($request->alias == null)
                $alias = $request->title;
            else {
                $validationRules['alias'] = 'min:2|max:256|unique:items';
                $alias = $request->alias;
            }
            $item->alias = AliasProcessor::getAlias($alias, $item);
        }
        return $validationRules;
    }

    public static function itemStore($request) {
        $validationRules = [
            'title' => 'required|min:3|max:128',
            'text' => 'required|min:50|max:2048',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        // Validate Alias if it's given
        if($request->alias) {
            $validationRules['alias'] = 'min:2|max:256';
        }
        return $validationRules;
    }
}


