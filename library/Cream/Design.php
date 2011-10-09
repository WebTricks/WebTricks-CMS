<?php

class Cream_Design extends Cream_Object
{
    public function validate()
    {
        $this->getResource()->validate($this);
        return $this;
    }

    public function loadChange($storeId, $date = null)
    {
        $result = $this->getResource()
            ->loadChange($storeId, $date);

        if (count($result)){
            if (!empty($result['design'])) {
                $tmp = explode('/', $result['design']);
                $result['package'] = $tmp[0];
                $result['theme'] = $tmp[1];
            }

            $this->_setData($result);
        }

        return $this;
    }
}