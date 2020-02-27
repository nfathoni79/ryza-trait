<?php

namespace App;

use App\Item;
use App\Material;

class Searcher
{
    //
    private static $itemMemories = [];
    private static $materialMemories = [];

    private static $itemDepthMemories = [];
    private static $materialDepthMemories = [];

    private static $routeItems = [];
    private static $routeMaterials = [];

    private static $depth = 0;

    private static $fullRoutes = [];

    public static function searchRoutes(Item $fromItem, Item $toItem)
    {
        self::search($fromItem, $toItem);

        return self::$fullRoutes;
    }

    public static function search(Item $fromItem, Item $toItem)
    {
        // DISPLAY THE ITEM
        // echo self::tab(self::$depth) . $fromItem->name . "\n";
        // END DISPLAY THE ITEM

        if ($fromItem->id == $toItem->id)
        {
            // MARK THE FINAL ITEM
            // self::$depth++;
            // echo self::tab(self::$depth) . "VV\n";
            // self::$depth--;
            self::$depth--;
            // END MARK THE FINAL ITEM

            // PUSH AND DISPLAY THE TRUE ROUTE
            // array_push(self::$routeItems, $fromItem->id);
            // foreach (self::$routeItems as $item) {
            //     echo " -> " . Item::find($item)->name;
            // }
            // echo "\n";
            // array_pop(self::$routeItems);
            // END DISPLAY THE TRUE ROUTE AND POP

            // PUSH AND DISPLAY THE TRUE ROUTE WITH MATERIALS
            // array_push(self::$routeItems, $fromItem->id);
            //
            // for ($i=0; $i < count(self::$routeMaterials); $i++) {
            //     echo Item::find(self::$routeItems[$i])->name . " -> *" . Material::find(self::$routeMaterials[$i])->materialable->name . " -> ";
            // }
            //
            // echo Item::find(self::$routeItems[count(self::$routeItems) - 1])->name . "\n";
            //
            // array_pop(self::$routeItems);
            // END DISPLAY THE TRUE ROUTE WITH MATERIALS AND POP

            // ADD TO FULL ROUTES
            array_push(self::$routeItems, $fromItem->id);

            $items = [];
            $materials = [];

            foreach (self::$routeItems as $itemId) {
                array_push($items, Item::find($itemId));
            }

            array_pop(self::$routeItems);

            foreach (self::$routeMaterials as $materialId) {
                array_push($materials, Material::find($materialId));
            }

            $fullRoute = array($items, $materials);
            array_push(self::$fullRoutes, $fullRoute);
            // END ADD TO FULL ROUTES;

            return true;
        }

        if (in_array($fromItem->id, self::$itemMemories))
        {
            $memoryIndex = array_search($fromItem->id, self::$itemMemories);

            if (self::$depth >= self::$itemDepthMemories[$memoryIndex])
            {
                // MARK THE ITEM EXIST IN MEMORIES
                // self::$depth++;
                // echo self::tab(self::$depth) . "L\n";
                // self::$depth--;
                self::$depth--;
                // END MARK THE ITEM EXIST IN MEMORIES

                return false;
            }
            else
            {
                unset(self::$itemMemories[$memoryIndex]);
                unset(self::$itemDepthMemories[$memoryIndex]);

                array_push(self::$itemMemories, $fromItem->id);
                array_push(self::$itemDepthMemories, self::$depth);
                array_push(self::$routeItems, $fromItem->id);
            }
        }
        else
        {
            array_push(self::$itemMemories, $fromItem->id);
            array_push(self::$itemDepthMemories, self::$depth);
            array_push(self::$routeItems, $fromItem->id);
        }

        $materialableItems = [$fromItem->material];
        $materialableCategories = [];

        foreach ($fromItem->categories as $category) {
            array_push($materialableCategories, $category->material);
        }

        $materialSlots = array_merge($materialableItems, $materialableCategories);
        $materialSlots = collect($materialSlots);

        foreach ($materialSlots as $slot)
        {
            // DISPLAY THE MATERIAL SLOTS
            self::$depth++;
            // echo self::tab(self::$depth) . '*' . $slot->materialable->name . "\n";
            // END DISPLAY THE MATERIAL SLOTS

            if (in_array($slot->id, self::$materialMemories))
            {
                $memoryIndex = array_search($slot->id, self::$materialMemories);

                if (self::$depth >= self::$materialDepthMemories[$memoryIndex])
                {
                    // MARK THE MATERIAL EXIST IN MEMORIES
                    // self::$depth++;
                    // echo self::tab(self::$depth) . "L\n";
                    // self::$depth--;
                    self::$depth--;
                    // END MARK THE MATERIAL EXIST IN MEMORIES

                    continue;
                }
                else
                {
                    unset(self::$materialMemories[$memoryIndex]);
                    unset(self::$materialDepthMemories[$memoryIndex]);

                    array_push(self::$materialMemories, $slot->id);
                    array_push(self::$materialDepthMemories, self::$depth);
                    array_push(self::$routeMaterials, $slot->id);
                    // echo "AFTERPUSH\n";
                    // foreach (self::$routeMaterials as $material) {
                    //     echo "*" . Material::find($material)->materialable->name . "\n";
                    // }
                    // echo "ENDAFTERPUSH\n\n";
                }
            }
            else
            {
                array_push(self::$materialMemories, $slot->id);
                array_push(self::$materialDepthMemories, self::$depth);
                array_push(self::$routeMaterials, $slot->id);
                // echo "AFTERPUSH\n";
                // foreach (self::$routeMaterials as $material) {
                //     echo "*" . Material::find($material)->materialable->name . "\n";
                // }
                // echo "ENDAFTERPUSH\n\n";
            }

            $enterableItems = $slot->items;

            if ($enterableItems->count() < 1)
            {
                // MARK THE UN-ENTERABLE
                // self::$depth++;
                // echo self::tab(self::$depth) . "X\n";
                // self::$depth--;
                self::$depth--;
                // END MARK THE UN-ENTERABLE

                array_pop(self::$routeMaterials);
                // echo "AFTERPOP\n";
                // foreach (self::$routeMaterials as $material) {
                //     echo "*" . Material::find($material)->materialable->name . "\n";
                // }
                // echo "ENDAFTERPOP\n\n";

                continue;
            }

            foreach ($enterableItems as $enterableItem)
            {
                self::$depth++;
                $searchResult = self::search($enterableItem, $toItem);

                if (!$searchResult)
                {
                    continue;
                }
            }

            self::$depth--;

            array_pop(self::$routeMaterials);
            // echo "AFTERPOP\n";
            // foreach (self::$routeMaterials as $material) {
            //     echo "*" . Material::find($material)->materialable->name . "\n";
            // }
            // echo "ENDAFTERPOP\n\n";
        }

        self::$depth--;

        // DISPLAY ALL ROUTES EXCEPT THE TRUE ONE
        // echo "\n";
        // foreach (self::$routeItems as $item) {
        //     echo " -> " . Item::find($item)->name;
        // }
        // echo "\n\n";

        array_pop(self::$routeItems);
    }

    public static function searchAndDisplay(Item $fromItem, Item $toItem)
    {
        // DISPLAY THE ITEM
        echo self::tab(self::$depth) . $fromItem->name . "\n";
        // END DISPLAY THE ITEM

        if ($fromItem->id == $toItem->id)
        {
            // MARK THE FINAL ITEM
            self::$depth++;
            echo self::tab(self::$depth) . "VV\n";
            self::$depth--;
            self::$depth--;
            // END MARK THE FINAL ITEM

            // PUSH AND DISPLAY THE TRUE ROUTE
            // array_push(self::$routeItems, $fromItem->id);
            // echo "\n";
            // foreach (self::$routeItems as $item) {
            //     echo " -> " . Item::find($item)->name;
            // }
            // echo "\n\n";
            // array_pop(self::$routeItems);
            // END DISPLAY THE TRUE ROUTE AND POP

            return true;
        }

        if (in_array($fromItem->id, self::$itemMemories))
        {
            $memoryIndex = array_search($fromItem->id, self::$itemMemories);

            if (self::$depth >= self::$itemDepthMemories[$memoryIndex])
            {
                // MARK THE ITEM EXIST IN MEMORIES
                self::$depth++;
                echo self::tab(self::$depth) . "L\n";
                self::$depth--;
                self::$depth--;
                // END MARK THE ITEM EXIST IN MEMORIES

                return false;
            }
            else
            {
                unset(self::$itemMemories[$memoryIndex]);
                unset(self::$itemDepthMemories[$memoryIndex]);

                array_push(self::$itemMemories, $fromItem->id);
                array_push(self::$itemDepthMemories, self::$depth);
                array_push(self::$routeItems, $fromItem->id);
            }
        }
        else
        {
            array_push(self::$itemMemories, $fromItem->id);
            array_push(self::$itemDepthMemories, self::$depth);
            array_push(self::$routeItems, $fromItem->id);
        }

        $materialableItems = [$fromItem->material];
        $materialableCategories = [];

        foreach ($fromItem->categories as $category) {
            array_push($materialableCategories, $category->material);
        }

        $materialSlots = array_merge($materialableItems, $materialableCategories);
        $materialSlots = collect($materialSlots);

        foreach ($materialSlots as $slot)
        {
            // DISPLAY THE MATERIAL SLOTS
            self::$depth++;
            echo self::tab(self::$depth) . '*' . $slot->materialable->name . "\n";
            // END DISPLAY THE MATERIAL SLOTS

            if (in_array($slot->id, self::$materialMemories))
            {
                $memoryIndex = array_search($slot->id, self::$materialMemories);

                if (self::$depth >= self::$materialDepthMemories[$memoryIndex])
                {
                    // MARK THE MATERIAL EXIST IN MEMORIES
                    self::$depth++;
                    echo self::tab(self::$depth) . "L\n";
                    self::$depth--;
                    self::$depth--;
                    // END MARK THE MATERIAL EXIST IN MEMORIES

                    continue;
                }
                else
                {
                    unset(self::$materialMemories[$memoryIndex]);
                    unset(self::$materialDepthMemories[$memoryIndex]);

                    array_push(self::$materialMemories, $slot->id);
                    array_push(self::$materialDepthMemories, self::$depth);
                }
            }
            else
            {
                array_push(self::$materialMemories, $slot->id);
                array_push(self::$materialDepthMemories, self::$depth);
            }

            $enterableItems = $slot->items;

            if ($enterableItems->count() < 1)
            {
                // MARK THE UN-ENTERABLE
                self::$depth++;
                echo self::tab(self::$depth) . "X\n";
                self::$depth--;
                self::$depth--;
                // END MARK THE UN-ENTERABLE

                continue;
            }

            foreach ($enterableItems as $enterableItem)
            {
                self::$depth++;
                $searchResult = self::searchAndDisplay($enterableItem, $toItem);

                if (!$searchResult)
                {
                    continue;
                }
            }

            self::$depth--;
        }

        self::$depth--;

        // DISPLAY ALL ROUTES EXCEPT THE TRUE ONE
        // echo "\n";
        // foreach (self::$routeItems as $item) {
        //     echo " -> " . Item::find($item)->name;
        // }
        // echo "\n\n";

        array_pop(self::$routeItems);
    }

    public static function tab($count)
    {
        $tab = '';

        for ($i=0; $i < $count; $i++) {
            $tab = $tab . '  .';
        }

        return $tab;
    }
}
