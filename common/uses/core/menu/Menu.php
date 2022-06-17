<?php

namespace common\uses\core\menu;

use common\models\shop\Category;
use common\models\shop\CategoryObjective;
use common\models\shop\Objective;

/**
 * Класс для сборки меню
 * @author Spirkov Maksim
 */
class Menu
{
    /** @var array категории*/
    public $categories;

    /** @var array подкатегории*/
    public $objectives;

    public static function loadMenu()
    {
        $menu = new Menu();
        $menu->categories = Category::getAllCategories();
        
        foreach ($menu->categories as $category) {
            $objectiveIds = CategoryObjective::findObjectivesByCategoryId($category->id);
            $menu->objectives[$category->id] = Objective::findByIds($objectiveIds);
        }

        return $menu;
    }
}
