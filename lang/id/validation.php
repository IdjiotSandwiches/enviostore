<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute harus disetujui.',
    'unique' => ':attribute telah diambil.',
    'confirmed' => 'Konfirmasi :attribute tidak sesuai.',
    'current_password' => 'Kata sandi salah.',
    'email' => ':attribute harus menggunakan alamat email yang valid.',
    'integer' => ':attribute harus angka.',
    'min' => [
        'array' => ':attribute harus setidaknya :min items.',
        'file' => ':attribute harus setidaknya :min kilobytes.',
        'numeric' => ':attribute harus setidaknya :min.',
        'string' => ':attribute harus setidaknya :min karakter.',
    ],
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute diperlukan.',
    'string' => ':attribute harus kalimat.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'password' => 'Kata Sandi',
        'phone_number' => 'Nomor Telepon',
        'password_confirmation' => 'Konfirmasi Kata Sandi',
        'old_password' => 'Kata Sandi Lama',
    ],

];
