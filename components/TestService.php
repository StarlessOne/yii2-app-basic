<?php

namespace app\components;

use yii\base\Component;

class TestService extends Component {
    public $someProp = "I'm a test prop";

    public function showProp() {
        return $this->someProp;
    }
}