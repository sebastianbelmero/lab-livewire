<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ListUser extends Component
{
    public $name;
    public $email;
    public $password;
    public $userId;

    public $edit = false;

    // protected $listeners = ['userStore' => 'render'];

    public function render()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('livewire.list-user', compact('users'));
    }

    public function create()
    {
        if ($this->edit) {
            $this->update();
            return;
        }
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
        $this->render();

    }

    public function destroy($id)
    {
        if ($id) {
            $record = User::find($id);
            $record->delete();
        }

        $this->render();
    }

    public function edit($id)
    {
        $this->edit = true;
        $this->userId = $id;
        $record = User::find($id);
        $this->name = $record->name;
        $this->email = $record->email;
        $this->password = $record->password;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $record = User::find($this->userId);
        $record->name = $this->name;
        $record->email = $this->email;
        $record->password = Hash::make($this->password);
        $record->save();

        $this->reset();
        $this->edit = false;
        $this->render();
    }
}
