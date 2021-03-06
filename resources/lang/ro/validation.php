<?php

return [

    'accepted'              => ':attribute trebuie acceptat.',
    'active_url'            => ':attribute nu este un URL valid.',
    'after'                 => ':attribute trebuie să fie o dată începând din :date.',
    'alpha'                 => ':attribute trebuie să conțină doar litere.',
    'alpha_dash'            => ':attribute trebuie să conțină doar litere, numere și liniuțe.',
    'alpha_num'             => ':attribute trebuie să conțină doar litere și numere.',
    'array'                 => ':attribute trebuie să fie o mulțime.',
    'before'                => ':attribute trebuie să fie o dată până in :date.',
    'between'               => [
        'numeric'   => ':attribute trebuie să fie între :min și :max.',
        'file'      => ':attribute trebuie să fie între :min și :max KB.',
        'string'    => ':attribute trebuie să conțină între :min și :max catactere.',
        'array'     => ':attribute trebuie să conțină între :min și :max elemente.',
    ],
    'boolean'               => 'Câmpul :attribute trebuie să fie adevarat sau fals.',
    'confirmed'             => 'Confirmarea :attribute nu se potrivește.',
    'date'                  => ':attribute nu este o dată validă.',
    'date_format'           => ':attribute nu se potrivește cu formatul :format.',
    'different'             => ':attribute și :other trebuie să fie diferite.',
    'digits'                => ':attribute trebuie să conțină :digits cifre.',
    'digits_between'        => ':attribute trebuie să conțină între :min și :max cifre.',
    'email'                 => ':attribute trebuie să fie o adresă de email corectă.',
    'filled'                => 'Câmpul :attribute este obligatoriu.',
    'exists'                => ':attribute este invalid.',
    'image'                 => ':attribute trebuie să fie o imagine.',
    'in'                    => 'Câmpul :attribute este invalid.',
    'integer'               => ':attribute trebuie să fie un număr întreg.',
    'ip'                    => ':attribute trebuie să fie o adresă IP validă.',
    'max'                   => [
        'numeric'   => ':attribute nu poate fi mai mare de :max.',
        'file'      => ':attribute nu poate fi mai mare de :max KB.',
        'string'    => ':attribute nu poate avea mai mult de :max caractere.',
        'array'     => ':attribute nu poate avea mai mult de :max elemente.',
    ],
    'mimes'                 => ':attribute trebuie să fie un fișier de tipul: :values.',
    'min'                   => [
        'numeric'   => ':attribute nu poate fi mai mic de :min.',
        'file'      => ':attribute nu poate fi mai mic de :min KB.',
        'string'    => ':attribute nu poate avea mai puțin de :min caractere.',
        'array'     => ':attribute nu poate avea mai puțin de :min elemente.',
    ],
    'not_in'                => ':attribute este invalid.',
    'numeric'               => ':attribute trebuie să fie un număr.',
    'regex'                 => ':attribute are un format invalid.',
    'required'              => 'Câmpul :attribute este obligatoriu.',
    'required_if'           => 'Câmpul :attribute este obligatoriu când :other este :value.',
    'required_with'         => 'Câmpul :attribute este obligatoriu când :values este prezent.',
    'required_with_all'     => 'Câmpul :attribute este obligatoriu când :values este prezent.',
    'required_without'      => 'Câmpul :attribute este obligatoriu când :values nu este prezent.',
    'required_without_all'  => 'Câmpul :attribute este obligatoriu când nici una din :values nu este prezentă.',
    'same'                  => ':attribute și trebuie să fie la fel.',
    'size'                  => [
        'numeric'   => ':attribute trebuie să fie de :size.',
        'file'      => ':attribute trebuie să fie de :size KB.',
        'string'    => ':attribute trebuie să aibe :size caractere.',
        'array'     => ':attribute trebuie să conțină :size elemente.',
    ],
    'string'                => ':attribute trebuie să fie un șir.',
    'timezone'              => ':attribute trebuie să fie o zonă validă.',
    'unique'                => ':attribute este deja folosit.',
    'url'                   => ':attribute are un format invalid.',

    'attributes' => [
        'bill_product_id' => 'id-ul produsului din factură',
        'new_user_email' => 'email-ul utilizatorului',
        'new_user_password' => 'parola utilizatorului',
        'new_user_password_confirmation' => 'confirmarea parolei utilizatorului',
        'password' => 'parolă',
        'product_id' => 'ID-ul produsului',
        'product_code' => 'codul produsului',
        'product_discount' => 'discount-ul produsului',
        'product_name' => 'numele produsului',
        'product_page' => 'pagina produsului',
        'product_price' => 'prețul produsului',
        'product_quantity' => 'cantitatea produsului',
        'promo_code' => 'Codul promoțional',
        'user_password' => 'parola dumneavoastră',
    ],

    'custom' => [
        'email' => [
            'unique' => 'Această adresă de email este deja folosită.'
        ],
        'first_name' => [
            'required' => 'Numele tău este obligatoriu.'
        ],
        'last_name' => [
            'required' => 'Prenumele tău este obligatoriu.'
        ],
        'password' => [
            'required' => 'Introduceți o parola de cel puțin 6 caractere.'
        ],
        'password_confirmation' => [
            'required' => 'Parolele nu corespund.'
        ],
    ]
];