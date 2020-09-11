<?php

namespace Layout;

class Layout {

    private $layoutView;

    public function __construct(\View\Layout $layoutView) {
        $this->layoutView = $layoutView;
    }

    public function doLayout() {
        
    }

}