<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabTindakan extends Component
{
    public $tindakanKunjungans;
    public $kunjungans;
    public $tindakans;

    public function __construct($tindakanKunjungans, $kunjungans, $tindakans)
    {
        $this->tindakanKunjungans = $tindakanKunjungans;
        $this->kunjungans = $kunjungans;
        $this->tindakans = $tindakans;
    }

    public function render()
    {
        return view('components.tab-tindakan');
    }
}