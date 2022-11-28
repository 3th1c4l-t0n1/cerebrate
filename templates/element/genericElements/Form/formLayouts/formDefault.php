<div class="col-12 mb-3">
    <h2 class="fw-light">
        <?= empty($data['title']) ? sprintf('%s %s', $actionName, $modelName) : h($data['title']) ?>
    </h2>
    <?= $formCreate ?>
    <?= $ajaxFlashMessage ?>
    <?php if (!empty($data['description'])) : ?>
        <div class="pb-3 fw-light">
            <?= h($data['description']) ?>
        </div>
    <?php endif; ?>
    <div class="panel col-lg-8">
        <?= $fieldsString ?>
    </div>

    <?php if (!empty($metaTemplateString)) : ?>
        <div class="col-lg-10">
            <?=
            $this->Bootstrap->accordion(
                [
                    'class' => 'mb-3'
                ],
                [
                    [
                        'open' => true,
                        'header' => [
                            'title' => __('Meta fields')
                        ],
                        'body' => $metaTemplateString,
                    ],
                ]
            );
            ?>
        </div>
    <?php endif; ?>
    <?= $this->element('genericElements/Form/submitButton', $submitButtonData); ?>
    <?= $formEnd; ?>
</div>