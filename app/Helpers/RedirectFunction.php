<?php

/**
 * This function is used to redirect the user to the previous page with the error messages and the input data
 * @param string $url
 * @param \Illuminate\Contracts\Validation\Validator $validator
 * @param string $webEndpoint
 * @return \Illuminate\Http\RedirectResponse
 */
function ValidatorRedirect($url, $validator, $webEndpoint)
{

    // return the error message and the input data
    return redirect($url . $webEndpoint)
        ->withErrors($validator)
        ->withInput();
}
