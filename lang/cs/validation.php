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

    'accepted' => 'Pole :attribute musí být přijato.',
    'accepted_if' => 'Pole :attribute musí být přijato, když :other je :value.',
    'active_url' => 'Pole :attribute musí být platná adresa URL.',
    'after' => 'Pole :attribute musí být datum po :date.',
    'after_or_equal' => 'Pole :attribute musí být datum po nebo rovné :date.',
    'alpha' => 'Pole :attribute musí obsahovat pouze písmena.',
    'alpha_dash' => 'Pole :attribute musí obsahovat pouze písmena, čísla, pomlčky a podtržítka.',
    'alpha_num' => 'Pole :attribute musí obsahovat pouze písmena a čísla.',
    'array' => 'Pole :attribute musí být pole.',
    'ascii' => 'Pole :attribute musí obsahovat pouze jednobajtové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí být datum před :date.',
    'before_or_equal' => 'Pole :attribute musí být datum před nebo rovné :date.',
    'between' => [
        'array' => 'Pole :attribute musí mít položky mezi :min a :max.',
        'file' => 'Pole :attribute musí být mezi :min a :max kilobajty.',
        'numeric' => 'Pole :attribute musí být mezi :min a :max.',
        'string' => 'Pole :attribute musí být mezi znaky :min a :max.',
    ],
    'boolean' => 'Pole :attribute musí být pravda nebo nepravda.',
    'can' => 'Pole :attribute obsahuje neautorizovanou hodnotu.',
    'confirmed' => 'Potvrzení pole :attribute se neshoduje.',
    'current_password' => 'Heslo je nesprávné.',
    'date' => 'Pole :attribute musí být platné datum.',
    'date_equals' => 'Pole :attribute musí být datum rovné :date.',
    'date_format' => 'Pole :attribute musí odpovídat formátu :format.',
    'decimal' => 'Pole :attribute musí mít :decimal desetinných míst.',
    'declined' => 'Pole :attribute musí být odmítnuto.',
    'declined_if' => 'Pole :attribute musí být odmítnuto, když :other je :value.',
    'different' => 'Pole :attribute a :other se musí lišit.',
    'digits' => 'Pole :attribute musí být :digits čísel.',
    'digits_between' => 'Pole :attribute musí být mezi :min a :max číslicemi.',
    'dimensions' => 'Pole :attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole :attribute má duplicitní hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmí končit jedním z následujících: :values.',
    'doesnt_start_with' => 'Pole :attribute nesmí začínat jedním z následujících: :values.',
    'email' => 'Pole :attribute musí být platná e-mailová adresa.',
    'ends_with' => 'Pole :attribute musí končit jedním z následujících: :values.',
    'enum' => 'Vybraný atribut :attribute je neplatný.',
    'exists' => 'Vybraný atribut :attribute je neplatný.',
    'extensions' => 'Pole :attribute musí mít jedno z následujících rozšíření: :values.',
    'file' => 'Pole :attribute musí být soubor.',
    'filled' => 'Pole :attribute musí mít hodnotu.',
    'gt' => [
        'array' => 'Pole :attribute musí mít více než :value položek.',
        'file' => 'Pole :attribute musí být větší než :value kilobytes.',
        'numeric' => 'Pole :attribute musí být větší než :value.',
        'string' => 'Pole :attribute musí být větší než :value znaků.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí obsahovat :value položek nebo více.',
        'file' => 'Pole :attribute musí být větší nebo rovno :value kilobytes.',
        'numeric' => 'Pole :attribute musí být větší nebo rovno :value.',
        'string' => 'Pole :attribute musí být větší nebo rovno :value znakům.',
    ],
    'hex_color' => 'Pole :attribute musí mít platnou hexadecimální barvu.',
    'image' => 'Pole :attribute musí být obrázek.',
    'in' => 'Vybraný atribut :attribute je neplatný.',
    'in_array' => 'Pole :attribute musí existovat v :other.',
    'integer' => 'Pole :attribute musí být celé číslo.',
    'ip' => 'Pole :attribute musí být platná IP adresa.',
    'ipv4' => 'Pole :attribute musí být platná adresa IPv4.',
    'ipv6' => 'Pole :attribute musí být platná adresa IPv6.',
    'json' => 'Pole :attribute musí být platný řetězec JSON.',
    'lowercase' => 'Pole :attribute musí být malými písmeny.',
    'lt' => [
        'array' => 'Pole :attribute musí mít méně než :value položek.',
        'file' => 'Pole :attribute musí být menší než :value kilobytes.',
        'numeric' => 'Pole :attribute musí být menší než :value.',
        'string' => 'Pole :attribute musí být menší než :value znaků.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nesmí obsahovat více než :value položek.',
        'file' => 'Pole :attribute musí být menší nebo rovno :value kilobytes.',
        'numeric' => 'Pole :attribute musí být menší nebo rovno :value.',
        'string' => 'Pole :attribute musí být menší nebo rovno :value znaků.',
    ],
    'mac_address' => 'Pole :attribute musí být platná adresa MAC.',
    'max' => [
        'array' => 'Pole :attribute nesmí obsahovat více než :max položek.',
        'file' => 'Pole :attribute nesmí být větší než :max kilobajtů.',
        'numeric' => 'Pole :attribute nesmí být větší než :max.',
        'string' => 'Pole :attribute nesmí být větší než :max znaků.',
    ],
    'max_digits' => 'Pole :attribute nesmí mít více než :max číslic.',
    'mimes' => 'Pole :attribute musí být soubor typu: :values.',
    'mimetypes' => 'Pole :attribute musí být soubor typu: :values.',
    'min' => [
        'array' => 'Pole :attribute musí mít alespoň :min položek.',
        'file' => 'Pole :attribute musí mít alespoň :min kilobajtů.',
        'numeric' => 'Pole :attribute musí být alespoň :min.',
        'string' => 'Pole :attribute musí obsahovat alespoň :min znaků.',
    ],
    'min_digits' => 'Pole :attribute musí mít alespoň :min číslic.',
    'missing' => 'Musí chybět pole :attribute.',
    'missing_if' => 'Pole :attribute musí chybět, když :other je :value.',
    'missing_unless' => 'Pole :attribute musí chybět, pokud :other není :value.',
    'missing_with' => 'Pokud je přítomné :values, pole :attribute musí chybět.',
    'missing_with_all' => 'Pokud jsou přítomny :values, pole :attribute musí chybět.',
    'multiple_of' => 'Pole :attribute musí být násobkem :value.',
    'not_in' => 'Vybraný atribut :attribute je neplatný.',
    'not_regex' => 'Formát pole :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí být číslo.',
    'password' => [
        'letters' => 'Pole :attribute musí obsahovat alespoň jedno písmeno.',
        'mixed' => 'Pole :attribute musí obsahovat alespoň jedno velké a jedno malé písmeno.',
        'numbers' => 'Pole :attribute musí obsahovat alespoň jedno číslo.',
        'symbols' => 'Pole :attribute musí obsahovat alespoň jeden symbol.',
        'uncompromised' => 'Daný atribut :attribute se objevil při úniku dat. Vyberte prosím jiný :attribute.',
    ],
    'present' => 'Musí být přítomno pole :attribute.',
    'present_if' => 'Pole :attribute musí být přítomno, když :other je :value.',
    'present_unless' => 'Pole :attribute musí být přítomno, pokud :other není :value.',
    'present_with' => 'Pole :attribute musí být přítomno, když je přítomen :values.',
    'present_with_all' => 'Pole :attribute musí být přítomno, když jsou přítomny :values.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => 'Pole :attribute je zakázáno, když :other je :value.',
    'prohibited_unless' => 'Pole :attribute je zakázáno, pokud :other není v :values.',
    'prohibits' => 'Pole :attribute zakazuje přítomnost :other.',
    'regex' => 'Formát pole :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovat položky pro: :values.',
    'required_if' => 'Pole :attribute je povinné, když :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, když je akceptováno :other.',
    'required_unless' => 'Pole :attribute je povinné, pokud :other není v :values.',
    'required_with' => 'Pole :attribute je povinné, když je přítomen :values.',
    'required_with_all' => 'Pole :attribute je povinné, když jsou přítomny :values.',
    'required_without' => 'Pole :attribute je povinné, když :values nejsou přítomné.',
    'required_without_all' => 'Pole :attribute je povinné, pokud není přítomna žádná z hodnot :values.',
    'same' => 'Pole :attribute musí odpovídat :other.',
    'size' => [
        'array' => 'Pole :attribute musí obsahovat :size položek.',
        'file' => 'Pole :attribute musí mít velikost :size kilobajtů.',
        'numeric' => 'Pole :attribute musí mít velikost :size.',
        'string' => 'Pole :attribute musí mít :size znaků.',
    ],
    'starts_with' => 'Pole :attribute musí začínat jedním z následujících: :values.',
    'string' => 'Pole :attribute musí být řetězec.',
    'timezone' => 'Pole :attribute musí být platné časové pásmo.',
    'unique' => 'Atribut :attribute již byl obsazen.',
    'uploaded' => 'Nahrání atributu :attribute se nezdařilo.',
    'uppercase' => 'Pole :attribute musí být velkými písmeny.',
    'url' => 'Pole :attribute musí být platná adresa URL.',
    'ulid' => 'Pole :attribute musí být platným ULID.',
    'uuid' => 'Pole :attribute musí být platné UUID.',

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

    'attributes' => [],

];
