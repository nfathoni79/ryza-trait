<?php

namespace App;

use App\Item;
use App\Material;
use App\TransferRoute;

class Finder
{
    //
    private $depth = 0;
    private $foundItemIds = [];
    private $foundMaterialIds = [];
    private $foundItemDepths = [];
    private $foundMaterialDepths = [];
    private $singleRouteItemIds = [];
    private $singleRouteMaterialIds = [];

    public $transferRoutes = [];

    public function findRoutes(Item $startItem, Item $finishItem)
    {
        $this->find($startItem, $finishItem);
    }

    private function find(Item $startItem, Item $finishItem, $display = false)
    {
        if ($display)
        {
            // DISPLAY THE ITEM
            echo $this->tab($this->$depth) . $startItem->name . "\n";
            // END DISPLAY THE ITEM
        }

        if ($startItem->id == $finishItem->id)
        {
            if ($display)
            {
                // MARK THE FINAL ITEM
                $this->depth++;
                echo $this->tab($this->depth) . "VV\n";
                $this->depth--;
                // END MARK THE FINAL ITEM
            }

            $this->depth--;

            array_push($this->singleRouteItemIds, $startItem->id);

            // ADD TO ITEM AND MATERIAL ROUTES
            $items = [];
            $materials = [];

            foreach ($this->singleRouteItemIds as $itemId) {
                array_push($items, Item::find($itemId));
            }

            if ($display)
            {
                // DISPLAY THE TRUE ROUTE
                for ($i=0; $i < count($this->singleRouteMaterialIds); $i++) {
                    echo Item::find($this->singleRouteItemIds[$i])->name . " -> *" . Material::find($this->singleRouteMaterialIds[$i])->materialable->name . " -> ";
                }

                echo Item::find($this->singleRouteItemIds[count($this->singleRouteItemIds) - 1])->name . "\n";
                // END DISPLAY THE TRUE ROUTE
            }

            array_pop($this->singleRouteItemIds);

            foreach ($this->singleRouteMaterialIds as $materialId) {
                array_push($materials, Material::find($materialId));
            }

            $transferRoute = new TransferRoute();
            $transferRoute->itemSequence = $items;
            $transferRoute->materialSequence = $materials;
            array_push($this->transferRoutes, $transferRoute);
            // END ADD TO ITEM AND ROUTES

            return true;
        }

        if (in_array($startItem->id, $this->foundItemIds))
        {
            $foundIndex = array_search($startItem->id, $this->foundItemIds);

            if ($this->depth >= $this->foundItemDepths[$foundIndex])
            {
                if ($display)
                {
                    // MARK THE ITEM EXIST IN FOUNDS
                    $this->depth++;
                    echo $this->tab($this->depth) . "L\n";
                    $this->depth--;
                    // END MARK THE ITEM EXIST IN FOUNDS
                }

                $this->depth--;

                return false;
            }
            else
            {
                unset($this->foundItemIds[$foundIndex]);
                unset($this->foundItemDepths[$foundIndex]);

                array_push($this->foundItemIds, $startItem->id);
                array_push($this->foundItemDepths, $this->depth);
                array_push($this->singleRouteItemIds, $startItem->id);
            }
        }
        else
        {
            array_push($this->foundItemIds, $startItem->id);
            array_push($this->foundItemDepths, $this->depth);
            array_push($this->singleRouteItemIds, $startItem->id);
        }

        $materialableItems = [$startItem->material];
        $materialableCategories = [];

        foreach ($startItem->categories as $category) {
            array_push($materialableCategories, $category->material);
        }

        $materialSlots = array_merge($materialableItems, $materialableCategories);
        $materialSlots = collect($materialSlots);

        foreach ($materialSlots as $slot)
        {
            $this->depth++;

            if ($display)
            {
                // DISPLAY THE MATERIAL SLOTS
                echo $this->tab($this->depth) . '*' . $slot->materialable->name . "\n";
                // END DISPLAY THE MATERIAL SLOTS
            }

            if (in_array($slot->id, $this->foundMaterialIds))
            {
                $foundIndex = array_search($slot->id, $this->foundMaterialIds);

                if ($this->depth >= $this->foundMaterialDepths[$foundIndex])
                {
                    if ($display)
                    {
                        // MARK THE MATERIAL EXIST IN FOUNDSS
                        $this->depth++;
                        echo $this->tab($this->depth) . "L\n";
                        $this->depth--;
                        // END MARK THE MATERIAL EXIST IN FOUNDS
                    }

                    $this->depth--;

                    continue;
                }
                else
                {
                    unset($this->foundMaterialIds[$foundIndex]);
                    unset($this->foundMaterialDepths[$foundIndex]);

                    array_push($this->foundMaterialIds, $slot->id);
                    array_push($this->foundMaterialDepths, $this->depth);
                    array_push($this->singleRouteMaterialIds, $slot->id);
                }
            }
            else
            {
                array_push($this->foundMaterialIds, $slot->id);
                array_push($this->foundMaterialDepths, $this->depth);
                array_push($this->singleRouteMaterialIds, $slot->id);
            }

            $enterableItems = $slot->items;

            if ($enterableItems->count() < 1)
            {
                if ($display)
                {
                    // MARK THE UN-ENTERABLE
                    $this->depth++;
                    echo $this->tab($this->depth) . "X\n";
                    $this->depth--;
                    // END MARK THE UN-ENTERABLE
                }

                $this->depth--;

                array_pop($this->singleRouteMaterialIds);

                continue;
            }

            foreach ($enterableItems as $enterableItem)
            {
                $this->depth++;
                $findResult = $this->find($enterableItem, $finishItem);

                if (!$findResult)
                {
                    continue;
                }
            }

            $this->depth--;

            array_pop($this->singleRouteMaterialIds);
        }

        $this->depth--;

        // DISPLAY ALL ROUTES EXCEPT THE TRUE ONE
        // echo "\n";
        // foreach ($this->singleRouteItemIds as $item) {
        //     echo " -> " . Item::find($item)->name;
        // }
        // echo "\n\n";

        array_pop($this->singleRouteItemIds);
    }

    private function tab($count)
    {
        $tab = '';

        for ($i=0; $i < $count; $i++) {
            $tab = $tab . '  .';
        }

        return $tab;
    }
}
