<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUpdateUser extends Component
{
    public $name;
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.create-update-user');
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->reset();
        $this->emit('userStore');
    }
}
