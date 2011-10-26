<?php

class WebTricks_Core_Setup
{
    const DEFAULT_SETUP_CLASS = 'WebTricks_Core_Module_Setup';
    
    /**
     * Apply database updates whenever needed
     *
     * @return  boolean
     */
    static public function applyAllUpdates()
    {
        Cream::getApplication()->setUpdateMode(true);

        $resources = Cream::getApplication()->getConfig()->getNode('global/resources')->children();
        
        foreach ($resources as $resName => $resource) {
            if (!$resource->setup) {
                continue;
            }
            $className = self::DEFAULT_SETUP_CLASS;
            if (isset($resource->setup->class)) {
                $className = $resource->setup->getClassName();
            }
            $setupClass = Cream::instance($className, $resName);
            $setupClass->applyUpdates();
        }

        Cream::getApplication()->setUpdateMode(false);
        return true;
    }
}