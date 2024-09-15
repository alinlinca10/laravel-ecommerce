<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\User;
use Hash;
use Auth;

class Navigation extends Component
{
    public $users, $email, $password, $reset_password, $name;
    public $registerForm = false;

    public function login()
    {
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            flash('You are login successful.')->success();
            $this->dispatch('closeLoginModal');
        }else{
            flash('Email and password are wrong.')->error();
        }

    }

    public function logout()
    {
        if(Auth::check()){
            Auth::logout();
            flash('You are logout with success.')->success();
            return redirect()->to('/');
        }
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->reset_password = '';
    }
    
    public function register()
    {
        $this->registerForm = !$this->registerForm;
    }

    public function registerStore()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $this->password = Hash::make($this->password); 

        User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password]);
        $this->dispatch('closeLoginModal');

        flash('Your register successfully.')->success();

        $this->resetInputFields();

    }
    
    public function render()
    {
        return view('livewire.frontend.navigation');
    }
}
