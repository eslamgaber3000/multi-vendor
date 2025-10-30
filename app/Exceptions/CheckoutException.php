<?php

namespace App\Exceptions;

use Exception;

class CheckoutException extends Exception
{
    public function render()
    {
        return redirect()->route('front.home')
        ->withErrors($this->getMessage())
        ->with('info', $this->getMessage());
    }
}
