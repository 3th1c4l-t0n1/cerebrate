<?php
$create_new_allowed = true;
$update_allowed = true;
$delete_all_allowed = false;
$totalAllowed = $create_new_allowed + $update_allowed + $delete_all_allowed;
$maxWidth = 99 - ($create_new_allowed ? 33 : 0) - ($update_allowed ? 33 : 0) - ($delete_all_allowed ? 33 : 0);
$defaultStrategy = 'update_existing';

$form = $this->element('genericElements/Form/genericForm', [
    'entity' => null,
    'ajax' => false,
    'raw' => true,
    'data' => [
        'model' => 'MetaTemplate',
        'fields' => [
            [
                'field' => 'update_strategy',
                'type' => 'radio',
                'options' => [
                    ['value' => 'create_new', 'text' => 'create_new', 'id' => 'radio_create_new'],
                    ['value' => 'update_existing', 'text' => 'update', 'id' => 'radio_update'],
                    ['value' => 'delete', 'text' => 'delete', 'id' => 'radio_delete'],
                ],
            ]
        ],
        'submit' => [
            'action' => $this->request->getParam('action')
        ],
    ]
]);
?>

<div class="conflict-resolution-picker">
    <div class="mt-3 d-flex justify-content-center">
        <div class="btn-group justify-content-center" role="group" aria-label="Basic radio toggle button group">
            <?php if ($create_new_allowed) : ?>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" value="create_new" <?= $defaultStrategy == 'create_new' ? 'checked' : '' ?>>
                <label class="btn btn-outline-warning mw-<?= $maxWidth ?>" for="btnradio1">
                    <div>
                        <h5 class="mb-3">
                            <?= $defaultStrategy == 'create_new' ? $this->Bootstrap->badge(['text' => 'recommended', 'variant' => 'success', 'class' => ['mb-3', 'fs-8']]) : '' ?>
                            <?= __('Create new template') ?>
                        </h5>
                        <ul class="text-start fs-7">
                            <li><?= __('A new meta-template will be created and made default.') ?></li>
                            <li><?= __('The old meta-template will remain untouched.') ?></li>
                            <li><?= __('Migration of meta-fields to this newer template can be done manually via the UI.') ?></li>
                        </ul>
                    </div>
                </label>
            <?php endif; ?>

            <?php if ($update_allowed) : ?>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" value="update_existing" <?= $defaultStrategy == 'update_existing' ? 'checked' : '' ?>>
                <label class="btn btn-outline-primary mw-<?= $maxWidth ?>" for="btnradio2">
                    <div>
                        <div><?= $defaultStrategy == 'update_existing' ? $this->Bootstrap->badge(['text' => 'recommended', 'variant' => 'success', 'class' => ['mb-3']]) : '' ?></div>
                        <h5 class="mb-3">
                            <?= __('Update non-conflicting') ?>
                        </h5>
                        <ul class="text-start fs-7">
                            <li><?= __('Entities not having conflicts will have their meta-fields migrated to the new meta-template.') ?></li>
                            <li><?= __('Entities having a conflicts will stay on their current meta-template.') ?></li>
                            <li><?= __('Conflicts can be taken care of manually via the UI.') ?></li>
                        </ul>
                    </div>
                </label>
            <?php endif; ?>

            <?php if ($delete_all_allowed) : ?>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" value="delete" <?= $defaultStrategy == 'delete' ? 'checked' : '' ?>>
                <label class="btn btn-outline-danger mw-<?= $maxWidth ?>" for="btnradio3">
                    <div>
                        <h5 class="mb-3">
                            <?= $defaultStrategy == 'delete' ? $this->Bootstrap->badge(['text' => 'recommended', 'variant' => 'success', 'class' => ['mb-3', 'fs-8']]) : '' ?>
                            <?= __('Delete conflicting fields') ?>
                        </h5>
                        <ul class="text-start fs-7">
                            <li><?= __('Meta-fields not satisfying the new meta-template definition will be deleted.') ?></li>
                            <li><?= __('All other meta-fields will be upgraded to the new meta-template.') ?></li>
                        </ul>
                    </div>
                </label>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="d-none conflict-resolution-form-container">
    <?= $form ?>
</div>

<script>
    (function() {
        const $form = $('.conflict-resolution-form-container form')
        const $create = $form.find('input#radio_create_new')
        const $keep = $form.find('input#radio_update')
        const $delete = $form.find('input#radio_delete')

        $(document).ready(function() {
            $('.conflict-resolution-picker').find('input[type="radio"]').change(function() {
                updateSelected($(this).val())
            })
            updateSelected('<?= $defaultStrategy ?>')
        })

        function updateSelected(choice) {
            if (choice == 'update_existing') {
                $keep.prop('checked', true)
            } else if (choice == 'delete') {
                $delete.prop('checked', true)
            } else if (choice == 'create_new') {
                $create.prop('checked', true)
            }
        }
    }())
</script>