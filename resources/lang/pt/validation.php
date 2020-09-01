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

    'accepted' => 'O :attribute tem que ser aceite.',
    'active_url' => 'O campo :attribute deve conter uma URL válida.',
    'after' => 'O :attribute tem de ser uma data após :date.',
    'after_or_equal' => 'O campo :attribute deverá conter uma data posterior ou igual a :date.',
    'alpha' => 'O campo :attribute deve conter apenas letras.',
    'alpha_dash' => 'O campo :attribute deverá conter apenas letras, números e traços.',
    'alpha_num' => 'O campo :attribute deve conter apenas letras e números.',
    'array' => 'O campo :attribute deverá conter uma coleção de elementos.',
    'before' => 'O campo :attribute deverá conter uma data anterior a :date.',
    'before_or_equal' => 'O Campo :attribute deverá conter uma data anterior ou igual a :date.',
    'between' => [
        'numeric' => 'O campo :attribute deve conter um número entre :min e :max.',
        'file' => 'O campo :attribute deve estar compreendido entre :min e :max kilobytes.',
        'string' => 'O :attribute deverá ser entre :min e :max caractéres.',
        'array' => 'O campo :attribute deverá conter entre :min - :max elementos.',
    ],
    'boolean' => 'O campo :attribute deverá conter o valor verdadeiro ou falso.',
    'confirmed' => 'A confirmação do :attribute não coincide.',
    'date' => 'O campo :attribute não contém uma data válida.',
    'date_equals' => 'O :attribute deve ser uma data igual a :date.',
    'date_format' => 'O :attribute não corresponde ao formato :format.',
    'different' => 'Os campos :attribute e :other deverão conter valores diferentes.',
    'digits' => 'O :attribute deve ter :digits dígitos.',
    'digits_between' => 'O :attribute tem de ter entre :min e :max digitos.',
    'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute contém um valor duplicado.',
    'email' => 'O :attribute tem de ser um e-mail válido.',
    'ends_with' => 'O :attribute deve terminar com um dos seguintes: :values.',
    'exists' => 'O :attribute selecionado é inválido.',
    'file' => 'O campo :attribute deverá conter um ficheiro.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'numeric' => 'O :attribute deve ser maior do que :value.',
        'file' => 'O :attribute deve ser maior que :value kilobytes.',
        'string' => 'O :attribute deve ser maior que :value caracteres.',
        'array' => 'O :attribute deve ter mais de :value itens.',
    ],
    'gte' => [
        'numeric' => 'O :attribute deve ser maior ou igual a :value.',
        'file' => 'O :attribute deve ser maior ou igual a :value kilobytes.',
        'string' => 'O :attribute deve ser maior ou igual a :value caracteres.',
        'array' => 'O :attribute deve ter :value itens ou mais.',
    ],
    'image' => 'O :attribute tem de ser uma imagem.',
    'in' => 'O :attribute selecionado é inválido.',
    'in_array' => 'O campo :attribute nao existe em :other.',
    'integer' => 'O campo :attribute deve conter um número inteiro.',
    'ip' => 'O :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O campo :attribute deverá conter um IPv4 válido.',
    'ipv6' => 'O campo :attribute deverá conter um IPv6 válido.',
    'json' => 'O campo :attribute deve conter uma string JSON válida.',
    'lt' => [
        'numeric' => 'O :attribute tem de ser menor ou igual que :value.',
        'file' => 'O :attribute deve ter menos de :value kilobytes.',
        'string' => 'O :attribute deve ter menos de :value caracteres.',
        'array' => 'O campo :attribute deve ter menos de :value itens.',
    ],
    'lte' => [
        'numeric' => 'O :attribute tem de ser menor ou igual que :value.',
        'file' => 'O :attribute deve ser menor ou igual a :value kilobytes.',
        'string' => 'O :attribute deve ser menor ou igual a :value caracteres.',
        'array' => 'O :attribute não deve ter mais de :value items.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute não pode conter um valor superior a :max.',
        'file' => 'O :attribute não deve ser maior que :max kilobytes.',
        'string' => 'O :attribute nao pode ter mais que :max caracteres.',
        'array' => 'O :attribute não deverá ter mais que :max itens.',
    ],
    'mimes' => 'O :attribute só pode conter os seguintes formatos: :values.',
    'mimetypes' => 'O :attribute deve ser um ficheiro do tipo: :attribute.',
    'min' => [
        'numeric' => 'O campo :attribute deve conter um número superior ou igual a :min.',
        'file' => 'O campo :attribute deve conter um arquivo com no mínimo :min kilobytes.',
        'string' => 'O campo :attribute deve conter pelo menos :min itens.',
        'array' => 'O campo :attribute deve conter pelo menos :min itens.',
    ],
    'not_in' => 'O :attribute selecionado é inválido.',
    'not_regex' => 'O formato do valor informado no campo :attribute é inválido.',
    'numeric' => 'O campo :attribute deve conter um valor numérico.',
    'password' => 'A palavra-passe está incorreta.',
    'present' => 'O campo :attribute deve estar presente.',
    'regex' => 'O formato do :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'É obrigatória a indicação de um valor para o campo :attribute quando o valor do campo :other é igual a :value.',
    'required_unless' => 'O campo :attribute e obrigatorio, a menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando o :value se encontra definido.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo :attribute é necessário quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values está presente.',
    'same' => 'Os campos :attribute e :other deverão conter valores iguais.',
    'size' => [
        'numeric' => 'O :attribute deve ser maior que :size.',
        'file' => 'O campo :attribute deve conter um arquivo com o tamanho de :size kilobytes.',
        'string' => 'O campo :attribute deverá conter :size caracteres.',
        'array' => 'O :attribute tem de conter :size itens.',
    ],
    'starts_with' => 'O :attribute deve começar com um dos seguintes: :values.',
    'string' => 'O campo :attribute deverá conter texto.',
    'timezone' => 'O campo :attribute deve conter um fuso horário válido.',
    'unique' => 'O valor indicado para o campo :attribute já se encontra registado.',
    'uploaded' => 'O :attribute falhou ao ser enviado.',
    'url' => 'O formato do valor informado no campo :attribute é inválido.',
    'uuid' => 'O campo :attribute deve conter um UUID válido.',

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
            'rule-name' => 'mensagem-personalizada',
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
