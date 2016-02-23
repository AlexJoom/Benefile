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

    'accepted'             => 'Το :attribute πρέπει να είναι αποδεκτό.',
    'active_url'           => 'Το :attribute δεν είναι έγκυρο URL.',
    'after'                => 'Το :attribute πρέπει να είναι ημερομηνία αργότερα από :date.',
    'alpha'                => 'Το :attribute πρέπει να περιέχει μόνο γράμματα.',
    'alpha_dash'           => 'Το :attribute μπορεί να περιέχει μόνο γράμματα, αριθμούς, και παύλες.',
    'alpha_num'            => 'Το :attribute μπορεί να περιέχει γράμματα και αριθμούς.',
    'array'                => 'Το :attribute πρέπει να είναι πίνακας.',
    'before'               => 'Το :attribute πρέπει να είναι μια ημερομηνία νωρίτερη από :date.',
    'between'              => [
        'numeric' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max.',
        'file'    => 'Το :attribute πρέπει να είναι μεταξύ :min και :max kilobytes.',
        'string'  => 'Το :attribute πρέπει να είναι μεταξύ :min και :max χαρακτήρες.',
        'array'   => 'Το :attribute πρέπει να είναι μεταξύ :min και :max αντικειμένων.',
    ],
    'boolean'              => 'Το :attribute πεδίο πρέπει να είναι είτε αληθές, είτε ψευδές.',
    'confirmed'            => 'Η επιβεβαίωση του :attribute δεν ταιριάζει.',
    'date'                 => 'Το :attribute δεν είναι έγκυρη ημερομηνία.',
    'date_format'          => 'Το :attribute δεν ταιριάζει με τη μορφή :format.',
    'different'            => 'Το :attribute και το :other πρέπει να είναι διαφορετικά.',
    'digits'               => 'Το :attribute πρέπει να είναι :digits ψηφία.',
    'digits_between'       => 'Το :attribute πρέπει να είναι μεταξύ :min και :max ψηφία.',
    'email'                => 'Το :attribute πρέπει να είναι μια έγκυρη διεύθυνση email.',
    'exists'               => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'filled'               => 'Το :attribute είναι υποχρεωτικό.',
    'image'                => 'Το :attribute πρέπει να είναι εικόνα.',
    'in'                   => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'integer'              => 'Το :attribute πρέπει να είναι ακέραιος.',
    'ip'                   => 'Το :attribute πρέπει να είναι έγκυρη διεύθυνση IP.',
    'json'                 => 'Το :attribute πρέπει να είναι έγκυρο JSON string.',
    'max'                  => [
        'numeric' => 'Το :attribute πρέπει να είναι μέχρι το :max.',
        'file'    => 'Το :attribute πρέπει να είναι μέχρι :max kilobytes.',
        'string'  => 'Το :attribute πρέπει να είναι μέχρι :max χαρακτήρες.',
        'array'   => 'Το :attribute πρέπει να έχει μέχρι :max αντικείμενα.',
    ],
    'mimes'                => 'Το :attribute πρέπει να είναι αρχείο τύπου: :values.',
    'min'                  => [
        'numeric' => 'Το :attribute πρέπει να είναι τουλάχιστον :min.',
        'file'    => 'Το :attribute πρέπει να είναι τουλάχιστον :min kilobytes.',
        'string'  => 'Το :attribute πρέπει να είναι τουλάχιστον :min χαρακτήρες.',
        'array'   => 'Το :attribute πρέπει να έχει τουλάχιστον :min αντικείμενα.',
    ],
    'not_in'               => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'numeric'              => 'Το :attribute πρέπει να είναι αριθμός.',
    'regex'                => 'Η μορφή του :attribute δεν είναι έγκυρη.',
    'required'             => 'Το :attribute πεδίο είναι υποχρεωτικό.',
    'required_if'          => 'Το :attribute πεδίο είναι υποχρεωτικό όταν το :other είναι :value.',
    'required_with'        => 'Το :attribute πεδίο είναι υποχρεωτικό όταν το :values είναι παρόν.',
    'required_with_all'    => 'Το :attribute πεδίο είναι υποχρεωτικό όταν τα :values είναι παρόντα.',
    'required_without'     => 'Το :attribute πεδίο είναι υποχρεωτικό όταν το :values δεν είναι παρόν.',
    'required_without_all' => 'Το :attribute πεδίο είναι υποχρεωτικό όταν κανένα από τα :values δεν είναι παρόντα.',
    'same'                 => 'Το :attribute και το :other πρέπει να ταιριάζουν.',
    'size'                 => [
        'numeric' => 'Το :attribute πρέπει να είναι :size.',
        'file'    => 'Το :attribute πρέπει να είναι :size kilobytes.',
        'string'  => 'Το :attribute πρέπει να είναι :size χαρακτήρες.',
        'array'   => 'Το :attribute πρέπει να περιέχει :size αντικείμενα.',
    ],
    'string'               => 'Το :attribute πρέπει να είναι συμβολοσειρά.',
    'timezone'             => 'Το :attribute πρέπει να είναι έγκυρη χρονική ζώνη.',
    'unique'               => 'Το :attribute έχει ήδη χρησιμοποιηθεί.',
    'url'                  => 'Η μορφή του :attribute δεν είναι έγκυρη.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
