<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UnsubscribeButton extends Component
{
    public $email;
    public $loading = false;

    public function mount($email)
    {
        $this->email = $email;
    }

    public function unsubscribe()
    {
        $this->loading = true;

        // Simulate an action (e.g., calling an API or service)
        sleep(2); // Simulate a delay

        // Optionally, redirect or notify the user
        return redirect()->route('unsubscribe', ['email' => $this->email]);
    }

    public function render()
    {
        return view('livewire.unsubscribe-button');
    }
}
