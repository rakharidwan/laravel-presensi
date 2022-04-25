<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class AbsentForm extends Component
{   

    use WithFileUploads;
    public $photo;
    public $nik;
    public $test;

    public $totalSteps = 2;
    public $currentSteps = 1;
    public $statusAbsent = 0;
    public $admissionTime;
    public $name;


    public function mount(){
        $this->currentSteps = 1;
    }

    public function render()
    {
        return view('livewire.absent-form');
    }

    public function nextForm(){
        $this->resetErrorBag();
        $this->validateData();
        $this->currentSteps++;
            if ($this->currentSteps > $this->totalSteps) {
                $this->currentSteps = $this->totalSteps;
            }
    }

    public function prevForm(){
        $this->currentSteps--;
            if ($this->currentSteps > $this->totalSteps) {
                $this->currentSteps = 1;
            }
    }

    public function validateData(){
        if ($this->currentSteps == 1) {
            $this->validate([
                'nik' => 'required'
            ]);
        }
    }

    public function absent(){

        // $this->reset();
        // $this->currentSteps = 1;
        dd($this->photo);

    }
}
