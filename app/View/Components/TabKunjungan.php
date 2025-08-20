<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabKunjungan extends Component
{
    public $kunjungans;
    public $pasien;

    /**
     * Create a new component instance.
     */
    public function __construct($kunjungans = [], $pasien = [])
    {
        $this->kunjungans = $kunjungans;
        $this->pasien = $pasien;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab-kunjungan');
    }
}
