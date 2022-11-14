<?php
$seed = 's-' . mt_rand();
$controlParams = [
    'type' => 'select',
    'options' => $fieldData['options'],
    'empty' => $fieldData['empty'] ?? false,
    'value' => $fieldData['value'] ?? null,
    'multiple' => $fieldData['multiple'] ?? false,
    'disabled' => $fieldData['disabled'] ?? false,
    'class' => ($fieldData['class'] ?? '') . ' formDropdown form-select',
    'default' => $fieldData['default'] ?? '',
];
if (!empty($fieldData['field'])) { // used for multi meta-field form
    $controlParams['field'] = $fieldData['field'];
}
if (!empty($fieldData['label'])) {
    $controlParams['label'] = $fieldData['label'];
}
if ($controlParams['options'] instanceof \Cake\ORM\Query) {
    $controlParams['options'] = $controlParams['options']->all()->toList();
}
if (in_array('_custom', array_keys($controlParams['options']))) {
    $customInputValue = $this->Form->getSourceValue($fieldData['field']);
    if (!in_array($customInputValue, $controlParams['options'])) {
        $controlParams['options'] = array_map(function ($option) {
            if (is_array($option) && $option['value'] == '_custom') {
                $option[] = 'selected';
            }
            return $option;
        }, $controlParams['options']);
    } else {
        $customInputValue = '';
    }
    $customControlParams = [
        'value' => $fieldData['value'] ?? null,
        'class' => 'd-none',
    ];
    $controlParams['class'] .= ' dropdown-custom-value' . "-$seed";
    $adaptedField = $fieldData['field'] . '_custom';
    $controlParams['templates']['formGroup'] = sprintf(
        '<label class="col-sm-2 col-form-label form-label" {{attrs}}>{{label}}</label><div class="col-sm-10 multi-metafield-input-container"><div class="d-flex form-dropdown-with-freetext input-group">{{input}}{{error}}%s</div></div>',
        sprintf('<input type="text" class="form-control custom-value" field="%s" value="%s">', h($adaptedField), h($customInputValue))
    );
}
echo $this->FormFieldMassage->prepareFormElement($this->Form, $controlParams, $fieldData);
?>

<script>
    (function() {
        $(document).ready(function() {
            const $select = $('select.dropdown-custom-value-<?= $seed ?>')
            toggleFreetextSelectField($select[0]);
            $select.attr('onclick', 'toggleFreetextSelectField(this)')
            $select.parent().find('input.custom-value').attr('oninput', 'updateAssociatedSelect(this)')
            // updateAssociatedSelect($select.parent().find('input.custom-value')[0])

            // Multiple saves in dropdown doesn't work
            // But multiple saves for custom works but save the first element as `_custom`
        })

    })()

    function toggleFreetextSelectField(selectEl) {
        const $select = $(selectEl)
        const show = $select.val() == '_custom'
        const $container = $(selectEl).parent()
        let $freetextInput = $container.find('input.custom-value')
        if (show) {
            $freetextInput.removeClass('d-none')
        } else {
            $freetextInput.addClass('d-none')
        }
    }

    function updateAssociatedSelect(input) {
        const $input = $(input)
        const $select = $input.parent().find('select')
        const $customOption = $select.find('option.custom-value')
        $customOption.val($input.val())
    }
</script>

<style>
    form div.form-dropdown-with-freetext input.custom-value {
        flex-grow: 3;
    }
</style>