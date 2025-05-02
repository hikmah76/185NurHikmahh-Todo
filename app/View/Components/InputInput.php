<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputInput extends Component
{
    public $id;
    public $name;
    public $type;
    public $value;
    public $required;
    public $autofocus;
    public $autocomplete;

    public function __construct($id, $name, $type, $value, $required, $autofocus, $autocomplete)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->required = $required;
        $this->autofocus = $autofocus;
        $this->autocomplete = $autocomplete;
    }

    public function render()
    {
        return view('components.input-input');
    }
}
